<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use Illuminate\Support\Collection;
use stdClass;

interface DbalContract
{
    public function getColumnsTable(string $table): array;

    public function getForeignKeys(string $table): array;

    public function getColumnsWithForeign(
        Collection $mappers,
        stdClass $entity,
        string $table
    ): Collection;
}
