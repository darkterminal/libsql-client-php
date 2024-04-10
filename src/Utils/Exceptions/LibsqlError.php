<?php

namespace Darkterminal\LibSQL\Utils\Exceptions;

/**
 * Error thrown by the client.
 */
class LibsqlError extends \Exception
{
    /** @var string Machine-readable error code. */
    public $code;

    /** @var int|null Raw numeric error code */
    public $rawCode;

    /**
     * Constructor.
     *
     * @param string $message The error message.
     * @param string $code The machine-readable error code.
     * @param int|null $rawCode The raw numeric error code.
     * @param Throwable|null $cause The cause of the error.
     */
    public function __construct(string $message, string $code, ?int $rawCode = null, ?\Throwable $cause = null)
    {
        if ($code !== null) {
            $message = $code . ': ' . $message;
        }
        parent::__construct($message, 0, $cause);
        $this->code = $code;
        $this->rawCode = $rawCode;
    }
}
