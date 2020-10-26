<?php

namespace Transactions\Tests\Unit;

use Transactions\Connections\Gateway\GatewayConnection;
use Transactions\Models\Transaction;
use Transactions\Tests\Mocks\GatewayMock;

class GatewayConnectionTest extends \TestCase
{
    /** @test */
    public function should_return_true_when_gateway_authorize(): void
    {
        $transaction = Transaction::factory()->make();
        $result      = $this->gateway()->transferIsAuthorized($transaction);

        self::assertTrue($result);
    }

    /** @test */
    public function should_return_false_when_gateway_unauthorized(): void
    {
        $transaction = Transaction::factory()->make([
            'id' => GatewayMock::TRANSACTION_ID_ERROR
        ]);

        $result = $this->gateway()->transferIsAuthorized($transaction);
        self::assertFalse($result);
    }

    private function gateway(): GatewayConnection
    {
        return $this->app->make(GatewayConnection::class);
    }
}
