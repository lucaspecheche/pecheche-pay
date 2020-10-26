<?php

namespace Transactions\Transfer\Tests\Feature;

use App\Http\Controllers\Controller;
use Customers\Models\Customer;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Transactions\Transfer\Tests\Helper\TransferRoutes;

/**
 * @property TestResponse $response
 */
class TransferFeatureRulesTest extends \TestCase
{

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
    public function should_return_422_when_value_required(): void
    {
        $payer = Customer::factory()->create();
        $payee = Customer::factory()->create();

        $this->assertRules([
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);
    }

    /** @test */
    public function should_return_422_when_payer_is_merchant(): void
    {
        $payer = Customer::factory()->withMerchant()->create();
        $payee = Customer::factory()->create();

        $this->assertRules([
            'value' => 100,
            'payer' => $payer->id,
            'payee' => $payee->id
        ]);
    }

    /** @test */
    public function should_return_422_when_payee_not_exists(): void
    {
        $payer = Customer::factory()->create();

        $this->assertRules([
            'value' => 100,
            'payer' => $payer->id,
            'payee' => 9999999
        ]);
    }

    private function assertRules(array $attributes): void
    {
        $this->post(TransferRoutes::V1, $attributes);

        $this->response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->response->assertJson([
            'shortMessage' => Controller::INVALID_DATA
        ]);
    }
}
