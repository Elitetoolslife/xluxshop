Since you’re using BladeOne as your templating engine in a core PHP project, you should separate your PHP logic from your HTML views while keeping the BladeOne structure. Below is how you can refactor your order list page using BladeOne.

Steps to Convert to BladeOne

	1.	Move all PHP logic to a controller or a separate PHP file.
	2.	Pass data (orders, user session, etc.) to BladeOne.
	3.	Convert HTML output into a Blade template.

1. Controller: orders.php

Create a new file lche'; // Path to store compiled Blade templates
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
<?php

namespace App\Http\Controllers;

use eftec\bladeone\BladeOne;
use mysqli;

class OrderController extends Controller
{
    protected $db;
    protected $blade;

    public function __construct($db)
    {
        $this->db = $db;
        $views = __DIR__ . '/../../../views';
        $cache = __DIR__ . '/../../../storage/cache';
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
    }
public function orders()
{
    ob_start();
    session_start();
    error_reporting(E_ALL);
    date_default_timezone_set('UTC');

    if (!isset($_SESSION['user']) and !isset($_SESSION['pass'])) {
        header("location: ../");
        exit();
    }

    // Ensure $_SESSION['user'] is a string
    $username = is_array($_SESSION['user']) ? implode(',', $_SESSION['user']) : $_SESSION['user'];
    
    // Now use mysqli_real_escape_string safely
    $username = mysqli_real_escape_string($this->db, $username);


$real_data = date("Y-m-d H:i:s");
$usrid = mysqli_real_escape_string($dbcon, $_SESSION['sname']);
$query = "SELECT p.*, r.id AS report_id, r.uid 
          FROM purchases p 
          LEFT JOIN reports r ON p.s_id = r.s_id AND r.uid = '$usrid'
          WHERE p.buyer='$usrid' ORDER BY p.id DESC";

$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $order = [
        'id' => $row['id'],
        'type' => strtoupper($row['type']),
        'url' => $row['url'],
        'price' => $row['price'],
        'seller' => "seller" . $row['s_id'], // Seller ID prefix
        'date' => $row['date'],
        'reported' => $row['reported'],
        'report_id' => $row['report_id'],
        'expired' => (strtotime($real_data) > strtotime("+600 minutes", strtotime($row['date'])) && $row['reported'] == ""),
    ];
    $orders[] = $order;
}

// Render Blade template
echo $blade->run("orders", compact('orders'));
?>

2. Blade Template: views/orders/index.blade.php

Convert the HTML table into a Blade template.

@extends('layouts.app')

@section('content')
<div class="well">
    <h2 class="text-center">
        <small><font color="#080C39"><span class="glyphicon glyphicon-shopping-cart"></span></font></small>
        My Orders
    </h2>
    <p class="text-center">
        You can only report a bad tool within <b>10 hours</b> by clicking on
        <a class="btn btn-primary btn-xs"><font color=white>Report #[Order Id]</font></a>,
        otherwise, we can't give you a refund or replacement!
    </p>
</div>

<table class="table table-striped table-bordered table-condensed" id="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Item</th>
            <th>Open</th>
            <th>Price</th>
            <th>Seller</th>
            <th>Report</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order['id'] }}</td>
                <td>{{ $order['type'] }}</td>
                <td>{{ $order['url'] }}</td>
                <td>
                    <button onclick="openItem({{ $order['id'] }})" class="btn btn-primary btn-xs">
                        Open #{{ $order['id'] }}
                    </button>
                </td>
                <td>{{ $order['price'] }}</td>
                <td>{{ $order['seller'] }}</td>
                <td>
                    @if ($order['expired'])
                        Time expired
                    @elseif ($order['reported'] == "1")
                        <a href="vr-{{ $order['report_id'] }}.html"><font color='green'><u>#{{ $order['report_id'] }}</u></font></a>
                    @else
                        <a data-toggle="modal" class="btn btn-primary btn-xs" data-target="#reportModal{{ $order['id'] }}">
                            <font color=white>Report #{{ $order['id'] }}</font>
                        </a>
                    @endif
                </td>
                <td>{{ $order['date'] }}</td>
            </tr>

            <!-- Report Modal -->
            <div class="modal fade" id="reportModal{{ $order['id'] }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Report Form</h4>
                        </div>
                        <div class="modal-body">
                            <div class="well well-sm">
                                <h4><b>Report Of Order #{{ $order['id'] }}</b></h4>
                                <p>Please write clearly what is wrong with this <b>{{ $order['type'] }}</b> and why you want to refund it.</p>
                            </div>
                            <div id="resulta{{ $order['id'] }}">
                                <div class="input-group">
                                    <textarea id="msg{{ $order['id'] }}" class="form-control custom-control" rows="3" required></textarea>
                                    <span class="input-group-addon btn btn-primary" onclick="sendt({{ $order['id'] }})">
                                        Submit
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="orderModalHeader"></h4>
            </div>
            <div class="modal-body" id="orderModalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function sendt(id) {
    var msg = $("#msg" + id).val();
    $.ajax({
        method: "GET",
        url: "CreateReport.html?id=" + id + "&m=" + btoa(msg),
        dataType: "text",
        success: function(data) {
            $("#resulta" + id).html(data).show();
        },
    });
}

function openItem(order) {
    $("#orderModalHeader").text('Order #' + order);
    $('#orderModal').modal('show');
    $.ajax({
        type: 'GET',
        url: 'showOrder' + order + '.html',
        success: function(data) {
            $("#orderModalBody").html(data).show();
        }
    });
}
</script>
@endsection

3. Blade Layout (Optional)

If you’re using a layout system, create a views/layouts/app.blade.php:

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>

Final Outcome

✅ Separation of Concerns – PHP logic in orders.php, UI in index.blade.php.
✅ Improved Readability & Maintainability.
✅ Easier Future Expansions (Reusability with Blade layouts).

Let me know if you need further improvements!