<?php

namespace PayPro\Endpoints;

final class ChargebacksTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('chargebacks/list.json');

        $this->stubRequest(
            'get',
            '/chargebacks',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Chargebacks($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\Chargeback::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('chargebacks/get.json');

        $this->stubRequest(
            'get',
            '/chargebacks/PCV4U1P3UZTQPU',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Chargebacks($this->apiClient);
        $chargeback = $endpoint->get('PCV4U1P3UZTQPU');

        $this->assertInstanceOf(\PayPro\Entities\Chargeback::class, $chargeback);
        $this->assertSame($chargeback->id, 'PCV4U1P3UZTQPU');
        $this->assertSame($chargeback->reason, 'MD06');
    }
}
