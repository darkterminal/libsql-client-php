<?php

namespace Darkterminal\LibSQL\Traits;

trait Logging
{
    public function log($message)
    {
        $filePath = $this->checkAndCreateDirectoryAndFile();
        $logMessage = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        file_put_contents($filePath, $logMessage, FILE_APPEND);
    }

    protected function checkAndCreateDirectoryAndFile()
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
