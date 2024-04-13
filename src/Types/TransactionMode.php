<?php

namespace Darkterminal\LibSQL\Types;

use Darkterminal\LibSQL\Utils\Exceptions\LibsqlError;
use ReflectionClass;

/**
 * Class TransactionMode
 *
 * The TransactionMode class provides constants representing transaction modes for database operations.
 *
 * @package Darkterminal\LibSQL\Types
 */
class TransactionMode
{
    public const write = 'write';
    public const read = 'read';
    public const deferred = 'deferred';

    public static function checker(string $mode): string
    {
        $reflection = new ReflectionClass(TransactionMode::class);
        $constants = $reflection->getConstants();
        if (!in_array($mode, $constants)) {
            throw new LibsqlError("Transaction mode is not supported. The only avaibale mode is: write, read, and deferred", "INVALID_TRANSACTION_MODE");
        }

        return $mode;
    }
}
