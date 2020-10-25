<?php

namespace Customers\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public function getName(): string
    {
        return implode(' ', [$this->first_name, $this->last_name]);
    }
}
