<?php

namespace App\Controllers;


use App\Core\BaseController;
use App\Services\ActivityLogService;

/**
 * Class CowController
 *
 * Handles Page A view and "Buy a Cow" action for authenticated users.
 */
class CowController extends BaseController
{
    /**
     * @param ActivityLogService $activityLogService
     */
    public function __construct(
        private ActivityLogService $activityLogService,
    ) {}

    /**
     * Displays Page A with the "Buy a Cow" button.
     *
     * Logs the page view and renders the view for authorized users only.
     *
     * @return void
     */
    public function pageA(): void
    {
        // Ensure the user is authenticated
        $this->requireAuthRedirect();

        try {
            // Log the page view for Page A
            $this->activityLogService->log('view_page', 'pageA');
        } catch (\Exception $exception) {
            $this->handleException($exception);
        }


        // Render the view for Page A
        $this->renderView('pageA');
    }
}
