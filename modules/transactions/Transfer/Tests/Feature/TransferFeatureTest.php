<?php

namespace Transactions\Transfer\Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Testing\TestResponse;
use Transactions\Constants\Status;
use Transactions\Constants\Types;
use Transactions\Transfer\Events\TransferCompleted;
use Transactions\Transfer\Jobs\TransferJob;
use Transactions\Transfer\Tests\Helper\TransferRoutes;
use Wallets\Models\Wallet;

/**
 * @property TestResponse $response
 */
class TransferFeatureTest extends \TestCase
{
    /** @test */
    public function should_dispatch_async_transaction(): void
    {
        Queue::fake();
        Event::fake();
        config(['transaction.async' => 1]);

        $payerWallet = Wallet::factory()->withUser()->create([
            'balance' => 100.00
        ]);

        $payeeWallet = Wallet::factory()->withUser()->create();

        $this->post(TransferRoutes::V1, [
            'value' => 50.00,
            'payer' => $payerWallet->customer->id,
            'payee' => $payeeWallet->customer->id
        ]);

        $this->response->assertJson([
            'artifacts' => [
                'status' => Status::CREATED
            ]
        ]);

        Queue::assertPushedOn(Types::TRANSFER, TransferJob::class);
        Event::assertNotDispatched(TransferCompleted::class);

        $this->assertResponseStatus(Response::HTTP_CREATED);
    }

    /** @test */
    public function should_dispatch_sync_transaction(): void
    {
        Queue::fake();
        Event::fake();

        config(['transaction.async' => 0]);

        $payerWallet = Wallet::factory()->withUser()->create([
            'balance' => 100.00
        ]);

        $payeeWallet = Wallet::factory()->withUser()->create();

        $this->post(TransferRoutes::V1, [
            'value' => 50.00,
            'payer' => $payerWallet->customer->id,
            'payee' => $payeeWallet->customer->id
        ]);

        $this->response->assertJson([
            'artifacts' => [
                'status' => Status::COMPLETED
            ]
        ]);

        $this->assertResponseOk();

        Queue::assertNotPushed(TransferJob::class);
        Event::assertDispatched(TransferCompleted::class);
    }

    /** @test */
    public function should_return_422_when_payer_not_has_available_balance(): void
    {
        $payerWallet = Wallet::factory()->withUser()->create([
            'balance' => 100.00
        ]);

        $payeeWallet = Wallet::factory()->withUser()->create();

        $this->post(TransferRoutes::V1, [
            'value' => 200.00,
            'payer' => $payerWallet->customer->id,
            'payee' => $payeeWallet->customer->id
        ]);

        $this->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->response->assertJson([
            'shortMessage' => 'insufficientFunds'
        ]);
    }
}
