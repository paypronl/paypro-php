<?php

namespace PayPro\Endpoints;

use PayPro\Operations\Collection;
use PayPro\Operations\Create;
use PayPro\Operations\Get;
use PayPro\Operations\Update;

class Webhooks extends AbstractEndpoint
{
    use Collection;
    use Create;
    use Get;
    use Update;

    public function resourcePath()
    {
        return 'webhooks';
    }
}
