<?php

namespace Transactions\Transfer\Tests\Unit;

use Faker\Factory;
use Mockery;
use Transactions\Connections\Gateway\GatewayConnection;
use Transactions\Constants\Status;
use Transactions\Models\Transaction;
use Transactions\Transfer\Services\TransferService;
use Wallets\Contracts\WalletServiceInterface;
use Wallets\Exceptions\WalletExceptions;
use Wallets\Models\Wallet;

class TransferServiceTest extends \TestCase
{
    /** @test */
    public function should_transfer_correct_value(): void
    {
        $payerWallet = Wallet::factory()->withUser()->create([
            'balance' => $this->randMoney(200, 300)
        ]);

        $payeeWallet = Wallet::factory()->withUser()->create([
            'balance' => $this->randMoney(0, 1000)
        ]);

        $transaction = Transaction::factory()
            ->withPayer($payerWallet->customer)
            ->withPayee($payeeWallet->customer)
            ->create(['value' => $this->randMoney(0, 200)]);

        $expectedPayer = $payerWallet->balance - $transaction->value;
        $expectedPayee = $payeeWallet->balance + $transaction->value;

        $this->service()->submit($transaction);

        self::assertEquals(Status::COMPLETED, $transaction->status);
        self::assertEquals($expectedPayer, $payerWallet->refresh()->balance);
        self::assertEquals($expectedPayee, $payeeWallet->refresh()->balance);
    }

    /** @test **/
    public function should_throw_exception_when_balance_not_available(): void
    {
        $payerWallet = Wallet::factory()->withUser()->create([
            'balance' => 100.00
        ]);

        $payeeWallet = Wallet::factory()->withUser()->create();

        $transaction = Transaction::factory()
            ->withPayer($payerWallet->customer)
            ->withPayee($payeeWallet->customer)
            ->create(['value' => 200.00]);

        $this->expectExceptionCode('insufficientFunds');
        $this->service()->submit($transaction);
    }

    /** @test */
    public function should_throw_exception_when_gateway_unauthorized(): void
    {
        $transaction = $this->buildTransaction();

        $mockConnection = Mockery::mock(GatewayConnection::class);
        $mockConnection->shouldReceive('transferIsAuthorized')
            ->with($transaction)
            ->andReturnFalse();

        $this->app->instance(GatewayConnection::class, $mockConnection);

        $this->expectExceptionCode('unauthorized');
        $this->service()->submit($transaction);
    }

    /** @test */
    public function should_debit_credit_and_update_transaction(): void
    {
        $transaction = $this->buildTransaction();

        $mockService = Mockery::mock(WalletServiceInterface::class)->makePartial();
        $mockService
            ->shouldReceive('debit')
            ->once()
            ->with($transaction->payer, $transaction->value)
            ->andReturnNull();

        $mockService
            ->shouldReceive('hasAvailableBalance')
            ->once()
            ->andReturnTrue();

        $mockService
            ->shouldReceive('credit')
            ->once()
            ->andReturnTrue();

        $this->app->instance(WalletServiceInterface::class, $mockService);
        $this->service()->submit($transaction);

        $this->assertEquals(Status::COMPLETED, $transaction->refresh()->status);
    }

    /** @test */
    public function should_refund_when_throw_exceptions(): void
    {
        $transaction = $this->buildTransaction();

        $mockService = Mockery::mock(WalletServiceInterface::class)->makePartial();

        $mockService
            ->shouldReceive('hasAvailableBalance')
            ->once()
            ->andReturnTrue();

        $mockService
            ->shouldReceive('debit')
            ->once()
            ->with($transaction->payer, $transaction->value)
            ->andReturnNull();

        $mockService
            ->shouldReceive('credit')
            ->once()
            ->andThrow(WalletExceptions::creditError());

        $mockService
            ->shouldReceive('refund')
            ->once()
            ->andReturnNull();

        $this->app->instance(WalletServiceInterface::class, $mockService);

        try {
            $this->service()->submit($transaction);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(WalletExceptions::class, $exception);
            $this->assertEquals(Status::REFUNDED, $transaction->status);
        }
    }

    private function buildTransaction(): Transaction
    {
        $payerWallet = Wallet::factory()->withUser()->create([
            'balance' => 100.00
        ]);

        $payeeWallet = Wallet::factory()->withUser()->create();

        return Transaction::factory()
            ->withPayer($payerWallet->customer)
            ->withPayee($payeeWallet->customer)
            ->create(['value' => 50.00]);
    }

    private function service(): TransferService
    {
        return $this->app->make(TransferService::class);
    }

    private function randMoney(int $min, int $max): float
    {
        return Factory::create()->randomFloat(2, $min, $max);
    }
}
