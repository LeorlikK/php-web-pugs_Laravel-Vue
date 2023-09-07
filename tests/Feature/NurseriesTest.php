<?php

use App\Models\Nurseries;
use Database\Seeders\TestNurseriesSeeder;
use Tests\TestCase;

class NurseriesTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestNurseriesSeeder::class);
    }

    public function test_paginate()
    {
        $page = 2;

        $response = $this->get("/api/nurseries/{$page}");

        $response->assertOk();
        $this->assertJson($response->getContent());
        $responseObject = json_decode($response->getContent());
        $this->assertIsObject($responseObject);
        $this->assertObjectHasProperty('links', $responseObject);
        $this->assertObjectHasProperty('per_page', $responseObject->meta);
        $this->assertObjectHasProperty('current_page', $responseObject->meta);
        $this->assertObjectHasProperty('last_page', $responseObject->meta);
        $this->assertObjectHasProperty('to', $responseObject->meta);
        $this->assertObjectHasProperty('total', $responseObject->meta);
        $this->assertEquals($page, $responseObject->meta->current_page);
    }
}
