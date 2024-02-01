<?php

namespace PayPro\Entities;

final class EntityTest extends \PayPro\TestCase
{
    public function testConstructor()
    {
        $data = [
            'id' => 'PPXNQT8MXCA2UT',
            'type' => 'payment',
            'amount' => 5000,
            'description' => 'Test Payment',
            '_links' => [
                'self' => 'https://api.paypro.nl/payments/PPXNQT8MXCA2UT'
            ]
        ];

        $entity = new \PayPro\Entities\Entity($data);
        $this->assertInstanceOf(\PayPro\Entities\Entity::class, $entity);

        $this->assertSame($entity['id'], 'PPXNQT8MXCA2UT');
        $this->assertSame($entity['amount'], 5000);
        $this->assertSame($entity['description'], 'Test Payment');
        $this->assertSame($entity['links'], ['self' => 'https://api.paypro.nl/payments/PPXNQT8MXCA2UT']);

        $this->assertNull($entity['_links']);
        $this->assertNull($entity['type']);
    }
}