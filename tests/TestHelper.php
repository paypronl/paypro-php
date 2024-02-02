<?php

namespace PayPro;

trait TestHelper
{
    protected $baseFixturePath;

    protected $httpClientMock;

    protected $apiClient;

    /** @before */
    protected function setUpCase()
    {
        $this->baseFixturePath = \realpath(__DIR__ . '/fixtures/');
        $this->httpClientMock = $this->createMock('\PayPro\HttpClient\HttpClientInterface');
        $this->apiClient = new ApiClient('api_key');
    }

    /**
     * Returns the content of the fixture at the relative path.
     *
     * @param string $path the relative path to the fixture
     *
     * @return string
     */
    protected function getFixture($path)
    {
        $filename = $this->baseFixturePath . '/' . $path;

        return file_get_contents($filename);
    }

    /**
     * This method can be used to stub requests and will check if the client receives the correct
     * values. It will also return a response based on the parameters given.
     *
     * @param string $method the method of the request
     * @param string $path the path of the request
     * @param null|array $params the params of the request
     * @param null|array $headers the headers of the request
     * @param null|array $body the body of the request
     * @param null|string $response the response body
     * @param int $code the response code
     * @param array $responseHeaders the response headers
     *
     * @return array{string, int, array}
     */
    protected function stubRequest(
        $method,
        $path,
        $params = null,
        $headers = null,
        $body = null,
        $response = null,
        $code = 200,
        $responseHeaders = []
    ) {
        ApiClient::setHttpClient($this->httpClientMock);

        $url = PayPro::getApiUrl() . $path;

        return $this->httpClientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                $this->identicalTo(\strtolower($method)),
                $this->identicalTo($url),
                null === $params ? $this->anything() : $this->identicalTo($params),
                null === $headers ? $this->anything() : $this->callback(function ($array) use ($headers) {
                    foreach ($headers as $header) {
                        if (!\in_array($header, $array, true)) {
                            return false;
                        }
                    }

                    return true;
                }),
                null === $body ? $this->anything() : $this->identicalTo(\json_encode($body))
            )
            ->willReturn([$response, $code, $responseHeaders])
        ;
    }
}
