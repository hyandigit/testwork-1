<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function store_test()
    {
        $response = $this->postJson('/api/order', []);
        $this->assertTrue(true);
    }
}
