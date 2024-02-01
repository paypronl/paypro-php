<?php

namespace PayPro\Endpoints;

final class RefundsTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('refunds/list.json');

        $this->stubRequest(
            'get',
            '/refunds',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Refunds($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\Refund::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('refunds/get.json');

        $this->stubRequest(
            'get',
            '/refunds/PRNAUYTZ727UED',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Refunds($this->apiClient);
        $refund = $endpoint->get('PRNAUYTZ727UED');

        $this->assertInstanceOf(\PayPro\Entities\Refund::class, $refund);
        $this->assertSame($refund->id, 'PRNAUYTZ727UED');
        $this->assertSame($refund->description, 'Test Payment');
        $this->assertSame($refund->refunded_at, null);
    }
}
