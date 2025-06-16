<?php

namespace App\Services;

use App\Models\ActivityLog;

/**
 * Class ReportService
 *
 * Provides reporting features based on user activity logs.
 */
class ReportService
{
    private ActivityLog $logger;

    /**
     * ReportService constructor.
     *
     * @param ActivityLog $logger The ActivityLog model used to fetch report data.
     */
    public function __construct(ActivityLog $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Returns activity logs grouped by day.
     *
     * @return array Grouped report data.
     */
    public function getGroupedReportData(): array
    {
        return $this->logger->getDailyReportData();
    }

    /**
     * Returns activity logs filtered by specified criteria.
     *
     * @param array $filters Associative array of filters (e.g., ['type' => 'view_page']).
     * @return array Filtered activity logs.
     */
    public function getFilteredLogs(array $filters): array
    {
        return $this->logger->getFilteredLogs($filters);
    }

    /**
     * Prepares chart data arrays for frontend chart rendering (Chart.js).
     *
     * This method extracts specific keys (date, page views, actions) from
     * the aggregated report data using array_column. This makes it suitable
     * for passing to JavaScript as separate datasets.
     *
     * @param array $reportData Aggregated report data from the database.
     * @return array Associative array with separate arrays for each metric.
     */
    public function prepareChartData(array $reportData): array
    {
        return [
            'dates' => array_column($reportData, 'date'),
            'pageA_views' => array_column($reportData, 'pageA_views'),
            'pageB_views' => array_column($reportData, 'pageB_views'),
            'buy_clicks' => array_column($reportData, 'buy_clicks'),
            'download_clicks' => array_column($reportData, 'download_clicks'),
        ];
    }
}
