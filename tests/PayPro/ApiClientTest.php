<?php

namespace PayPro;

use PayPro\Exception\ApiErrorException;
use PayPro\Exception\AuthenticationException;
use PayPro\Exception\ResourceNotFoundException;
use PayPro\Exception\ValidationException;

final class ApiClientTest extends TestCase
{
    use TestHelper;

    public function testRequestWhenApiKeyNotSet()
    {
        $client = new ApiClient();

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(
            'API key not set. ' .
            'Make sure to set the API key with "PayPro::setApiKey(<API_KEY>)". ' .
            'You can find your API key in the PayPro dashboard at "https://app.paypro.' .
            'nl/developers/api-keys".'
        );

        $client->request('get', '/payments');
    }

    public function testRequestWithInvalidJsonResponse()
    {
        $client = new ApiClient('api_key');

        $this->stubRequest(
            'get',
            '/payments',
            null,
            null,
            null,
            '',
            500
        );

        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage(
            'Invalid response from API. The JSON returned in the body is not valid.'
        );

        $client->request('get', '/payments');
    }

    public function testRequestWhenResponseIs401()
    {
        $client = new ApiClient('api_key');

        $this->stubRequest(
            'get',
            '/payments',
            null,
            null,
            null,
            '{}',
            401
        );

        $this->expectException(AuthenticationException::class);
        $this->expectExceptionMessage(
            'Invalid API key supplied. Make sure to set a correct API key. ' .
           'You can find your API key in the PayPro dashboard at ' .
           '"https://app.paypro.nl/developers/api-keys".'
        );

        $client->request('get', '/payments');
    }

    public function testRequestWhenResponseIs404()
    {
        $client = new ApiClient('api_key');

        $this->stubRequest(
            'get',
            '/payments',
            null,
            null,
            null,
            '{}',
            404
        );

        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage('Resource not found');

        $client->request('get', '/payments');
    }

    public function testRequestWhenResponseIs422()
    {
        $client = new ApiClient('api_key');
        $response = [
            'error' => [
                'message' => 'Description must be set',
                'param' => 'description',
                'type' => 'invalid_request',
            ],
        ];

        $this->stubRequest(
            'get',
            '/payments',
            null,
            null,
            null,
            json_encode($response),
            422
        );

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'Validation error - param: description because Description must be set'
        );

        $client->request('get', '/payments');
    }

    public function testRequestWithSuccessResponse()
    {
        $client = new ApiClient('api_key');
        $response = ['success' => 'True'];

        $this->stubRequest(
            'get',
            '/payments',
            null,
            null,
            null,
            json_encode($response),
            200,
            ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7']
        );

        $response = $client->request('get', '/payments');

        self::assertInstanceOf(Response::class, $response);
        self::assertSame($response->getRawBody(), '{"success":"True"}');
        self::assertSame($response->getData(), ['success' => 'True']);
        self::assertSame($response->getRequestId(), '2de44ce1-2ace-4118-922e-e53ab33f6fc7');
        self::assertSame($response->getHeaders(), ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7']);
    }

    public function testRequestWithPost()
    {
        $client = new ApiClient('api_client');
        $response = ['success' => 'True'];

        $this->stubRequest(
            'post',
            '/customers',
            ['limit' => 1],
            [
                'X-Test-Header' => 'Test',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer api_client',
            ],
            null,
            json_encode($response),
            200,
            ['X-Request-Id' => '2de44ce1-2ace-4118-922e-e53ab33f6fc7']
        );

        $response = $client->request('post', '/customers', ['limit' => 1], ['X-Test-Header' => 'Test']);
    }
}
