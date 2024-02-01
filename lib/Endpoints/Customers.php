<?php

namespace PayPro\Endpoints;

class Customers extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Create;
    use \PayPro\Operations\Get;

    public function resourcePath()
    {
        return 'customers';
    }
}
