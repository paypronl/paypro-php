<?php

namespace PayPro;

use PayPro\Entities\Collection;
use PayPro\Entities\Payment;
use PayPro\Entities\PayMethod;

final class UtilTest extends TestCase
{
    public function testEntityClass()
    {
        $entityClass = Util::entityClass('payment');
        self::assertSame('\PayPro\Entities\Payment', $entityClass);

        $entityClass = Util::entityClass('pay_method');
        self::assertSame('\PayPro\Entities\PayMethod', $entityClass);

        $entityClass = Util::entityClass('unknown');
        self::assertSame('\PayPro\Entities\Entity', $entityClass);
    }

    public function testNormalizedApiAttributes()
    {
        $attributes = [
            'id' => 'PP12CP1Q0K4QJL',
            'type' => 'payment',
            'amount' => 1000,
            'currency' => 'EUR',
            'state' => 'paid',
            'description' => 'Test Payment',
            '_links' => [
                'self' => 'https://api.paypro.nl/payments/PP12CP1Q0K4QJL',
            ],
        ];

        $normalizedAttributes = Util::normalizeApiAttributes($attributes);

        self::assertSame(
            [
                'id' => 'PP12CP1Q0K4QJL',
                'amount' => 1000,
                'currency' => 'EUR',
                'state' => 'paid',
                'description' => 'Test Payment',
                'links' => [
                    'self' => 'https://api.paypro.nl/payments/PP12CP1Q0K4QJL',
                ],
            ],
            $normalizedAttributes
        );

        self::assertSame($attributes['type'], 'payment');
    }

    public function testToEntityWithListType()
    {
        $data = [
            'type' => 'list',
            'count' => 0,
            'data' => [],
        ];

        $client = 'client';
        $params = ['limit' => 5];

        $entity = Util::toEntity($data, $client, $params);

        self::assertInstanceOf(Collection::class, $entity);
        self::assertSame($entity->getFilters(), $params);
        self::assertSame($entity['count'], 0);
        self::assertSame($entity['data'], []);
    }

    public function testToEntityWithEntityType()
    {
        $data = [
            'id' => 'PPK002A23LV3CG',
            'type' => 'payment',
            'amount' => 5000,
            'currency' => 'EUR',
            'description' => 'Test Payment',
            'pay_method' => [
                'id' => 'ideal',
                'type' => 'pay_method',
                'name' => 'iDEAL',
            ],
        ];

        $client = 'client';
        $entity = Util::toEntity($data, $client);

        self::assertInstanceOf(Payment::class, $entity);
        self::assertInstanceOf(PayMethod::class, $entity['pay_method']);

        self::assertSame($entity['id'], 'PPK002A23LV3CG');
        self::assertSame($entity['amount'], 5000);
        self::assertSame($entity['currency'], 'EUR');
        self::assertSame($entity['description'], 'Test Payment');
    }

    public function testToEntityWithAssociativeArray()
    {
        $client = 'client';
        $entity = Util::toEntity(['custom' => '12345'], $client);

        self::assertSame(['custom' => '12345'], $entity);
    }

    public function testToEntityWithArray()
    {
        $client = 'client';
        $entity = Util::toEntity(['1', 2, '3'], $client);

        self::assertSame(['1', 2, '3'], $entity);
    }

    public function testToEntityWithString()
    {
        $client = 'client';
        $entity = Util::toEntity('test', $client);

        self::assertSame('test', $entity);
    }

    public function testIsList()
    {
        $list = ['test', [], 5];
        self::assertTrue(Util::isList($list));

        $emptyList = [];
        self::assertTrue(Util::isList($emptyList));

        $notList = ['test' => 'Hello', 5, 'string'];
        self::assertFalse(Util::isList($notList));
    }

    public function testEncodeParameters()
    {
        $parameters = ['test' => 'hello'];
        $encodedParameters = Util::encodeParameters($parameters);
        self::assertSame($encodedParameters, 'test=hello');

        $parameters = ['test' => 'hello', 'limit' => 10];
        $encodedParameters = Util::encodeParameters($parameters);
        self::assertSame($encodedParameters, 'test=hello&limit=10');

        $parameters = ['test[]' => 'hello', 'limit+test' => 10];
        $encodedParameters = Util::encodeParameters($parameters);
        self::assertSame($encodedParameters, 'test[]=hello&limit%2Btest=10');
    }

    public function testUrlEncode()
    {
        self::assertSame(Util::urlEncode('string'), 'string');
        self::assertSame(Util::urlEncode('string+test'), 'string%2Btest');
        self::assertSame(Util::urlEncode('string[]'), 'string[]');
        self::assertSame(Util::urlEncode(10), '10');
    }
}
