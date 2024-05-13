<?php

namespace PayPro\Endpoints;

use PayPro\Operations\Collection;

class PayMethods extends AbstractEndpoint
{
    use Collection;

    public function resourcePath()
    {
        return 'pay_methods';
    }
}
