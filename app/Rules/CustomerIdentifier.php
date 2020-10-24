<?php

namespace App\Rules;

use App\Models\Customer;
use Illuminate\Validation\Rule;

class CustomerIdentifier extends Rule
{
    public function validate($attribute, $value, $params): bool
    {
        $customer = $this->getCustomerByValue($value);

        if (empty($params) || !$customer) {
            return (bool) $customer;
        }

        if($model = $customer->getType()) {
            return class_exists($model)
                ? $this->isSameModel($model, $params)
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
