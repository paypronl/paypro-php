<?php

namespace PayPro\Endpoints;

use PayPro\Entities\Collection;
use PayPro\Entities\Event;
use PayPro\Entities\Payment;
use PayPro\TestCase;
use PayPro\TestHelper;

final class EventsTest extends TestCase
{
    use TestHelper;

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

        $endpoint = new Events($this->apiClient);
        $list = $endpoint->list();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertInstanceOf(Event::class, $list->first());
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

        $endpoint = new Events($this->apiClient);
        $event = $endpoint->get('EVYK7KCFJAXA23UKSG');

        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame($event->id, 'EVYK7KCFJAXA23UKSG');
        $this->assertSame($event->event_type, 'payment.created');
        $this->assertInstanceOf(Payment::class, $event->payload);
    }
}
