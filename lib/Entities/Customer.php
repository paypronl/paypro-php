<?php

namespace PayPro\Entities;

use PayPro\Operations\Delete;
use PayPro\Operations\Request;
use PayPro\Operations\Update;

class Customer extends Resource
{
    use Delete;
    use Request;
    use Update;

    public function resourcePath()
    {
        return 'customers';
    }
}
