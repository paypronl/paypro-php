<?php

namespace PayPro\Entities;

use PayPro\TestCase;

final class EntityTest extends TestCase
{
    public function testConstructor()
    {
        $data = [
            'id' => 'PPXNQT8MXCA2UT',
            'type' => 'payment',
            'amount' => 5000,
            'description' => 'Test Payment',
            '_links' => [
                'self' => 'https://api.paypro.nl/payments/PPXNQT8MXCA2UT',
            ],
        ];

        $entity = new Entity($data);
        self::assertInstanceOf(Entity::class, $entity);

        self::assertSame($entity['id'], 'PPXNQT8MXCA2UT');
        self::assertSame($entity['amount'], 5000);
        self::assertSame($entity['description'], 'Test Payment');
        self::assertSame($entity['links'], ['self' => 'https://api.paypro.nl/payments/PPXNQT8MXCA2UT']);

        self::assertNull($entity['_links']);
        self::assertNull($entity['type']);
    }
}
