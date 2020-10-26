<?php

namespace Transactions\Tests\Unit;

use Transactions\Connections\Inform\InformConnection;
use Transactions\Exceptions\ConnectionExceptions;
use Transactions\Tests\Mocks\InformMock;

class InformConnectionTest extends \TestCase
{
    /** @test */
    public function should_send_message(): void
    {
        self::assertTrue($this->inform()->send('Testing...'));
    }


    /** @test */
    public function should_throw_exception_when_send_message_error(): void
    {
        $this->expectException(ConnectionExceptions::class);
        $this->inform()->send(InformMock::INFORM_MESSAGE_ERROR);
    }

    private function inform(): InformConnection
    {
        return $this->app->make(InformConnection::class);
    }
}
