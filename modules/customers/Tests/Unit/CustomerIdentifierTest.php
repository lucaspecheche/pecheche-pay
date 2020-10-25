<?php

namespace Customers\Tests\Unit;

use Customers\Models\Customer;
use Customers\Rules\CustomerIdentifier;

class CustomerIdentifierTest extends \TestCase
{
    /** @var CustomerIdentifier */
    private $customerIdentifier;

    public function setUp(): void
    {
        parent::setUp();
        $this->customerIdentifier = $this->app->make(CustomerIdentifier::class);
    }

    /** @test */
    public function should_return_false_when_customer_id_not_exists_and_models_empty(): void
    {
        $result = $this->customerIdentifier->validate(null, 10, []);
        self::assertFalse($result);
    }

    /** @test */
    public function should_return_true_when_customer_id_exists_and_models_empty(): void
    {
        $customerId = Customer::factory()->create()->id;

        $result = $this->customerIdentifier->validate(null, $customerId, []);
        self::assertTrue($result);
    }

    /** @test */
    public function should_return_false_when_customer_is_not_contains_model_alloweds(): void
    {
        $customerId = Customer::factory()->withMerchant()->create()->id;
        $result = $this->customerIdentifier->validate(null, $customerId, ['users']);

        self::assertFalse($result);
    }

    /** @test */
    public function should_return_false_when_customer_contains_model_alloweds(): void
    {
        $customerId = Customer::factory()->withMerchant()->create()->id;
        $result = $this->customerIdentifier->validate(null, $customerId, ['merchants']);

        self::assertTrue($result);
    }
}
