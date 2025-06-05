<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Class DownloadController
 *
 * Handles Page B view and download functionality for authenticated users.
 */
class DownloadController extends Controller
{
    /**
     * Displays Page B with the "Download" button.
     *
     * Logs the page view and renders the view for authorized users only.
     *
     * @return void
     */
    public function pageB(): void
    {
        // Check if the user is authenticated
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            exit('Unauthorized');
        }

        // Log page view activity
        $logger = $this->loadModel('ActivityLog');
        $logger->log('view_page', 'pageB');

        // Render the view for page B
        $this->renderView('pageB');
    }

    /**
     * Handles the download request from Page B.
     *
     * Validates authentication, logs the download action,
     * and serves the file for download if it exists.
     * If not authorized or file is missing, returns appropriate error response.
     *
     * @return void
     */
    public function download(): void
    {
        // Check if the user is authenticated
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            echo json_encode(['error' => true, 'message' => 'Unauthorized']);
            return;
        }

        try {
            // Log download button click activity
            $logger = $this->loadModel('ActivityLog');
            $logger->log('button_click', 'pageB', 'download');

            // Define path to the downloadable file
            $filePath = __DIR__ . '/../downloads/example-installer.exe';

            // Check if file exists
            if (!file_exists($filePath)) {
                throw new \Exception("File not found");
            }

            // Send headers and output the file for download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            readfile($filePath);
            exit;
        } catch (\Exception $e) {
            // Return error response in case of failure
            http_response_code(500);
            echo json_encode(['error' => true, 'message' => $e->getMessage()]);
        }
    }
}
