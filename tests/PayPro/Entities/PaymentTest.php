<?php

namespace PayPro\Entities;

use PayPro\TestCase;
use PayPro\TestHelper;

final class PaymentTest extends TestCase
{
    use TestHelper;

    public function testCancel()
    {
        $response = $this->getFixture('payments/get.json');
        $data = json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/payments/PPSKN6FAN8KNE1',
            null,
            null,
            null,
            $response
        );

        $payment = new Payment($data, $this->apiClient);

        $responsePayment = $payment->cancel();
        self::assertInstanceOf(Payment::class, $responsePayment);
    }

    public function testRefund()
    {
        $response = $this->getFixture('payments/refund.json');
        $data = json_decode($this->getFixture('payments/get.json'), true);

        $this->stubRequest(
            'post',
            '/payments/PPSKN6FAN8KNE1/refunds',
            null,
            null,
            ['amount' => 5000],
            $response,
            201
        );

        $payment = new Payment($data, $this->apiClient);

        $refund = $payment->refund(['amount' => 5000]);
        self::assertInstanceOf(Refund::class, $refund);
    }

    public function testRefunds()
    {
        $response = $this->getFixture('payments/refunds.json');
        $data = json_decode($this->getFixture('payments/get.json'), true);

        $this->stubRequest(
            'get',
            '/payments/PPSKN6FAN8KNE1/refunds',
            null,
            null,
            null,
            $response
        );

        $payment = new Payment($data, $this->apiClient);

        $refunds = $payment->refunds();
        self::assertInstanceOf(Collection::class, $refunds);
        self::assertInstanceOf(Refund::class, $refunds->first());
    }

    public function testChargebacks()
    {
        $response = $this->getFixture('payments/chargebacks.json');
        $data = json_decode($this->getFixture('payments/get.json'), true);

        $this->stubRequest(
            'get',
            '/payments/PPSKN6FAN8KNE1/chargebacks',
            null,
            null,
            null,
            $response
        );

        $payment = new Payment($data, $this->apiClient);

        $chargebacks = $payment->chargebacks();
        self::assertInstanceOf(Collection::class, $chargebacks);
        self::assertInstanceOf(Chargeback::class, $chargebacks->first());
    }
}
