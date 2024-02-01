<?php

namespace PayPro\Entities;

final class RefundTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testCancel()
    {
        $response = $this->getFixture('refunds/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/refunds/PRNAUYTZ727UED',
            null,
            null,
            null,
            $response
        );

        $refund = new \PayPro\Entities\Refund($data, $this->apiClient);

        $responseRefund = $refund->cancel();
        $this->assertInstanceOf(\PayPro\Entities\Refund::class, $responseRefund);
    }
}
