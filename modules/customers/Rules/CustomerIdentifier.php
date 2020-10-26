<?php

namespace Customers\Rules;

use Customers\Models\Customer;
use Illuminate\Validation\Rule;

class CustomerIdentifier extends Rule
{
    public function validate($attribute, $value, $models): bool
    {
        $customer = $this->getCustomerByValue($value);

        if (empty($models) || !$customer) {
            return (bool) $customer;
        }

        $model = $customer->getType();

        if($model) {
            return class_exists($model)
                ? $this->isSameModel($model, $models)
                : false;
        }

        return false;
    }

    private function isSameModel(string $model, $params): bool
    {
         $tableName = app($model)->getTable();
         return in_array($tableName, $params, true);
    }

    private function getCustomerByValue($value): ?Customer
    {
        return Customer::query()->find($value);
    }
}
