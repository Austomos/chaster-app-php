<?php

namespace ChasterApp\Exception;

use Throwable;

class ResponseChasterException extends ChasterException
{
    private string $reasonPhrase;
    private int $statusCode;

    public function __construct($reasonPhrase, $statusCode, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->reasonPhrase = $reasonPhrase;
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
