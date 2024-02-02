<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Refund;
use PayPro\TestCase;
use PayPro\TestHelper;

final class RefundsTest extends TestCase
{
    use TestHelper;

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

        $endpoint = new Refunds($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertInstanceOf(Refund::class, $list->first());
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

        $endpoint = new Refunds($this->apiClient);
        $refund = $endpoint->get('PRNAUYTZ727UED');

        $this->assertInstanceOf(Refund::class, $refund);
        $this->assertSame($refund->id, 'PRNAUYTZ727UED');
        $this->assertSame($refund->description, 'Test Payment');
        $this->assertSame($refund->refunded_at, null);
    }
}
