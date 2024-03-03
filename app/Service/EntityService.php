<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\Arr;
use App\Models\DbKeyMapper;
use App\Models\RemoteTable;
use App\Services\Contracts\DbalContract;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use stdClass;

class EntityService implements DbalContract
{
    private \Illuminate\Database\Connection $connection;
    private AbstractSchemaManager $schemaManager;

    public function __construct(string $connection)
    {
        $this->connection = DB::connection($connection);
        $this->schemaManager = $this->connection->getDoctrineSchemaManager();
    }

    /**
     * @throws Exception
     */
    public function getDatabaseDetails(): Schema
    {
        return $this->schemaManager->introspectSchema();
    }

    /**
     * @throws Exception
     */
    public function getTableDetails(string $table): Table
    {
        return $this->schemaManager->introspectTable($table);
    }

    /**
     * @throws Exception
     */
    public function getColumnsTable(string $table): array
    {
        return $this->schemaManager->listTableColumns($table);
    }

    /**
     * @throws Exception
     */
    public function getIndexes(string $table): array
    {
        return $this->getTableDetails($table)->getIndexes();
    }

    /**
     * @throws Exception
     */
    public function getForeignKeys(string $table): array
    {
        $foreignKeysArray = [];

        foreach ($this->schemaManager->listTableForeignKeys($table) as $foreignKey) {
            $foreignKeysArray[$foreignKey->getLocalColumns()[0]] = [
                'table' => $foreignKey->getForeignTableName(),
                'ownerKey' => $foreignKey->getForeignColumns()[0],
                'foreignKey' => $foreignKey->getLocalColumns()[0]
            ];
        }

        return $foreignKeysArray;
    }

    /**
     * @throws Exception
     */
    public function getColumnsWithForeign(
        Collection $mappers,
        stdClass $entity,
        string $table,
    ): Collection {
        $data = new Collection([]);

        $columns = $this->getColumnsTable($table);
        $foreignKeys = $this->getForeignKeys($table);
        $columns = Arr::arrayFilterValues($columns, $mappers->pluck('key_name')->toArray());

        foreach ($columns as $column) {
            $mapper = $mappers->where('key_name', $column->getName())->first();
            $values = $this->getValues($column, $entity, $foreignKeys);

            $columnsWithForeignArray = [
                'title' => $mapper->title,
                'is_photo' => $mapper->is_photo,
                'key' => $mapper->key_name,
                'required' => $column->getNotNull(),
                'type' => $mapper->type ?? $column->getType()->getName(),
            ];

            $data->push((object)array_merge($columnsWithForeignArray, $values));
        }

        return $data;
    }

    /**
     * @throws Exception
     * @throws ValidationException
     */
    public function validation(Request $request, Collection $mappers, string $table, int $entityId = null): array
    {
        $columns = $this->getColumnsTable($table);
        $foreignKeys = $this->getForeignKeys($table);
        $indexes = $this->getIndexes($table);

        $requestData = Arr::arrayFilterValues($request->all(), $mappers->pluck('key_name')->toArray());

        $rules = $this->createValidationRules($requestData, $columns, $foreignKeys, $indexes, $table, $entityId);

        /** @var Validator $validator */
        $currentConnection = DB::getDefaultConnection();
        DB::setDefaultConnection($this->connection->getDriverName());
        $validator = Validator::make($requestData, $rules);
        DB::setDefaultConnection($currentConnection);

        return $validator->validate();
    }

    protected function createValidationRules(
        array $requestData,
        array $columns,
        array $foreignKeys,
        array $indexes,
        string $table,
        int $entityId = null
    ): array {
        if ($entityId) {
            unset($requestData['id']);
        }

        $indexesKeys = [];

        foreach ($indexes as $index) {
            $indexesKeys[$index->getColumns()[0]] = $index->getName();
        }

        $rulesArray = [];

        foreach ($columns as $column) {
            if (!array_key_exists($key = $column->getName(), $requestData)) {
                continue;
            }

            if (!($column->getNotnull() !== true || $column->getDefault() !== null)) {
                $rulesArray[$key][] = 'required';
            }

            $type = $column->getType()->getName();
            if (in_array($type, ['bigint', 'integer'], true)) {
                $type = 'integer';
            }
            $rulesArray[$key][] = $type;

            if ($max = $column->getLength()) {
                $rulesArray[$key][] = 'max:' . $max;
            }

            if (array_key_exists($key, $indexesKeys)) {
                $index = $indexes[strtolower($indexesKeys[$key])];
                if ($index->isUnique()) {
                    $rulesArray[$key][] = "unique:$table,{$column->getName()}" . ($entityId ? ",$entityId" : "");
                }
            }

            if (array_key_exists($key, $foreignKeys)) {
                $foreignKey = $foreignKeys[$key];
                $rulesArray[$key][] = "exists:{$foreignKey['table']},{$foreignKey['ownerKey']}";
            }
        }

        return $rulesArray;
    }

    protected function getValues(Column $column, stdClass $entity, array $foreignKeys): array
    {
        $result = ['value' => $entity->{$column->getName()} ?? null];
        $foreignKey = $foreignKeys[$column->getName()] ?? [];

        if (!empty($foreignKey)) {
            $foreignValues = $this->getForeignValues($foreignKey);
            $result['values'] = $foreignValues?->toArray();
        }

        return $result;
    }

    protected function getForeignValues(array $keyArray): Collection
    {
        $table = $keyArray['table'];
        $foreignValues = $this->connection->table($table)->get();

        /** @var DbKeyMapper $mapper */
        $mapper = DbKeyMapper::query()
            ->whereIn(
                'remote_table_id',
                RemoteTable::query()
                    ->where('table', $table)
                    ->select('id')
            )
            ->where('is_remote_title', true)
            ->first();

        $foreignValues->transform(function ($item) use ($mapper) {
            return [
                'id' => $item->id,
                'title' => $item->{$mapper?->key_name} ?? null
            ];
        });

        return $foreignValues;
    }
}
