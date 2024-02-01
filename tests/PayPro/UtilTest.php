<?php

namespace PayPro;

final class UtilTest extends \PayPro\TestCase
{
    public function testEntityClass()
    {
        $entityClass = Util::entityClass('payment');
        static::assertSame('\PayPro\Entities\Payment', $entityClass);

        $entityClass = Util::entityClass('pay_method');
        static::assertSame('\PayPro\Entities\PayMethod', $entityClass);

        $entityClass = Util::entityClass('unknown');
        static::assertSame('\PayPro\Entities\Entity', $entityClass);
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
                'self' => 'https://api.paypro.nl/payments/PP12CP1Q0K4QJL'
            ]
        ];

        $normalizedAttributes = Util::normalizeApiAttributes($attributes);

        static::assertSame(
            [
                'id' => 'PP12CP1Q0K4QJL',
                'amount' => 1000,
                'currency' => 'EUR',
                'state' => 'paid',
                'description' => 'Test Payment',
                'links' => [
                    'self' => 'https://api.paypro.nl/payments/PP12CP1Q0K4QJL'
                ]
            ],
            $normalizedAttributes
        );

        static::assertSame($attributes['type'], 'payment');
    }

    public function testToEntityWithListType()
    {
        $data = [
            'type' => 'list',
            'count' => 0,
            'data' => []
        ];

        $client = 'client';
        $params = ['limit' => 5];

        $entity = Util::toEntity($data, $client, $params);

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $entity);
        $this->assertSame($entity->getFilters(), $params);
        $this->assertSame($entity['count'], 0);
        $this->assertSame($entity['data'], []);
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
                'name' => 'iDEAL'
            ]
        ];

        $client = 'client';
        $entity = Util::toEntity($data, $client);

        $this->assertInstanceOf(\PayPro\Entities\Payment::class, $entity);
        $this->assertInstanceOf(\PayPro\Entities\PayMethod::class, $entity['pay_method']);

        $this->assertSame($entity['id'], 'PPK002A23LV3CG');
        $this->assertSame($entity['amount'], 5000);
        $this->assertSame($entity['currency'], 'EUR');
        $this->assertSame($entity['description'], 'Test Payment');
    }

    public function testToEntityWithAssociativeArray()
    {
        $client = 'client';
        $entity = Util::toEntity(['custom' => '12345'], $client);

        $this->assertSame(['custom' => '12345'], $entity);
    }

    public function testToEntityWithArray()
    {
        $client = 'client';
        $entity = Util::toEntity(['1', 2, '3'], $client);

        $this->assertSame(['1', 2, '3'], $entity);
    }

    public function testToEntityWithString()
    {
        $client = 'client';
        $entity = Util::toEntity('test', $client);

        $this->assertSame('test', $entity);
    }

    public function testIsList()
    {
        $list = ['test', [], 5];
        static::assertTrue(Util::isList($list));

        $emptyList = [];
        static::assertTrue(Util::isList($emptyList));

        $notList = ['test' => 'Hello', 5, 'string'];
        static::assertFalse(Util::isList($notList));
    }

    public function testEncodeParameters()
    {
        $parameters = ['test' => 'hello'];
        $encodedParameters = Util::encodeParameters($parameters);
        $this->assertSame($encodedParameters, 'test=hello');

        $parameters = ['test' => 'hello', 'limit' => 10];
        $encodedParameters = Util::encodeParameters($parameters);
        $this->assertSame($encodedParameters, 'test=hello&limit=10');

        $parameters = ['test[]' => 'hello', 'limit+test' => 10];
        $encodedParameters = Util::encodeParameters($parameters);
        $this->assertSame($encodedParameters, 'test[]=hello&limit%2Btest=10');
    }

    public function testUrlEncode()
    {
        $this->assertSame(Util::urlEncode('string'), 'string');
        $this->assertSame(Util::urlEncode('string+test'), 'string%2Btest');
        $this->assertSame(Util::urlEncode('string[]'), 'string[]');
        $this->assertSame(Util::urlEncode(10), '10');
    }
}
