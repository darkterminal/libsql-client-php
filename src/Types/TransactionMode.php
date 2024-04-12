<?php

namespace Darkterminal\LibSQL\Types;

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
}
