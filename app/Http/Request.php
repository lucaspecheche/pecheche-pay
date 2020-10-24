<?php

namespace App\Http;

use App\Models\DataObject;

class Request extends \Illuminate\Http\Request
{
    public function getObj(): DataObject
    {
        return DataObject::new($this->toArray());
    }

}
