<?php

namespace PayPro\Exception;

/**
 * InvalidEventPayloadException is thrown when an invalid even payload is given when verifying the
 * signature.
 */
class InvalidEventPayloadException extends ApiErrorException implements ExceptionInterface
{
}
