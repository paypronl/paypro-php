<?php

namespace PayPro\Entities;

use PayPro\TestCase;
use PayPro\TestHelper;

final class InstallmentPlanPeriodTest extends TestCase
{
    use TestHelper;

    public function testPayments()
    {
        $response = $this->getFixture('installment_plan_periods/payments.json');
        $data = json_decode($this->getFixture('installment_plan_periods/get.json'), true);

        $this->stubRequest(
            'get',
            '/installment_plan_periods/IPD344S1PDY8XX/payments',
            null,
            null,
            null,
            $response
        );

        $installmentPlanPeriods = new InstallmentPlanPeriod($data, $this->apiClient);

        $payments = $installmentPlanPeriods->payments();
        self::assertInstanceOf(Collection::class, $payments);
        self::assertInstanceOf(Payment::class, $payments->first());
    }
}
