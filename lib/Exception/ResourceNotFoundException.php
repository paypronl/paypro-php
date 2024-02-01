<?php

namespace PayPro\Exception;

/**
 * ResourceNotFoundException is thrown when the API returns a 404 response.
 */
class ResourceNotFoundException extends ApiErrorException implements ExceptionInterface
{
}
