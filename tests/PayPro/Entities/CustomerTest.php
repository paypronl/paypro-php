<?php

namespace PayPro\Entities;

use PayPro\TestCase;
use PayPro\TestHelper;

final class CustomerTest extends TestCase
{
    use TestHelper;

    public function testDelete()
    {
        $response = $this->getFixture('customers/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'delete',
            '/customers/CU10TV703T84E0',
            null,
            null,
            null,
            $response
        );

        $customer = new Customer($data, $this->apiClient);

        $responseCustomer = $customer->delete();
        $this->assertInstanceOf(Customer::class, $responseCustomer);
    }

    public function testUpdate()
    {
        $response = $this->getFixture('customers/get.json');
        $data = \json_decode($response, true);

        $this->stubRequest(
            'patch',
            '/customers/CU10TV703T84E0',
            null,
            null,
            ['address' => 'Gangpad 11'],
            $response
        );

        $customer = new Customer($data, $this->apiClient);

        $responseCustomer = $customer->update(['address' => 'Gangpad 11']);
        $this->assertInstanceOf(Customer::class, $responseCustomer);
    }
}
