<?php

namespace PayPro;

final class ResponseTest extends \PayPro\TestCase
{
    public function testConstructorWithValidData()
    {
        $body = '{"amount":500}';
        $status = 200;
        $headers = ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7'];

        $response = new \PayPro\Response($body, $status, $headers);

        $this->assertInstanceOf(\PayPro\Response::class, $response);

        $this->assertSame($response->getRawBody(), $body);
        $this->assertSame($response->getData(), ['amount' => 500]);
        $this->assertSame($response->getStatus(), 200);
        $this->assertSame($response->getHeaders(), $headers);
        $this->assertSame($response->getRequestId(), '2de44ce1-2ace-4118-922e-e53ab33f6fc7');
    }

    public function testConstructorWithInvalidData()
    {
        $body = '';
        $status = 200;
        $headers = ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7'];

        $this->expectException(\PayPro\Exception\ApiErrorException::class);
        $this->expectExceptionMessage('Invalid response from API. The JSON returned in the body is not valid.');

        $response = new \PayPro\Response($body, $status, $headers);
    }
}
