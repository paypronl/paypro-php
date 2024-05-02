<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\InstallmentPlan;
use PayPro\TestCase;
use PayPro\TestHelper;

final class InstallmentPlansTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('installment_plans/list.json');

        $this->stubRequest(
            'get',
            '/installment_plans',
            null,
            null,
            null,
            $response
        );

        $endpoint = new InstallmentPlans($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(InstallmentPlan::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('installment_plans/get.json');

        $this->stubRequest(
            'get',
            '/installment_plans/PIV1QACRO4DSMQT0KK',
            null,
            null,
            null,
            $response
        );

        $endpoint = new InstallmentPlans($this->apiClient);
        $installmentPlan = $endpoint->get('PIV1QACRO4DSMQT0KK');

        self::assertInstanceOf(InstallmentPlan::class, $installmentPlan);
        self::assertSame($installmentPlan->id, 'PIV1QACRO4DSMQT0KK');
        self::assertSame($installmentPlan->description, 'Test installment plan');
        self::assertEqualsCanonicalizing($installmentPlan->period, ['amount' => 1000, 'interval' => 'month', 'multiplier' => 1, 'vat' => 21.0]);
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('installment_plans/get.json');

        $this->stubRequest(
            'post',
            '/installment_plans',
            null,
            null,
            ['description' => 'Test installment plan'],
            $response,
            201
        );

        $endpoint = new InstallmentPlans($this->apiClient);
        $installmentPlan = $endpoint->create(['description' => 'Test installment plan']);

        self::assertInstanceOf(InstallmentPlan::class, $installmentPlan);
    }
}
