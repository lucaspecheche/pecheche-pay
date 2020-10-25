<?php

namespace Transactions\Transfer\Tests\Feature;

use App\Http\Controllers\Controller;
use Customers\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;

/**
 * @property TestResponse $response
 */
class TransferFeatureRulesTest extends \TestCase
{
    private const TRANSFER_ROUTER = 'v1/transactions/transfer';

    /** @test */
    public function should_return_422_when_value_is_not_numeric(): void
    {
        $payer = Customer::factory()->create();
        $payee = Customer::factory()->create();

        $this->assertRules([
            'value' => 'TEST',
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);
    }

    /** @test */
    public function should_return_422_when_value_is_null(): void
    {
        $payer = Customer::factory()->create();
        $payee = Customer::factory()->create();

        $this->assertRules([
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);
    }

    private function assertRules(array $attributes): void
    {
        $this->post(self::TRANSFER_ROUTER, $attributes);

        $this->response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->response->assertJson([
            'shortMessage' => Controller::INVALID_DATA
        ]);
    }
}
