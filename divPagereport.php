<?php
include "cr.php";
include "../includes/config.php";
ob_start();
session_start();
date_default_timezone_set('UTC');

if (!isset($_SESSION['user']) and !isset($_SESSION['pass'])) {
    header("location: ../");
    exit();
}

$username = mysqli_real_escape_string($db, $_SESSION['user']);
$tid = isset($_GET['id']) ? mysqli_real_escape_string($db, $_GET['id']) : null;
$uid = mysqli_real_escape_string($db, $_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/tickets.css">
    <style>
        .ticket {
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="form-group col-lg-5">
        <div class="row-fluid sortable ui-sortable">
            <div class="box span12">
                <div class="card-body">
                    @if ($tid)
                        <?php
                        $s = mysqli_query($db, "SELECT * FROM reports WHERE id='$tid' AND uid='$uid'") or die(mysqli_error($db));
                        $r = mysqli_fetch_assoc($s);

                        if (!empty($r)) {
                            $st = $r['status'];
                            switch ($st) {
                                case "0":
                                    $st = "<font color='green'>Closed</font>";
                                    break;
                                case "1":
                                    $st = "<font color='red'>Pending</font>";
                                    break;
                                case "2":
                                    $st = "<font color='orange'>Replied</font>";
                                    break;
                            }
                            echo '<div class="card">
                                    <div class="card-body">
                                        <h3>Report #' . $r['id'] . '</h3>';
                            echo $r['memo'];
                            ?>

                            <br>
                            <?php
                            if ($r['status'] == "0") {
                                echo '<div class="well well-sm">
                                        <strong>Closed Report</strong> <p>This report is closed and you cant reply to it </p>
                                      </div>';
                            } else {
                                ?>
                                <form id="addReply">
                                    <div class="input-group">
                                        <textarea class="form-control custom-control" rows="3" name="Reply" style="resize:none"></textarea>
                                        <span class="input-group-addon btn btn-primary" onclick="$(this).closest('form').submit();">Reply</span>
                                    </div>
                                </form>

                                <script>
                                    var xreply = 0;
                                    $("#addReply").submit(function() {
                                        if (xreply == 1) {
                                            return false;
                                        } else {
                                            xreply = 1;
                                        }
                                        $.ajax({
                                            type: "POST",
                                            url: 'addReportReply<?php echo $tid; ?>.html',
                                            data: $("#addReply").serialize(),
                                            success: function(data) {
                                                if (data == 01) {
                                                    alert('Please enter a valid Reply');
                                                    xreply = 0;
                                                }
                                                if (data != 01) {
                                                    pageDiv('report<?php echo $tid; ?>', 'Report #<?php echo $tid; ?> - Jerux SHOP', 'showReport<?php echo $tid; ?>.html', 1);
                                                }
                                            }
                                        });
                                        return false;
                                    });
                                </script>
                                <?php
                                echo '<br><br>
                                      <div class="well well-sm">
                                          This item currently under review, please be patient it usually doesn't take time until we respond.
                                      </div>';
                            }
                            ?>
                            <?php
                            mysqli_query($db, "UPDATE reports SET seen='0' WHERE id='$tid' and uid='$uid'") or die(mysqli_error($db));
                            ?>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="bs-component">
                                <div class="well well">
                                    <h5><b>Item Information</b></h5>
                                    <?php
                                    function srl($item) {
                                        return trim($item);
                                    }

                                    $srrrr = mysqli_query($db, "SELECT * FROM reports WHERE id='$tid' AND uid='$uid'") or die(mysqli_error());
                                    $rrrrx = mysqli_fetch_assoc($srrrr);

                                    if ($rrrrx['acctype']) {
                                        $itemid = $rrrrx['s_id'];
                                        switch ($rrrrx['acctype']) {
                                            case "cpanel":
                                                $qe = mysqli_query($db, "SELECT * FROM cpanels WHERE id='$itemid'") or die(mysql_error());
                                                while ($rowe = mysqli_fetch_assoc($qe)) {
                                                    $country = $rowe['country'];
                                                    $hosting = $rowe['infos'];
                                                    $price = $rowe['price'];
                                                    $information = $rowe['url'];
                                                    $d = explode("|", $information);
                                                    $url = srl($d[0]);
                                                    $login = srl($d[1]);
                                                    $pass = srl($d[2]);
                                                    $maindom = parse_url($url, PHP_URL_HOST);
                                                    $domain = $rowe['domain'];
                                                    $code = array_search("$country", $countrycodes);
                                                    $countrycode = strtolower($code);
                                                    ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Country</td>
                                                            <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Detect Hosting</td>
                                                            <td><b><?php echo htmlspecialchars($hosting); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Domain</td>
                                                            <td><b><?php echo $domain; ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Url</td>
                                                            <td><b><a href='http://<?php echo $maindom; ?>:2083' onclick='window.open(this.href);return false;'>https://<?php echo $maindom; ?>:2083</a></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>non-https Url</td>
                                                            <td><b><a href='http://<?php echo $maindom; ?>:2082' onclick='window.open(this.href);return false;'>http://<?php echo $maindom; ?>:2082</a></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Username</td>
                                                            <td><b><input id='username' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($login); ?>' /></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Password</td>
                                                            <td><b><input id='password' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($pass); ?>' /></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Price</td>
                                                            <td><b><?php echo htmlspecialchars($price); ?>$</b></td>
                                                        </tr>
                                                    </table>
                                                    <?php
                                                }
                                                break;
                                            case "shell":
                                                $qe = mysqli_query($db, "SELECT * FROM stufs WHERE id='$itemid'") or die(mysql_error());
                                                while ($rowe = mysqli_fetch_assoc($qe)) {
                                                    $country = $rowe['country'];
                                                    $information = $rowe['url'];
                                                    $price = $rowe['price'];
                                                    $code = array_search("$country", $countrycodes);
                                                    $countrycode = strtolower($code);
                                                    ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Country</td>
                                                            <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Shell</td>
                                                            <td><b><a href='<?php echo htmlspecialchars($information); ?>' onclick='window.open(this.href);return false;'><?php echo htmlspecialchars($information); ?></a></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Price</td>
                                                            <td><b><?php echo htmlspecialchars($price); ?>$</b></td>
                                                        </tr>
                                                    </table>
                                                    <?php
                                                }
                                                break;
                                            case "rdp":
                                                $qe = mysqli_query($db, "SELECT * FROM rdps WHERE id='$itemid'") or die(mysql_error());
                                                while ($rowe = mysqli_fetch_assoc($qe)) {
                                                    $country = $rowe['country'];
                                                    $access = $rowe['access'];
                                                    $windows = $rowe['windows'];
                                                    $ram = $rowe['ram'];
                                                    $state = $rowe['city'];
                                                    $hosting = $rowe['hosting'];
                                                    $information = $rowe['url'];
                                                    $price = $rowe['price'];
                                                    $code = array_search("$country", $countrycodes);
                                                    $countrycode = strtolower($code);
                                                    $d = explode("|", $information);
                                                    $url = srl($d[0]);
                                                    $login = srl($d[1]);
                                                    $pass = srl($d[2]);
                                                    ?>
                                                    <table class="table">
                                                        <tr>
                                                            <td>Country</td>
                                                            <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>State</td>
                                                            <td><b><?php echo htmlspecialchars($state); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Host</td>
                                                            <td><b><div class="form-group">
                                                                <div class="input-group col-xs-9">
                                                                    <input class='form-control input-sm' id='host' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($url); ?>' />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary btn-sm copyit" data-clipboard-target="#host">Copy <i class="glyphicon glyphicon-copy"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Login</td>
                                                            <td><b><div class="form-group">
                                                                <div class="input-group col-xs-9">
                                                                    <input class='form-control input-sm' id='login' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($login); ?>' />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary btn-sm copyit" data-clipboard-target="#login">Copy <i class="glyphicon glyphicon-copy"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Password</td>
                                                            <td><b><div class="form-group">
                                                                <div class="input-group col-xs-9">
                                                                    <input class='form-control input-sm' id='password' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($pass); ?>' />
                                                                    <span class="input-group-btn">
                                                                        <button class="btn btn-primary btn-sm copyit" data-clipboard-target="#password">Copy <i class="glyphicon glyphicon-copy"></i></button>
                                                                    </span>
                                                                </div>
                                                            </div></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Windows</td>
                                                            <td><b><?php echo htmlspecialchars($windows); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Access</td>
                                                            <td><b><?php echo htmlspecialchars($access); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ram</td>
                                                            <td><b><?php echo htmlspecialchars($ram); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Detect Hosting</td>
                                                            <td><b><?php echo htmlspecialchars($hosting); ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Price</td>
                                                            <td><b><?php echo htmlspecialchars($price); ?>$</b></td>
                                                        </tr>
                                                    </table>
                                                    <?php
                                                }
                                                break;
                                            // Add other cases similarly
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="mainDiv">
                            <blockquote>
                                <p>Report was not found or you don't have permission to access it</p>
                                <small>Go to your <cite>Reports</cite> in order to check all your reports</small>
                            </blockquote>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>