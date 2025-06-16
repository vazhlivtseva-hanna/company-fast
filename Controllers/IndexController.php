<?php

namespace App\Controllers;

use App\Core\BaseController;

/**
 * Class IndexController
 *
 * Handles the main dashboard view for authenticated users.
 */
class IndexController extends BaseController
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
        $this->requireAuthRedirect();
        // Render the dashboard view with user data
        $this->renderView("dashboard", ["user" => $_SESSION['user']]);
    }
}
