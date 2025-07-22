<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ConnectionDB2Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testDatabaseConnection()
    {
        try {
            DB::connection('db2')->getPdo();
            $this->assertTrue(true); // Connection successful
        } catch (\Exception $e) {
            $this->fail("Could not connect to the database. Error: " . $e->getMessage());
        }
    }
}
