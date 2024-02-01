<?php

namespace PayPro\Endpoints;

class SubscriptionPeriods extends AbstractEndpoint
{
    use \PayPro\Operations\Collection;
    use \PayPro\Operations\Get;

    public function resourcePath()
    {
        return 'subscription_periods';
    }
}
