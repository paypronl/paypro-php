<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Webhook;
use PayPro\TestCase;
use PayPro\TestHelper;

final class WebhooksTest extends TestCase
{
    use TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('webhooks/list.json');

        $this->stubRequest(
            'get',
            '/webhooks',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Webhooks($this->apiClient);
        $list = $endpoint->list();

        self::assertInstanceOf(Collection::class, $list);
        self::assertInstanceOf(Webhook::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('webhooks/get.json');

        $this->stubRequest(
            'get',
            '/webhooks/WH43CVU3A1TD6Z',
            null,
            null,
            null,
            $response
        );

        $endpoint = new Webhooks($this->apiClient);
        $webhook = $endpoint->get('WH43CVU3A1TD6Z');

        self::assertInstanceOf(Webhook::class, $webhook);
        self::assertSame($webhook->id, 'WH43CVU3A1TD6Z');
        self::assertSame($webhook->name, 'Test Webhook');
        self::assertSame($webhook->url, 'https://example.org/paypro/webhook');
    }

    public function testIsCreatable()
    {
        $response = $this->getFixture('webhooks/get.json');

        $this->stubRequest(
            'post',
            '/webhooks',
            null,
            null,
            ['active' => false],
            $response,
            201
        );

        $endpoint = new Webhooks($this->apiClient);
        $webhook = $endpoint->create(['active' => false]);

        self::assertInstanceOf(Webhook::class, $webhook);
    }
}
