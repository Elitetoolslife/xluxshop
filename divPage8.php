<?php
ob_start();
session_start();
date_default_timezone_set('UTC');
include "../includes/config.php";

if (!isset($_SESSION['sname']) && !isset($_SESSION['spass'])) {
    header("location: ../");
    exit();
}
$usrid = mysqli_real_escape_string($dbcon, $_SESSION['sname']);
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
                    <?php
                    $query = mysqli_query($dbcon, "SELECT DISTINCT `country` FROM `huntingtonbanks` WHERE `sold` = '0' ORDER BY country ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo '<option value="' . htmlspecialchars($row['country']) . '">' . htmlspecialchars($row['country']) . '</option>';
                    }
                    ?>
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
                    <?php
                    $query = mysqli_query($dbcon, "SELECT DISTINCT `resseller` FROM `huntingtonbanks` WHERE `sold` = '0' ORDER BY resseller ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        $qer = mysqli_query($dbcon, "SELECT DISTINCT `id` FROM resseller WHERE username='" . mysqli_real_escape_string($dbcon, $row['resseller']) . "' ORDER BY id ASC") or die(mysqli_error($dbcon));
                        while ($rpw = mysqli_fetch_assoc($qer)) {
                            $SellerNick = "seller" . htmlspecialchars($rpw["id"]);
                            echo '<option value="' . $SellerNick . '">' . $SellerNick . '</option>';
                        }
                    }
                    ?>
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
        <?php
        include("cr.php");
        $q = mysqli_query($dbcon, "SELECT * FROM huntingtonbanks WHERE sold='0' ORDER BY RAND()") or die(mysqli_error($dbcon));
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
        ?>
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