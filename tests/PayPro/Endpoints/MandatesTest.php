<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Mandate;
use PayPro\TestCase;
use PayPro\TestHelper;

final class MandatesTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('mandates/list.json');

        $this->stubRequest(
            'get',
            '/mandates',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Mandates($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Mandate::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('mandates/get.json');

        $this->stubRequest(
            'get',
            '/mandates/MD6ULYXJ4HP9RJ',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Mandates($this->apiClient);
        $mandate = $endpoint->get('MD6ULYXJ4HP9RJ');

        self::assertInstanceOf(Mandate::class, $mandate);
        self::assertSame($mandate->id, 'MD6ULYXJ4HP9RJ');
        self::assertSame($mandate->state, 'approved');
        self::assertSame($mandate->customer, 'CUWSWVVPTL94VX');
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('mandates/get.json');

        $this->stubRequest(
            'post',
            '/mandates',
            null,
            null,
            [
                'customer' => 'CUWSWVVPTL94VX',
                'pay_method' => 'direct-debit',
                'iban' => 'NL54INGB0001234567',
                'account_holder_name' => 'Customer',
            ],
            $response,
            201
        );

        $endpoint = new Mandates($this->apiClient);
        $mandate = $endpoint->create([
            'customer' => 'CUWSWVVPTL94VX',
            'pay_method' => 'direct-debit',
            'iban' => 'NL54INGB0001234567',
            'account_holder_name' => 'Customer',
        ]);

        self::assertInstanceOf(Mandate::class, $mandate);
    }
}
