<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Services\ReportService;

/**
 * Class ReportsController
 *
 * Handles the reports page for administrators.
 */
class ReportsController extends BaseController
{

    /**
     * @param ReportService $reportService
     */
    public function __construct(
        private  ReportService $reportService
    ) {}

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
        $this->checkAccess('ROLE_ADMIN');
        $reportData = $this->reportService->getGroupedReportData();
        $chartData = $this->reportService->prepareChartData($reportData);

        $this->renderView('reports', [
            'reportData' => $reportData,
            'chartData' => $chartData,
        ]);
    }
}
