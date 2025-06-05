<?php

namespace App\Controllers;

use App\Core\Controller;

/**
 * Class CowController
 *
 * Handles Page A view and "Buy a Cow" action for authenticated users.
 */
class CowController extends Controller
{
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
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            exit('Unauthorized');
        }

        // Log the page view for Page A
        $logger = $this->loadModel('ActivityLog');
        $logger->log('view_page', 'pageA');

        // Render the view for Page A
        $this->renderView('pageA');
    }

    /**
     * Handles the "Buy a Cow" button click.
     *
     * Logs the button click action and returns a thank you message.
     * If the user is not authenticated or an error occurs, responds accordingly.
     *
     * @return void
     */
    public function buy(): void
    {
        // Ensure the user is authenticated
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            exit('Unauthorized');
        }

        try {
            // Log the button click for "Buy a Cow"
            $logger = $this->loadModel('ActivityLog');
            $logger->log('button_click', 'pageA', 'buy');

            // Return success response
            echo json_encode(['message' => 'Thank you for your purchase!']);
        } catch (\Exception $exception) {
            // Handle exceptions and return error response
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
