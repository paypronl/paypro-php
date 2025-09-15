<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\TopUp;
use PayPro\TestCase;
use PayPro\TestHelper;

final class TopUpsTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('top_ups/list.json');

        $this->stubRequest(
            'get',
            '/top_ups',
            null,
            null,
            null,
            $response
        );

        $endpoint = new TopUps($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(TopUp::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('top_ups/get.json');

        $this->stubRequest(
            'get',
            '/top_ups/TUMKR465ZG6QDU',
            null,
            null,
            null,
            $response
        );

        $endpoint = new TopUps($this->apiClient);
        $topUp = $endpoint->get('TUMKR465ZG6QDU');

        self::assertInstanceOf(TopUp::class, $topUp);
        self::assertSame($topUp->id, 'TUMKR465ZG6QDU');
        self::assertSame($topUp->description, 'Top-up TUMKR465ZG6QDU');
        self::assertSame($topUp->amount, 12300);
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('top_ups/get.json');

        $this->stubRequest(
            'post',
            '/top_ups',
            null,
            null,
            ['amount' => 12300],
            $response,
            201
        );

        $endpoint = new TopUps($this->apiClient);
        $topUp = $endpoint->create(['amount' => 12300]);

        self::assertInstanceOf(TopUp::class, $topUp);
    }
}
