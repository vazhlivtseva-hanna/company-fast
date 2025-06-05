<?php

namespace App\controllers;

use App\Core\Controller;

/**
 * Class IndexController
 *
 * Handles the main dashboard view for authenticated users.
 */
class IndexController extends Controller
{
    /**
     * Displays the dashboard page.
     *
     * This method is accessible only to authenticated users.
     * It renders the dashboard view and passes the current user's session data to the view.
     * If the user is not authenticated, a 403 HTTP response is returned.
     *
     * @return void
     */
    public function dashboard()
    {
        // Ensure the user is logged in
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            exit('Unauthorized');
        }

        // Render the dashboard view with user data
        $this->renderView("dashboard", ["user" => $_SESSION['user']]);
    }
}
