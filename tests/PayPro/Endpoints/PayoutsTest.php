<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Payout;
use PayPro\TestCase;
use PayPro\TestHelper;

final class PayoutsTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('payouts/list.json');

        $this->stubRequest(
            'get',
            '/payouts',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Payouts($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Payout::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('payouts/get.json');

        $this->stubRequest(
            'get',
            '/payouts/POKHCDCQPS4GAA',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Payouts($this->apiClient);
        $payout = $endpoint->get('POKHCDCQPS4GAA');

        self::assertInstanceOf(Payout::class, $payout);
        self::assertSame($payout->id, 'POKHCDCQPS4GAA');
        self::assertSame($payout->description, 'Payout #1');
        self::assertSame($payout->amount, 12300);
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('payouts/get.json');

        $this->stubRequest(
            'post',
            '/payouts',
            null,
            null,
            ['amount' => 12300],
            $response,
            201
        );

        $endpoint = new Payouts($this->apiClient);
        $payout = $endpoint->create(['amount' => 12300]);

        self::assertInstanceOf(Payout::class, $payout);
    }
}
