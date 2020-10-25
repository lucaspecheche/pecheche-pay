<?php

namespace Transactions\Transfer\Tests\Feature;

use Customers\Models\Customer;
use Illuminate\Support\Facades\Queue;
use Illuminate\Testing\TestResponse;
use Transactions\Constants\Types;
use Transactions\Helpers\TransactionConfig;
use Transactions\Transfer\Jobs\TransferJob;
use Transactions\Transfer\Tests\Helper\TransferRoutes;
use Wallets\Models\Wallet;

/**
 * @property TestResponse $response
 */
class TransferFeatureTest extends \TestCase
{
    /** @test */
    public function should_dispatch_async_transaction()
    {
        Queue::fake();
        config(['transaction.async' => 1]);

        $payer = Wallet::factory()->create([
            'balance' => 100.00
        ]);

        $payee = Wallet::factory()->create();

        $this->post(TransferRoutes::V1, [
            'value' => 50.00,
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);

        Queue::assertPushedOn(Types::TRANSFER, TransferJob::class);
    }
}
