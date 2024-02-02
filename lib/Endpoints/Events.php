<?php

namespace PayPro\Endpoints;

use PayPro\Operations\Collection;
use PayPro\Operations\Get;

class Events extends AbstractEndpoint
{
    use Collection;
    use Get;

    public function resourcePath()
    {
        return 'events';
    }
}
