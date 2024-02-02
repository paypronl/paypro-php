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

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Refund::class, $list->first());
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

        self::assertInstanceOf(Refund::class, $refund);
        self::assertSame($refund->id, 'PRNAUYTZ727UED');
        self::assertSame($refund->description, 'Test Payment');
        self::assertSame($refund->refunded_at, null);
    }
}
