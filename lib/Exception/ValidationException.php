<?php

namespace PayPro\Exception;

/**
 * ValidationException is thrown when invalid parameters have been supplied in an API request.
 */
class ValidationException extends ApiErrorException implements ExceptionInterface
{
}
