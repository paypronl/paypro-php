<?php

namespace PayPro\Endpoints;

use PayPro\Operations\Collection;
use PayPro\Operations\Get;

class SubscriptionPeriods extends AbstractEndpoint
{
    use Collection;
    use Get;

    public function resourcePath()
    {
        return 'subscription_periods';
    }
}
