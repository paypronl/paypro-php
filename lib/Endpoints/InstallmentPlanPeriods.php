<?php

namespace PayPro\Endpoints;

use PayPro\Operations\Get;

class InstallmentPlanPeriods extends AbstractEndpoint
{
    use Get;

    public function resourcePath()
    {
        return 'installment_plan_periods';
    }
}
