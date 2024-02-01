<?php

namespace PayPro\Endpoints;

class Payments extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Create;
    use \PayPro\Operations\Get;

    public function resourcePath()
    {
        return 'payments';
    }
}
