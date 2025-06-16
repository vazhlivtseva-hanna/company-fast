<?php

namespace App\Services;

class FileService
{
    /**
     * Securely sends a file for download
     *
     * @param string $absolutePath
     * @return void
     * @throws \Exception
     */
    public function download(string $absolutePath): void
    {
        if (!file_exists($absolutePath)) {
            throw new \Exception("File not found: $absolutePath");
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($absolutePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($absolutePath));

        readfile($absolutePath);
        exit;
    }
}
