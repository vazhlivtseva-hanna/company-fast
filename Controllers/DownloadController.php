<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Services\ActivityLogService;
use App\Services\FileService;

/**
 * Class DownloadController
 *
 * Handles Page B view and download functionality for authenticated users.
 */
class DownloadController extends BaseController
{

    public function __construct(
        private FileService $fileService,
        private ActivityLogService $activityLogService,
    ) {}

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
        $this->requireAuthRedirect('/dashboard');

        // Log page view activity
        try {
            // Load activity log model
            $this->activityLogService->log('view_page', 'pageB');
        } catch (\Exception $e) {
            $this->handleException($e);
        }


        // Render the view for page B
        $this->renderView('pageB', [
            'csrf_token' => generateCsrfToken()
        ]);
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
        $this->requireAuthRedirect();

        try {
            $this->activityLogService->log('button_click', 'pageB', 'download');

            $filePath = __DIR__ . '/../downloads/example-installer.exe';

            // Delegate download to the service
            $this->fileService->download($filePath);

        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }
}
