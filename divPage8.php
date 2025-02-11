<?php
ob_start();
session_start();
date_default_timezone_set('UTC');
require_once "includes/config.php";
require_once "templates/header.php";
require_once "templates/style.php";
require_once "templates/navbar.php";
if (!isset($_SESSION['sname']) && !isset($_SESSION['spass'])) {
    header("location: ../");
    exit();
}
$usrid = mysqli_real_escape_string($dbcon, $_SESSION['sname']);
?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#filter" data-toggle="tab">Filter</a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="filter">
        <div class="filter-container">
            <div class="filter-row">
                <label for="huntington_country">Country:</label>
                <select class="filterselect form-control input-sm" name="huntington_country" id="huntington_country">
                    <option value="">ALL</option>
                    <?php
                    $query = mysqli_query($dbcon, "SELECT DISTINCT `country` FROM `huntington` WHERE `sold` = '0' ORDER BY country ASC");
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo '<option value="' . htmlspecialchars($row['country']) . '">' . htmlspecialchars($row['country']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="filter-row">
                <label for="huntington_sitename">Site Name:</label>
                <input class="filterinput form-control input-sm" name="huntington_sitename" id="huntington_sitename" size="3">
            </div>
            <div class="filter-row">
                <label for="huntington_seller">Seller:</label>
                <select class="filterselect form-control input-sm" name="huntington_seller" id="huntington_seller">
                    <option value="">ALL</option>
                    <?php
                    $query = mysqli_query($dbcon, "SELECT DISTINCT `resseller` FROM `huntington` WHERE `sold` = '0' ORDER BY resseller ASC");
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

<table id="table" class="display">
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
        $q = mysqli_query($dbcon, "SELECT * FROM huntington WHERE sold='0' ORDER BY RAND()")or die(mysqli_error());
        while ($row = mysqli_fetch_assoc($q)) {
            $countryfullname = htmlspecialchars($row['country']);
            $code = array_search("$countryfullname", $countrycodes);
            $countrycode = strtolower($code);
            $qer = mysqli_query($dbcon, "SELECT * FROM resseller WHERE username='" . mysqli_real_escape_string($dbcon, $row['resseller']) . "'") or die(mysqli_error($dbcon));
            while ($rpw = mysqli_fetch_assoc($qer)) {
                $SellerNick = "seller" . htmlspecialchars($rpw["id"]);
                echo "
                <tr>
                    <td id='huntington_country'><i class='flag-icon flag-icon-$countrycode'></i>&nbsp;" . htmlspecialchars($row['country']) . "</td>
                    <td><span type='button' class='badge badge-success' title='Linux a2plcpnl0739.prod.iad2.secureserver.net 2.6.32-954.3.5.lve1.4.92.el6.x86_64 #1 SMP Tue Jul 4 15:05:25 UTC 2023 x86'><i class='fab fa-linux'></i> " . htmlspecialchars($row['bankname']) . "</span><span class='alert alert-warning det-host-info' style='display:none'>Linux a2plcpnl0739.prod.iad2.secureserver.net 2.6.32-954.3.5.lve1.4.92.el6.x86_64 #1 SMP Tue Jul 4 15:05:25 UTC 2023 x86</span></td>
                    <td><span type='button' class='badge badge-warning' title='Linux a2plcpnl0739.prod.iad2.secureserver.net 2.6.32-954.3.5.lve1.4.92.el6.x86_64 #1 SMP Tue Jul 4 15:05:25 UTC 2023 x86'><i class='fab fa-linux'></i> $" . htmlspecialchars($row['balance']) . "</span><span class='alert alert-dark det-host-info' style='display:none'>Linux a2plcpnl0739.prod.iad2.secureserver.net 2.6.32-954.3.5.lve1.4.92.el6.x86_64 #1 SMP Tue Jul 4 15:05:25 UTC 2023 x86</span></td>
                    <td>" . htmlspecialchars($row['infos']) . "</td>
                    <td><span type='button' class='badge badge-dark' title='Linux a2plcpnl0739.prod.iad2.secureserver.net 2.6.32-954.3.5.lve1.4.92.el6.x86_64 #1 SMP Tue Jul 4 15:05:25 UTC 2023 x86'> $" . htmlspecialchars($row['price']) . "</span><span class='alert alert-dark det-host-info' style='display:none'>Linux a2plcpnl0739.prod.iad2.secureserver.net 2.6.32-954.3.5.lve1.4.92.el6.x86_64 #1 SMP Tue Jul 4 15:05:25 UTC 2023 x86</span></td>
                    <td>" . $row['date'] . "</td>
                    <td><span id='huntington{$row['id']}' title='buy' type='huntington'><a onclick='buythistool({$row['id']})' class='btn btn-primary btn-xs'><font color=white>Buy</font></a></span></td>
                </tr>
                ";
            }
        }
        ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#table').DataTable();

    $('#filterbutton').click(function() {
        var table = $('#table').DataTable();
        table.draw();
    });

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var ck1 = $.trim(data[0].toLowerCase());
            var ck2 = $.trim(data[1].toLowerCase());
            var ck3 = $.trim(data[2].toLowerCase());
            var fk1 = $.trim($("#huntington_country").val().toLowerCase());
            var fk2 = $.trim($("#huntington_sitename").val().toLowerCase());
            var fk3 = $.trim($("#huntington_seller").val().toLowerCase());

            if ((fk1 === "" || ck1 === fk1) && (fk2 === "" || ck2.includes(fk2)) && (fk3 === "" || ck3 === fk3)) {
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
                        url: `buy/huntington.php?id=${id}`,
                        method: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            Swal.close();
                            if (data.status === 'success') {
                                Swal.fire('Success!', 'Order placed successfully!', 'success').then(() => {
                                    $("#huntington" + id).html('<button onclick="openitem(' + data.order_id + ')" class="btn btn-primary btn-xs"> Order #' + data.order_id + '</button>');
                                });
                            } else {
                                Swal.fire('Error!', data.message, 'error');
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