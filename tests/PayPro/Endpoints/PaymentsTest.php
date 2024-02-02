<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Payment;
use PayPro\TestCase;
use PayPro\TestHelper;

final class PaymentsTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('payments/list.json');

        $this->stubRequest(
            'get',
            '/payments',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Payments($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Payment::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('payments/get.json');

        $this->stubRequest(
            'get',
            '/payments/PPSKN6FAN8KNE1',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Payments($this->apiClient);
        $payment = $endpoint->get('PPSKN6FAN8KNE1');

        self::assertInstanceOf(Payment::class, $payment);
        self::assertSame($payment->id, 'PPSKN6FAN8KNE1');
        self::assertSame($payment->description, 'Unlimited Subscription');
        self::assertSame($payment->amount, 5000);
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('payments/get.json');

        $this->stubRequest(
            'post',
            '/payments',
            null,
            null,
            ['amount' => 5000],
            $response,
            201
        );

        $endpoint = new Payments($this->apiClient);
        $payment = $endpoint->create(['amount' => 5000]);

        self::assertInstanceOf(Payment::class, $payment);
    }
}
