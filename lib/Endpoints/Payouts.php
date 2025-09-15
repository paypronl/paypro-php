<?php

namespace PayPro\Endpoints;

use PayPro\Operations\Collection;
use PayPro\Operations\Create;
use PayPro\Operations\Get;

class Payouts extends AbstractEndpoint
{
    use Collection;
    use Create;
    use Get;

    public function resourcePath()
    {
        return 'payouts';
    }
}
