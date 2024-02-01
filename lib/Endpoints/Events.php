<?php

namespace PayPro\Endpoints;

class Events extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Get;

    public function resourcePath()
    {
        return 'events';
    }
}
