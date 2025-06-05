<?php

namespace App\controllers;

use App\Core\Controller;
use App\models\ActivityLog;

/**
 * Class ReportsController
 *
 * Handles the reports page for administrators.
 */
class ReportsController extends Controller
{
    /**
     * Displays the daily activity reports with chart and table.
     *
     * Access is restricted to admin users only.
     * Retrieves aggregated data of user activity (views, clicks) by date.
     *
     * @return void
     */
    public function index()
    {
        // Ensure the user has admin privileges
        if (!isAdmin()) {
            http_response_code(403);
            exit('Access denied');
        }

        // Load activity log model
        $logger = $this->loadModel('ActivityLog');

        // Get aggregated activity report grouped by date
        $reportData = $logger->getDailyReportData();

        // Render the reports view with the data
        $this->renderView('reports', ['reportData' => $reportData]);
    }
}
