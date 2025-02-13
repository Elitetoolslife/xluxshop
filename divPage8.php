<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../../config/countrycodes.php'; // expects $countrycodes array
require 'vendor/autoload.php';

use eftec\bladeone\BladeOne;
use App\Models\User;

class OrderController extends BaseController {
    private $blade;
    private $db;
    private $countrycodes;

    public function __construct($db, array $countrycodes) {
        $views = __DIR__ . '/../../../views';   // Blade templates folder
        $cache = __DIR__ . '/../../../cache';   // Cache folder
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        $this->db = $db;
        $this->countrycodes = $countrycodes;
    }

    public function showHuntingtonbank() {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            header("Location: /login");
            exit();
     }
                    $query = mysql_query($db, "SELECT DISTINCT `country` FROM `huntingtonbanks` WHERE `sold` = '0' ORDER BY country ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo '<option value="' . htmlspecialchars($row['country']) . '">' . htmlspecialchars($row['country']) . '</option>';
                    }
                    
       $query = mysqli_query($db, "SELECT DISTINCT `resseller` FROM `huntingtonbanks` WHERE `sold` = '0' ORDER BY resseller ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $qer = mysqli_query($db, "SELECT DISTINCT `id` FROM resseller WHERE username='" . mysqli_real_escape_string($db, $row['resseller']) . "' ORDER BY id ASC") or die(mysqli_error($db));
                        while ($rpw = mysqli_fetch_assoc($qer)) {
                            $SellerNick = "seller" . htmlspecialchars($rpw["id"]);
                            echo '<option value="' . $SellerNick . '">' . $SellerNick . '</option>';
                        }
                    }
        include("config/countrycodes.php");
        $q = mysqli_query($db, "SELECT * FROM huntingtonbanks WHERE sold='0' ORDER BY RAND()") or die(mysqli_error($db));
        while ($row = mysqli_fetch_assoc($q)) {
            $countryfullname = $row['country'];
            echo "
            <tr id='row{$row['id']}'>     
                <td>" . htmlspecialchars($row['country']) . "</td>
                <td>" . htmlspecialchars($row['huntingtonbankname']) . "</td>
                <td>Seller " . htmlspecialchars($row['resseller']) . "</td>
                <td>$" . htmlspecialchars($row['balance']) . "</td>
                <td>" . htmlspecialchars($row['infos']) . "</td>
                <td>$" . htmlspecialchars($row['price']) . "</td>
                <td>" . $row['date'] . "</td>
                <td>
                    <button onclick='buythistool(" . $row['id'] . ")' class='btn btn-warning btn-sm'>
                        <i class='fas fa-shopping-cart'></i> Buy
                    </button>
                </td>
            </tr>";
        }
        public function BuyHuntingtonbank() 
         {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            header("Location: /login");
            exit();
     }

include "includes/config.php";

$usrid = mysqli_real_escape_string($db, $_SESSION['sname']);
$uid = mysqli_real_escape_string($db, $_POST['id']);
$price = mysqli_real_escape_string($db, $_POST['price']);
$date = date("Y-m-d H:i:s");

// Fetch user details
$qqs2 = @mysqli_query($db, "SELECT * FROM users WHERE username='$usrid'") or die();
$rows2 = mysqli_fetch_assoc($qqs2);
$balance = $rows2['balance'];
$ipur = $rows2['ipurchassed'];

// Fetch the item details
$query = "SELECT * FROM huntingtonbanks WHERE id = '$uid' LIMIT 1";
$result = mysqli_query($db, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_assoc($result);
    $price = $rows['price'];
    $country = mysqli_real_escape_string($db, $rows['country']);
    $infos = mysqli_real_escape_string($db, $rows['infos']);
    $url = mysqli_real_escape_string($db, $rows['url']);
    $login = mysqli_real_escape_string($db, $rows['login']);
    $pa = mysqli_real_escape_string($db, $rows['pass']);
    $resseller = mysqli_real_escape_string($db, $rows['resseller']);
    $acctype = mysqli_real_escape_string($db, $rows['acctype']);  // Fetch account type

    if ($balance >= $price) {
        // Update balance and complete purchase
        $newb = $balance - $price;
        $newb2 = mysqli_real_escape_string($db, $newb);

        // Mark as sold
        mysqli_query($db, "UPDATE huntingtonbanks SET sold='1', sto='$usrid', dateofsold='$date' WHERE id='$uid'");
        mysqli_query($db, "UPDATE users SET balance='$newb2', ipurchassed=ipurchassed+1 WHERE username='$usrid'");

        // Record the purchase with the account type
        mysqli_query($db, "INSERT INTO orders
            (s_id, buyer, type, date, country, infos, url, login, pass, price, resseller)
            VALUES
            ('$uid', '$usrid', '$acctype', '$date', '$country', '$infos', '$url', '$login', '$pa', '$price', '$resseller')
        ");

        // Update reseller's stats
        mysqli_query($db, "UPDATE resseller SET allsales=(allsales + $price), soldb=(soldb + $price) WHERE username='$resseller'");

        echo json_encode(["status" => "success", "message" => "Purchase successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Not enough balance"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Item not found"]);
}
        
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>huntingtonbank Listings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toast.js/1.3.0/toast.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toast.js/1.3.0/toast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .fade-out {
            transition: opacity 1s ease-out;
            opacity: 0;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">huntingtonbank Listings</a>
        </div>
    </div>
</nav>

<ul class="nav nav-tabs">
    <li class="active"><a href="#filter" data-toggle="tab">Filter</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="filter">
        <div class="filter-container">
            <div class="filter-row">
                <label for="huntingtonbank_country">Country:</label>
                <select class="filterselect form-control input-sm" name="huntingtonbank_country" id="huntingtonbank_country">
                    <option value="">ALL</option>
                    
                </select>
            </div>
            <div class="filter-row">
                <label for="huntingtonbank_sitename">Site Name:</label>
                <input class="filterinput form-control input-sm" name="huntingtonbank_sitename" id="huntingtonbank_sitename" size="3">
            </div>
            <div class="filter-row">
                <label for="huntingtonbank_seller">Seller:</label>
                <select class="filterselect form-control input-sm" name="huntingtonbank_seller" id="huntingtonbank_seller">
                    <option value="">ALL</option>
             
                </select>
            </div>
            <div class="filter-row">
                <button id="filterbutton" class="btn btn-primary btn-sm" disabled>Filter</button>
            </div>
        </div>
    </div>
</div>

<table id="table" class="table table-striped">
    <thead>
        <tr>
            <th>Country</th>
            <th>Site Name</th>
            <th>Seller</th>
            <th>Balance</th>
            <th>Available Information</th>
            <th>Price</th>
            <th>Added on</th>
            <th>Buy</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

<div id="success-toast" class="alert alert-success fade-out" style="display:none;">
    Order placed successfully!
</div>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").fadeOut(1000);
        }, 3000);

        $('#filterbutton').click(function() {
            var table = $('#table').DataTable();
            table.draw();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var country = $.trim(data[0].toLowerCase());
                var sitename = $.trim(data[1].toLowerCase());
                var filterCountry = $.trim($("#huntingtonbank_country").val().toLowerCase());
                var filterSitename = $.trim($("#huntingtonbank_sitename").val().toLowerCase());

                if ((filterCountry === "" || country === filterCountry) &&
                    (filterSitename === "" || sitename.includes(filterSitename))) {
                    return true;
                }
                return false;
            }
        );
    });

    function buythistool(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to proceed with the purchase?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, buy it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait for 5 seconds...',
                    timer: 5000,
                    didOpen: () => {
                        Swal.showLoading()
                        $.ajax({
                            url: `buytool.php?id=${id}&t=huntingtonbanks`,
                            method: 'GET',
                            dataType: 'text',
                            success: function(data) {
                                Swal.close();
                                if (data.match(/<button/)) {
                                    $("#success-toast").show().delay(3000).fadeOut(1000);
                                    $("#row" + id).fadeOut(1000, function() { $(this).remove(); });
                                } else {
                                    Swal.fire("Error!", "Not enough balance!", "error");
                                }
                            }
                        });
                    }
                });
            }
        });
    }

    function openitem(order) {
        $("#myModalLabel").text(`Order #${order}`);
        $('#myModal').modal('show');
        $.ajax({
            url: `showOrder${order}.html`,
            method: 'GET',
            success: function(data) {
                $("#modelbody").html(data);
            }
        });
    }
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" id="modelbody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>