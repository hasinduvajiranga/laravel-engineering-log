<?php

use Illuminate\Support\MessageBag;
use PHPUnit\Framework\TestCase;

class ErrorBagHandlerTest extends TestCase
{
    public function test_database_connection_error()
    {
        $errorBag = new MessageBag;

        $this->instanceOf(ErrorBagHandler::class, ErrorBagHandler::class);
        $this->assertEquals(1, $errorBag->count());
        $this->assertEquals('database', $errorBag->firstKey());
    }

    public function test_database_query_error()
    {
        $errorBag = new MessageBag;

        DB::connection()->getPdo()->queryException(new PDOException);

        $this->instanceOf(ErrorBagHandler::class, ErrorBagHandler::class);
        $this->assertEquals(1, $errorBag->count());
        $this->assertEquals('database', $errorBag->firstKey());
    }
}
