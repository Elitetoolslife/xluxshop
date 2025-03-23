<?php
namespace App\Controllers\Admin;

use App\Libraries\Admin\TemplateEngine;
use App\Core\Session;
use App\Models\User;
use App\Core\Database;
use App\Models\News;
use App\Models\Orders;
use App\Models\Tickets;
use App\Models\Reports;
use App\Helpers\CsrfHelper;
use App\Controllers\Controller;

<?php
namespace App\Controllers\Admin\Banks\USA;
/*
|--------------------------------------------------------------------------
| HuntingtonController
|--------------------------------------------------------------------------
|
| Description: Handles US bank operations for Huntington Bank including
| session management, view rendering, CSRF validation, and purchase handling.
|
*/
use App\Libraries\Admin\TemplateEngine;
use App\Core\Session;
use App\Core\Database;
use App\Helpers\CsrfHelper;
use App\Models\Banks;
use App\Models\User;
use App\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| HuntingtonController
|--------------------------------------------------------------------------
|
| Description: Handles US bank operations for Huntington Bank including
| session management, view rendering, CSRF validation, and purchase handling.
|
*/
class BBVAController extends Controller 

    /**
     * Main account dashboard.
     */

    public function index() {
        Session::start();
        $user_id = Session::get('user_id');
        if (!$user_id) {
            Session::destroy();
            return $this->redirect('/login');
        }

        $user = User::findById($user_id);
        if (!$user) {
            Session::destroy();
            return $this->redirect('/login');
        }

        // Orders counters
        $allOrdersCount  = Orders::countAllOrders();
        $completedCount  = Orders::countCompletedOrders();
        $reportedCount   = Orders::countReportedOrders();
        $rejectedCount   = Orders::countRejectedOrders();

        // Tickets counters
        $tickets         = Tickets::findByUser($user->username);
        $ticketsCount    = count($tickets);
        $newAdminReplies = Tickets::countNewAdminReplies();
        $refundedCount   = Tickets::countRefundedTickets();

        // Reports counter
        $reportsCount = (new Reports())->countActiveReports($user->id);

        // Latest news
        $news = News::findAll() ?: [];

        // Generate CSRF token
        $csrf_token = CsrfHelper::generateToken();

        // Display header
        TemplateEngine::displayHeader(['csrf_token' => $csrf_token]);

        // Display the main content
        \$this->render('admin/main/index', [
            'user'             => $user,
            'orders'           => Orders::findByBuyer($user->username),
            'allOrdersCount'   => $allOrdersCount,
            'completedCount'   => $completedCount,
            'reportedCount'    => $reportedCount,
            'rejectedCount'    => $rejectedCount,
            'ticketsCount'     => $ticketsCount,
            'newAdminReplies'  => $newAdminReplies,
            'refundedCount'    => $refundedCount,
            'reportsCount'     => $reportsCount,
            'news'             => $news,
            'tableConfig'      => \$this->tableConfig,
            'csrf_token'       => $csrf_token
        ]);

        // Display footer
        TemplateEngine::displayFooter();
    }
     /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/
   {
    /**************************************************************************
     * Function: index
     * -------------------------------------------------------------------------
     * Handles session management, data retrieval, CSRF token generation, and
     * view rendering for the main index page.
     **************************************************************************/
    public function index() {
        Session::start();
        $user_id = Session::get('user_id');
        if (!$user_id) {
            Session::destroy();
            return $this->redirect('/login');
        }  
    /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        $user = User::findById($user_id);
        if (!$user) {
            Session::destroy();
            return $this->redirect('/login');
        }
        /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/
  
        $banks = Banks::getBanks([]);
        $countrycodes = require __DIR__ . '/../../../../config/countrycodes.php';
        $csrf_token = CsrfHelper::generateToken();
          /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        $header = $this->renderHeader(['csrf_token' => $csrf_token]);
/**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/
        ob_start();
        $this->render('account/us/bbva-log-full-info/index',
        [
            'user'         => $user,
            'banks'        => $banks,
            'countrycodes' => $countrycodes,
            'csrf_token'   => $csrf_token
        ]);
/**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/
        $content = ob_get_clean();
        $footer = $this->renderFooter();
        echo $header . $content . $footer;
    }

    /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/
    private function renderHeader(array $data = []): string
    {


/**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        $headerPath = __DIR__ . '/../../../../resources/views/LayoutHeader.php';
/**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/
        if (file_exists($headerPath)) {
            extract($data);
            ob_start();
            require_once $headerPath;
            return ob_get_clean();
        }
        return '';
    }

    /**************************************************************************
     * Function: renderFooter
     * -------------------------------------------------------------------------
     * Renders the footer view from resources/views/LayoutFooter.php.
     **************************************************************************/
    private function renderFooter(array $data = []): string
    {

/**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        $footerPath = __DIR__ . '/../../../../resources/views/LayoutFooter.php';

/**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        if (file_exists($footerPath)) {
            extract($data);
            ob_start();
            require_once $footerPath;
            return ob_get_clean();
        }
        return '';
    }

    /**************************************************************************
     * Function: getBanksData
     * -------------------------------------------------------------------------
     * Retrieves bank data, maps the banks information, and returns a JSON 
     * response.
     **************************************************************************/
    public function getBanksData() {
        try {
            $banks = Banks::getBanks($_GET);

            if (!$banks) {
                return $this->jsonResponse(['error' => 'No data found'], 404);
            }
      /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

            $response = [
                'draw'            => intval($_GET['draw'] ?? 1),
                'recordsTotal'    => count($banks),
                'recordsFiltered' => count($banks),
                'data'            => array_map(function ($bank) {
                    return [
                        'id'        => $bank['id'] ?? '',
                        'acctype'   => $bank['acctype'] ?? '',
                        'country'       => $bank['country'] ?? '',
                        'country_code'  => strtolower($bank['country_code'] ?? 'us'),
                        'infos'     => $bank['infos'] ?? '',
                        'price'     => $bank['price'] ?? 0,
                        'date'      => $bank['date'] ?? '',
                        'resseller' => $bank['resseller'] ?? '',
                        'bankname'  => $bank['bankname'] ?? '',
                        'balance'   => $bank['balance'] ?? 0
                    ];
                }, $banks)
            ];
     /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

            return $this->jsonResponse($response);
        } catch (\Exception $e) {
            error_log("Error in getBanksData: " . $e->getMessage());
            return $this->jsonResponse(['error' => 'Server error'], 500);
        }
    }

    /**************************************************************************
     * Function: buy
     * -------------------------------------------------------------------------
     * Processes purchase requests, handles user and item validation, deducts
     * balance, updates records, and logs purchase details.
     **************************************************************************/
    public function buy() {
        Session::start();

        $db = Database::connect(); 
        $user_id = Session::get('user_id');

        if (!$user_id) {
            return $this->jsonResponse(['error' => 'Unauthorized'], 403);
        }
  /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        $itemId = $_POST['id'] ?? null;
        $token  = $_POST['_token'] ?? null;

        if (!$itemId || !$token || !CsrfHelper::validateToken($token)) {
            return $this->jsonResponse(['error' => 'Invalid parameters or CSRF token.'], 400);
        }
  /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Fetch user details
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$user) {
            return $this->jsonResponse(['error' => 'User not found.'], 404);
        }
     /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Ensure the correct table and column are used
        $stmt = $db->prepare("SELECT * FROM banks WHERE id = ? AND (sold = 0)"); 
        $stmt->bind_param("i", $itemId);
        $stmt->execute();
        $item = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        if (!$item) {
            return $this->jsonResponse(['error' => 'Item not found or already sold.'], 404);
        }

        // Check user balance
        if ($user['balance'] < $item['price']) {
            return $this->jsonResponse(['error' => 'Insufficient balance.'], 400);
        }
  /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Assign default values where needed
        $login     = $item['login'] ?? 'N/A';
        $password  = $item['pass'] ?? 'N/A';
        $url       = $item['url'] ?? 'N/A';
        $infos     = $item['infos'] ?? 'No info available';
        $acctype   = $item['acctype'] ?? 'Unknown';
        $resseller = $item['resseller'] ?? 'Unknown';
  /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Deduct balance
        $newBalance = $user['balance'] - $item['price'];
        $stmt = $db->prepare("UPDATE users SET balance = ?, ipurchassed = ipurchassed + 1 WHERE id = ?");
        $stmt->bind_param("di", $newBalance, $user_id);
        $stmt->execute();
        $stmt->close();
     /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Mark item as sold
        $date = date("Y-m-d H:i:s");
        $stmt = $db->prepare("UPDATE banks SET sold = 1, sto = ?, dateofsold = ? WHERE id = ?");
        $stmt->bind_param("ssi", $user['username'], $date, $itemId);
        $stmt->execute();
        $stmt->close();
     /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Insert purchase record
        $stmt = $db->prepare("INSERT INTO orders (s_id, buyer, type, date, country, infos, url, login, pass, price, resseller) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssds", 
                          $itemId, $user['username'], $acctype, $date, $item['country'], $infos, 
                          $url, $login, $password, $item['price'], $resseller);
        $stmt->execute();
        $stmt->close();
     /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

        // Update reseller sales stats
        $stmt = $db->prepare("UPDATE resseller SET allsales = allsales + ?, soldb = soldb + ? WHERE username = ?");
        $stmt->bind_param("dds", $item['price'], $item['price'], $resseller);
        $stmt->execute();
        $stmt->close();

        return $this->jsonResponse(["success" => "Purchase successful."]);
    }
    /**************************************************************************
     * Function: renderHeader
     * -------------------------------------------------------------------------
     * Renders the header view from resources/views/LayoutHeader.php.
     **************************************************************************/

    protected function jsonResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit();
    }


    /**
     * Main account dashboard.
     */
   public function index() {
    Session::start();
    $user_id = Session::get('user_id');
    if (!$user_id) {
        Session::destroy();
        return $this->redirect('/login');
    }

    $user = User::findById($user_id);
    if (!$user) {
        Session::destroy();
        return $this->redirect('/login');
    }

    // Orders counters
    $allOrdersCount  = Orders::countAllOrders();
    $completedCount  = Orders::countCompletedOrders();
    $reportedCount   = Orders::countReportedOrders();
    $rejectedCount   = Orders::countRejectedOrders();

    // Tickets counters
    $tickets         = Tickets::findByUser($user->username);
    $ticketsCount    = count($tickets);
    $newAdminReplies = Tickets::countNewAdminReplies();
    $refundedCount   = Tickets::countRefundedTickets();

    // Reports counter
    $reportsCount = (new Reports())->countActiveReports($user->id);

    // Latest news
    $news = News::findAll() ?: [];

    // Generate CSRF token
    $csrf_token = CsrfHelper::generateToken();

    // Display header
    TemplateEngine::displayHeader(['csrf_token' => $csrf_token]);

    // Display the main content
    $this->render('admin/main/index', [
        'user'             => $user,
        'orders'           => Orders::findByBuyer($user->username),
        'allOrdersCount'   => $allOrdersCount,
        'completedCount'   => $completedCount,
        'reportedCount'    => $reportedCount,
        'rejectedCount'    => $rejectedCount,
        'ticketsCount'     => $ticketsCount,
        'newAdminReplies'  => $newAdminReplies,
        'refundedCount'    => $refundedCount,
        'reportsCount'     => $reportsCount,
        'news'             => $news,
        'tableConfig'      => $this->tableConfig,
        'csrf_token'       => $csrf_token
    ]);

    // Display footer
    TemplateEngine::displayFooter();
}
}