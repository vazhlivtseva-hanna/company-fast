<?php

namespace App\Services;

use App\Models\ActivityLog;

/**
 * Class ActivityLogService
 *
 * A service that abstracts logging of user activity.
 * Wraps the ActivityLog model and provides a clean interface for controllers.
 */
class ActivityLogService
{
    private ActivityLog $logger;

    /**
     * ActivityLogService constructor.
     *
     * Initializes the ActivityLog model instance.
     */
    public function __construct()
    {
        $this->logger = new ActivityLog();
    }

    /**
     * Logs an activity event.
     *
     * @param string      $type   The type of event (e.g., 'view_page', 'button_click').
     * @param string      $page   The page or context where the event happened.
     * @param string|null $action Optional specific action taken (e.g., 'download', 'submit').
     *
     * @return void
     */
    public function log(string $type, string $page, ?string $action = null): void
    {
        $this->logger->log($type, $page, $action);
    }
}
