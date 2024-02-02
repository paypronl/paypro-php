<?php

namespace PayPro;

use PayPro\Exception\ApiErrorException;

final class ResponseTest extends TestCase
{
    public function testConstructorWithValidData()
    {
        $body = '{"amount":500}';
        $status = 200;
        $headers = ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7'];

        $response = new Response($body, $status, $headers);

        self::assertInstanceOf(Response::class, $response);

        self::assertSame($response->getRawBody(), $body);
        self::assertSame($response->getData(), ['amount' => 500]);
        self::assertSame($response->getStatus(), 200);
        self::assertSame($response->getHeaders(), $headers);
        self::assertSame($response->getRequestId(), '2de44ce1-2ace-4118-922e-e53ab33f6fc7');
    }

    public function testConstructorWithInvalidData()
    {
        $body = '';
        $status = 200;
        $headers = ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7'];

        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage('Invalid response from API. The JSON returned in the body is not valid.');

        $response = new Response($body, $status, $headers);
    }
}
