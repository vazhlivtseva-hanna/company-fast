<?php


namespace App\Services;

class LogService
{
    private string $logFile;

    public function __construct()
    {
        $this->logFile = __DIR__ . '/../logs/app.log';
    }

    /**
     * Write a message to the application log
     *
     * @param string $message
     * @param string $type
     * @return void
     */
    public function write(string $message, string $type = 'INFO'): void
    {
        $date = date('Y-m-d H:i:s');
        $formatted = "[$date][$type] $message" . PHP_EOL;
        file_put_contents($this->logFile, $formatted, FILE_APPEND);
    }
}
