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
}
