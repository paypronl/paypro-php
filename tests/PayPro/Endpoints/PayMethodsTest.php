<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\PayMethod;
use PayPro\TestCase;
use PayPro\TestHelper;

final class PayMethodsTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('pay_methods/list.json');

        $this->stubRequest(
            'get',
            '/pay_methods',
            null,
            null,
            null,
            $response
        );

        $endpoint = new PayMethods($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(PayMethod::class, $list->first());
    }
}
