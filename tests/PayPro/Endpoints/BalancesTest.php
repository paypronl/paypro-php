<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Balance;
use PayPro\Entities\Collection;
use PayPro\TestCase;
use PayPro\TestHelper;

final class BalancesTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('balances/list.json');

        $this->stubRequest(
            'get',
            '/balances',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Balances($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Balance::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('balances/get.json');

        $this->stubRequest(
            'get',
            '/balances/PBA7HA516X604D',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Balances($this->apiClient);
        $balance = $endpoint->get('PBA7HA516X604D');

        self::assertInstanceOf(Balance::class, $balance);
        self::assertSame($balance->id, 'PBA7HA516X604D');
        self::assertSame($balance->amount, 1000);
    }
}
