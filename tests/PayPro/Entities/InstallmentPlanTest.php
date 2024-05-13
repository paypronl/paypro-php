<?php

namespace PayPro\Entities;

use PayPro\TestCase;
use PayPro\TestHelper;

final class InstallmentPlanTest extends TestCase
{
    use TestHelper;

    public function testUpdate()
    {
        $response = $this->getFixture('installment_plans/get.json');
        $data = json_decode($response, true);

        $this->stubRequest(
            'patch',
            '/installment_plans/PIV1QACRO4DSMQT0KK',
            null,
            null,
            ['description' => 'Limited InstallmentPlan'],
            $response
        );

        $installment_plan = new InstallmentPlan($data, $this->apiClient);

        $responseInstallmentPlan = $installment_plan->update(['description' => 'Limited InstallmentPlan']);
        self::assertInstanceOf(InstallmentPlan::class, $responseInstallmentPlan);
    }

    public function testCancel()
    {
        $response = $this->getFixture('installment_plans/get.json');
        $data = json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/installment_plans/PIV1QACRO4DSMQT0KK',
            null,
            null,
            null,
            $response
        );

        $installmentPlan = new InstallmentPlan($data, $this->apiClient);

        $responseInstallmentPlan = $installmentPlan->cancel();
        self::assertInstanceOf(InstallmentPlan::class, $responseInstallmentPlan);
    }

    public function testPause()
    {
        $response = $this->getFixture('installment_plans/get.json');
        $data = json_decode($response, true);

        $this->stubRequest(
            'post',
            '/installment_plans/PIV1QACRO4DSMQT0KK/pause',
            null,
            null,
            null,
            $response
        );

        $installmentPlan = new InstallmentPlan($data, $this->apiClient);

        $responseInstallmentPlan = $installmentPlan->pause();
        self::assertInstanceOf(InstallmentPlan::class, $responseInstallmentPlan);
    }

    public function testResume()
    {
        $response = $this->getFixture('installment_plans/get.json');
        $data = json_decode($response, true);

        $this->stubRequest(
            'post',
            '/installment_plans/PIV1QACRO4DSMQT0KK/resume',
            null,
            null,
            null,
            $response
        );

        $installmentPlan = new InstallmentPlan($data, $this->apiClient);

        $responseInstallmentPlan = $installmentPlan->resume();
        self::assertInstanceOf(InstallmentPlan::class, $responseInstallmentPlan);
    }

    public function testInstallmentPlanPeriods()
    {
        $response = $this->getFixture('installment_plans/installment_plan_periods.json');
        $data = json_decode($this->getFixture('installment_plans/get.json'), true);

        $this->stubRequest(
            'get',
            '/installment_plans/PIV1QACRO4DSMQT0KK/installment_plan_periods',
            null,
            null,
            null,
            $response
        );

        $installmentPlan = new InstallmentPlan($data, $this->apiClient);

        $installmentPlanPeriods = $installmentPlan->installmentPlanPeriods();
        self::assertInstanceOf(Collection::class, $installmentPlanPeriods);
        self::assertInstanceOf(InstallmentPlanPeriod::class, $installmentPlanPeriods->first());
    }
}
