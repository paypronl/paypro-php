<?php

namespace PayPro\Endpoints;

final class PaymentsTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

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

        $endpoint = new \PayPro\Endpoints\Payments($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\Payment::class, $list->first());
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

        $endpoint = new \PayPro\Endpoints\Payments($this->apiClient);
        $payment = $endpoint->get('PPSKN6FAN8KNE1');

        $this->assertInstanceOf(\PayPro\Entities\Payment::class, $payment);
        $this->assertSame($payment->id, 'PPSKN6FAN8KNE1');
        $this->assertSame($payment->description, 'Unlimited Subscription');
        $this->assertSame($payment->amount, 5000);
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

        $endpoint = new \PayPro\Endpoints\Payments($this->apiClient);
        $payment = $endpoint->create(['amount' => 5000]);

        $this->assertInstanceOf(\PayPro\Entities\Payment::class, $payment);
    }
}
