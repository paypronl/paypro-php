<?php

namespace PayPro\Endpoints;

class Chargebacks extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Get;

    public function resourcePath()
    {
        return 'chargebacks';
    }
}
