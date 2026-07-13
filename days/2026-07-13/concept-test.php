<?php

use PHPUnit\Framework\TestCase;

class ErrorBagHandlerTest extends TestCase
{
    public function testDatabaseConnectionError()
    {
        $errorBag = new \Illuminate\Support\MessageBag();

        $this->instanceOf(ErrorBagHandler::class, ErrorBagHandler::class);
        $this->assertEquals(1, $errorBag->count());
        $this->assertEquals('database', $errorBag->firstKey());
    }

    public function testDatabaseQueryError()
    {
        $errorBag = new \Illuminate\Support\MessageBag();

        DB::connection()->getPdo()->queryException(new \PDOException());

        $this->instanceOf(ErrorBagHandler::class, ErrorBagHandler::class);
        $this->assertEquals(1, $errorBag->count());
        $this->assertEquals('database', $errorBag->firstKey());
    }
}