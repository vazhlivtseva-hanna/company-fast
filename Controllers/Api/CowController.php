<?php

namespace App\Controllers\Api;

use App\Core\BaseController;
use App\Services\ActivityLogService;

class CowController extends BaseController
{
    public function __construct(
        private ActivityLogService $activityLogService,
    ) {}


    /**
     * Handles the "Buy a Cow" button click.
     *
     * Logs the button click action and returns a thank you message.
     * If the user is not authenticated or an error occurs, responds accordingly.
     *
     * @return void
     */
    public function buy(): void
    {
        // Ensure the user is authenticated
        $this->requireAuthRedirect();

        try {
            // Log the button click for "Buy a Cow"
            $this->activityLogService->log('button_click', 'pageA', 'buy');
            // Return success response
            $this->json(['message' => 'Thank you for your purchase!']);
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }
    }
}
