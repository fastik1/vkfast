<?php

namespace Fastik1\Vkfast\Exceptions;

use Throwable;

class VkApiError extends BaseException
{
    public function __construct(string $error_msg, int $error_code, Throwable $previous = null)
    {
        parent::__construct($error_msg, $error_code, $previous);
    }
}