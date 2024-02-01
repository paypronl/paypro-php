<?php

namespace PayPro\Endpoints;

class Refunds extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Get;

    public function resourcePath()
    {
        return 'refunds';
    }
}
