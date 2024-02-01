<?php

namespace PayPro\Endpoints;

final class WebhooksTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

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

        $endpoint = new \PayPro\Endpoints\Webhooks($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\Webhook::class, $list->first());
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

        $endpoint = new \PayPro\Endpoints\Webhooks($this->apiClient);
        $webhook = $endpoint->get('WH43CVU3A1TD6Z');

        $this->assertInstanceOf(\PayPro\Entities\Webhook::class, $webhook);
        $this->assertSame($webhook->id, 'WH43CVU3A1TD6Z');
        $this->assertSame($webhook->name, 'Test Webhook');
        $this->assertSame($webhook->url, 'https://example.org/paypro/webhook');
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

        $endpoint = new \PayPro\Endpoints\Webhooks($this->apiClient);
        $webhook = $endpoint->create(['active' => false]);

        $this->assertInstanceOf(\PayPro\Entities\Webhook::class, $webhook);
    }
}
