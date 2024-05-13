<?php

namespace PayPro\Endpoints;

use PayPro\Entities\InstallmentPlanPeriod;
use PayPro\TestCase;
use PayPro\TestHelper;

final class InstallmentPlanPeriodsTest extends TestCase
{
    use TestHelper;

    public function testIsGettable()
    {
        $response = $this->getFixture('installment_plan_periods/get.json');

        $this->stubRequest(
            'get',
            '/installment_plan_periods/IPD344S1PDY8XX',
            null,
            null,
            null,
            $response
        );

        $endpoint = new InstallmentPlanPeriods($this->apiClient);
        $installment_plan_period = $endpoint->get('IPD344S1PDY8XX');

        self::assertInstanceOf(InstallmentPlanPeriod::class, $installment_plan_period);
        self::assertSame($installment_plan_period->id, 'IPD344S1PDY8XX');
        self::assertSame($installment_plan_period->period_number, 1);
        self::assertSame($installment_plan_period->amount, 1500);
    }
}
