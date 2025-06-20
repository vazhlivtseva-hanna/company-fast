<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Services\ActivityLogService;
use App\Services\ReportService;

/**
 * Class StatisticsController
 *
 * Handles the statistics page for administrators.
 */
class StatisticsController extends BaseController
{
    /**
     * @param ActivityLogService $activityLogService
     * @param ReportService $reportService
     */
    public function __construct(
        private ActivityLogService $activityLogService,
        private ReportService $reportService
    ) {}

    /**
     * Displays the statistics page with filters and user activity logs.
     *
     * Access is restricted to admin users only.
     * Filters include date range, user info, action type, page name, and button name.
     * Logs the page view and renders the statistics view with filtered data.
     *
     * @return void
     */
    public function index()
    {
        // Ensure the user has admin privileges
        $this->checkAccess('ROLE_ADMIN');

        // Collect filter values from the query string
        $filters = [
            'date_from'    => $_GET['date_from'] ?? null,
            'date_to'      => !empty($_GET['date_to']) ? date('Y-m-d', strtotime($_GET['date_to'] . ' +1 day')) : null,
            'user_query'   => $_GET['user_query'] ?? null,
            'action_type'  => $_GET['action_type'] ?? null,
            'button_name'  => $_GET['button_name'] ?? null,
            'page_name'    => $_GET['page_name'] ?? null,
        ];

        try {
            // Log the admin viewing the statistics page
            $this->activityLogService->log('view_page', 'statistics');
            // Retrieve filtered activity logs
            $logs = $this->reportService->getFilteredLogs($filters);
        } catch (\Exception $e) {
            $logs = [];
            $this->handleException($e);
        }

        // Render the view and pass logs and filters
        $this->renderView('statistics', [
            'logs' => $logs,
            'filters' => $filters
        ]);
    }
}
