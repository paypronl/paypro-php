<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Customer;
use PayPro\TestCase;
use PayPro\TestHelper;

final class CustomersTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('customers/list.json');

        $this->stubRequest(
            'get',
            '/customers',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Customers($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertInstanceOf(Customer::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('customers/get.json');

        $this->stubRequest(
            'get',
            '/customers/CU10TV703T84E0',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Customers($this->apiClient);
        $chargeback = $endpoint->get('CU10TV703T84E0');

        $this->assertInstanceOf(Customer::class, $chargeback);
        $this->assertSame($chargeback->id, 'CU10TV703T84E0');
        $this->assertSame($chargeback->city, 'Amsterdam');
        $this->assertSame($chargeback->address, 'Gangpad 12');
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('customers/get.json');

        $this->stubRequest(
            'post',
            '/customers',
            null,
            null,
            ['address' => 'Gangpad 12'],
            $response,
            201
        );

        $endpoint = new Customers($this->apiClient);
        $chargeback = $endpoint->create(['address' => 'Gangpad 12']);

        $this->assertInstanceOf(Customer::class, $chargeback);
    }
}
