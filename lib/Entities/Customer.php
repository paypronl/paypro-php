<?php

namespace PayPro\Entities;

class Customer extends Resource
{
    use \PayPro\Operations\Delete;
    use \PayPro\Operations\Request;
    use \PayPro\Operations\Update;

    public function resourcePath()
    {
        return 'customers';
    }
}
