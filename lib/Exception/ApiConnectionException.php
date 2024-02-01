<?php

namespace PayPro\Exception;

/**
 * ApiConnectioException is thrown in cases where the client cannot connect to the API server.
 */
class ApiConnectionException extends ApiErrorException implements ExceptionInterface
{
}
