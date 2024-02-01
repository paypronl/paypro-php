<?php

namespace PayPro\Endpoints;

class Webhooks extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Create;
    use \PayPro\Operations\Get;
    use \PayPro\Operations\Update;

    public function resourcePath()
    {
        return 'webhooks';
    }
}
