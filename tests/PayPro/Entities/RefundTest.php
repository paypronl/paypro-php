<?php

namespace PayPro\Entities;

use PayPro\TestCase;
use PayPro\TestHelper;

final class RefundTest extends TestCase
{
    use TestHelper;

    public function testCancel()
    {
        $response = $this->getFixture('refunds/get.json');
        $data = json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/refunds/PRNAUYTZ727UED',
            null,
            null,
            null,
            $response
        );

        $refund = new Refund($data, $this->apiClient);

        $responseRefund = $refund->cancel();
        self::assertInstanceOf(Refund::class, $responseRefund);
    }
}
