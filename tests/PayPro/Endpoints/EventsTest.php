<?php

namespace PayPro\Endpoints;

final class EventsTest extends \PayPro\TestCase
{
    use \PayPro\TestHelper;

    public function testIsListable()
    {
        $response = $this->getFixture('events/list.json');

        $this->stubRequest(
            'get',
            '/events',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Events($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(\PayPro\Entities\Collection::class, $list);
        $this->assertInstanceOf(\PayPro\Entities\Event::class, $list->first());
    }

    public function testIsGettable()
    {
        $response = $this->getFixture('events/get.json');

        $this->stubRequest(
            'get',
            '/events/EVYK7KCFJAXA23UKSG',
            null,
            null,
            null,
            $response
        );

        $endpoint = new \PayPro\Endpoints\Events($this->apiClient);
        $event = $endpoint->get('EVYK7KCFJAXA23UKSG');

        $this->assertInstanceOf(\PayPro\Entities\Event::class, $event);
        $this->assertSame($event->id, 'EVYK7KCFJAXA23UKSG');
        $this->assertSame($event->event_type, 'payment.created');
        $this->assertInstanceOf(\PayPro\Entities\Payment::class, $event->payload);
    }
}
