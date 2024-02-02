<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Chargeback;
use PayPro\Entities\Collection;
use PayPro\TestCase;
use PayPro\TestHelper;

final class ChargebacksTest extends TestCase
{
    use TestHelper;

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

        $endpoint = new Chargebacks($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertInstanceOf(Chargeback::class, $list->first());
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

        $endpoint = new Chargebacks($this->apiClient);
        $chargeback = $endpoint->get('PCV4U1P3UZTQPU');

        $this->assertInstanceOf(Chargeback::class, $chargeback);
        $this->assertSame($chargeback->id, 'PCV4U1P3UZTQPU');
        $this->assertSame($chargeback->reason, 'MD06');
    }
}
