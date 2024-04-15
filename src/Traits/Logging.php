<?php

namespace Darkterminal\LibSQL\Traits;

/**
 * Trait Logging
 *
 * This trait provides logging functionality for error messages.
 */
trait Logging
{
    /**
     * Log a message to the error log file.
     *
     * @param mixed $message The message to log.
     *
     * @return void
     */
    public function log($message): void
    {
        $filePath = $this->checkAndCreateDirectoryAndFile();
        $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        file_put_contents($filePath, $logMessage, FILE_APPEND);
    }

    /**
     * Check and create the directory and error log file if they don't exist.
     *
     * @return string The path to the error log file.
     */
    protected function checkAndCreateDirectoryAndFile(): string
    {
        $homeDirectory = getenv('HOME');
        $directoryPath = $homeDirectory . '/.libsql-php';
        $filePath = $directoryPath . '/errors.log';

        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        if (!file_exists($filePath)) {
            touch($filePath);
        }

        return $filePath;
    }
}

