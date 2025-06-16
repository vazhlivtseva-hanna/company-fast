<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Class ActivityLog
 *
 * Handles activity tracking, filtering, and reporting for user interactions.
 */
class ActivityLog
{
    private $db;

    /**
     * ActivityLog constructor.
     *
     * Initializes a new instance of the database connection.
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Logs a user activity into the activity_logs table.
     *
     * @param string $actionType  Type of action (e.g., 'view_page', 'button_click').
     * @param string|null $pageName Optional page name where the action occurred.
     * @param string|null $buttonName Optional button name if a button was clicked.
     * @return void
     */
    public function log($actionType, $pageName = null, $buttonName = null): void
    {
        $userId = $_SESSION['user']['id'] ?? null;

        $this->db->query("
            INSERT INTO activity_logs (user_id, action_type, page_name, button_name) 
            VALUES (:user_id, :action_type, :page_name, :button_name)
        ");

        $this->db->bind(':user_id', $userId);
        $this->db->bind(':action_type', $actionType);
        $this->db->bind(':page_name', $pageName);
        $this->db->bind(':button_name', $buttonName);
        $this->db->execute();
    }

    /**
     * Retrieves a filtered list of activity logs based on user input.
     *
     * Filters include date range, user query (first name, last name, or email),
     * action type, page name, and button name.
     *
     * @param array $filters An associative array of filters.
     * @return array List of activity logs matching the filters.
     */
    public function getFilteredLogs($filters): array
    {
        $sql = "SELECT activity_logs.*, users.email 
                FROM activity_logs 
                LEFT JOIN users ON users.id = activity_logs.user_id 
                WHERE 1=1";

        $params = [];

        if (!empty($filters['date_from'])) {
            $sql .= " AND activity_logs.created_at >= :date_from";
            $params[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $sql .= " AND activity_logs.created_at < :date_to";
            $params[':date_to'] = $filters['date_to'];
        }

        if (!empty($filters['user_query'])) {
            $sql .= " AND (users.first_name LIKE :user_query OR users.last_name LIKE :user_query OR users.email LIKE :user_query)";
            $params[':user_query'] = '%' . $filters['user_query'] . '%';
        }

        if (!empty($filters['action_type'])) {
            $sql .= " AND activity_logs.action_type = :action_type";
            $params[':action_type'] = $filters['action_type'];
        }

        if (!empty($filters['page_name'])) {
            $sql .= " AND activity_logs.page_name = :page_name";
            $params[':page_name'] = $filters['page_name'];
        }

        if (!empty($filters['button_name'])) {
            $sql .= " AND activity_logs.button_name = :button_name";
            $params[':button_name'] = $filters['button_name'];
        }

        $sql .= " ORDER BY activity_logs.created_at DESC";

        $this->db->query($sql);

        foreach ($params as $key => $val) {
            $this->db->bind($key, $val);
        }

        return $this->db->resultSet();
    }

    /**
     * Retrieves summarized daily activity data for reporting purposes.
     *
     * Returns aggregated counts of page views and button clicks by day,
     * used for generating charts and statistics.
     *
     * @return array Aggregated data grouped by date.
     */
    public function getDailyReportData(): array
    {
        $this->db->query("
            SELECT 
                DATE(created_at) AS date,
                COUNT(CASE WHEN action_type = 'view_page' AND page_name = 'pageA' THEN 1 END) AS pageA_views,
                COUNT(CASE WHEN action_type = 'view_page' AND page_name = 'pageB' THEN 1 END) AS pageB_views,
                COUNT(CASE WHEN action_type = 'button_click' AND button_name = 'buy' THEN 1 END) AS buy_clicks,
                COUNT(CASE WHEN action_type = 'button_click' AND button_name = 'download' THEN 1 END) AS download_clicks
            FROM activity_logs
            GROUP BY DATE(created_at)
            ORDER BY DATE(created_at) ASC
        ");

        return $this->db->resultSet();
    }
}
