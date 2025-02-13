<?php

namespace App\Http\Controllers;

require_once __DIR__ . '/../../../config/countrycodes.php'; // Expects $countrycodes array
require 'vendor/autoload.php';
use eftec\bladeone\BladeOne;
use App\Models\User;

class OrderController {
    private $blade;
    private $db;
    private $countrycodes;

    public function __construct($db) {
        $views = __DIR__ . '/../../../views';   // Blade templates folder
        $cache = __DIR__ . '/../../../cache';   // Cache folder
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        $this->db = $db;
        global $countrycodes;
        $this->countrycodes = $countrycodes;
    }

    public function orders() {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            header("Location: /login");
            exit();
        }
        $action = $_GET['action'] ?? 'view';
        if ($action !== 'view') {
            header('Content-Type: application/json');
            if ($action === 'getOrders') {
                echo json_encode($this->getOrders($user));
            } elseif ($action === 'report') {
                echo json_encode($this->reportOrder($user));
            } elseif ($action === 'details' && isset($_GET['id'])) {
                echo json_encode($this->getOrderDetails($_GET['id'], $user));
            } else {
                echo json_encode(["error" => "Invalid action."]);
            }
            exit();
        }
        echo $this->blade->run("orders", ["orders" => $this->getOrders($user)]);
    }

    public function getOrderDetailsApi() {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            echo json_encode(["error" => "Unauthorized"]);
            exit();
        }
        if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo json_encode(["error" => "Invalid order ID"]);
            exit();
        }
        $orderId = intval($_GET['id']);
        $details = $this->getOrderDetails($orderId, $user);
        echo json_encode(isset($details['error']) ? $details : ["success" => true, "data" => $details]);
        exit();
    }

    private function getOrders($user) {
while ($row = mysqli_fetch_assoc($q)) {
    $idorder   = $row['id'];
    $toollink1 = $row['url'];
    $sidd      = $row['s_id'];
    $type      = $row['type'];
    $info      = $row['url'];
    $desc      = $row['infos'];
    echo "<tr>
	    <td> " . $row['id'] . " </td>
    <td> " . strtoupper($row['type']) . " </td>
    <td> " . $row['url'] . " </td>";
    <td> 
<button onclick="openitem{{( $idorder; )}}" class="btn btn-primary btn-xs"> Open #{{ ( $idorder;) }}</button>

   
	 	 	    $qer = mysqli_query($dbcon, "SELECT * FROM resseller WHERE username='".$row['resseller']."'")or die(mysql_error());
		   while($rpw = mysqli_fetch_assoc($qer))
			 $SellerNick = "seller".$rpw["id"]."";
    echo "
    <td> " . $row['price'] . "</td>
	    <td> " . $SellerNick . "</td>
    <td> ";
	$pending= 0;
    $date_purchased = $row['date'];
    $endTime        = strtotime("+600 minutes", strtotime($date_purchased));
    $data_plus      = date('Y-m-d H:i:s', $endTime);
    if (($real_data > $data_plus) && ($row['reported'] == "")) {
        echo 'Time expired';
    } else {
        if ($row['reported'] == "1") {
            $qrrr = mysqli_query($dbcon, "SELECT * FROM reports WHERE s_id='$sidd' and uid='$user'") or die(mysqli_error());
            while ($rowe = mysqli_fetch_assoc($qrrr)) {
                $idreport = $rowe['id'];
                echo "<font color='green'><a href='vr-$idreport.html'><u>#$idreport</u></font></a>";
            }
        } else {
            echo '<a data-toggle="modal" class="btn btn-primary btn-xs" data-target="#myModald' . $row["id"] . '" >
<font color=white>Report #[' . $idorder . '] </a></center>';
        }
    }
    echo "</td>
		    <td> " . $row['date'] . "</td>
    </tr>";
    
    echo '
 
<div class="modal fade" id="myModald' . $row['id'] . '" >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">
                                              Report Form
                                            </h4>
                                        </div>
                                        <div class="modal-body">
<div class="well well-sm">
  <h4><b>Report Of Order #' . $row['id'] . ' </b></h4>
  <p>Please write clearly what is wrong with this <b>'.$row['type'].'</b> and why you want to refund it</p>
</div>
<div id="resulta' . $row['id'] . '">
<div class="input-group">
    <textarea id="msg' . $row['id'] . '"  class="form-control custom-control" rows="3" name="memo" style="resize:none" required=""></textarea>     
    <span id="xreport" class="input-group-addon btn btn-primary" onclick="this.disabled=true;javascript:sendt(' . $row['id'] . ');">Submit</span>
</div>
</div>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
';
    
    
}
        $orders = [];
        $username = $user->username;
        $stmt = $this->db->prepare("SELECT * FROM purchases WHERE buyer=? ORDER BY id DESC");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $orderData = [
                'id'        => $row['id'],
                's_id'      => $row['s_id'],
                'buyer'     => $row['buyer'],
                'type'      => strtoupper($row['type']),
                'date'      => $row['date'],
                'country'   => $row['country'],
                'infos'     => $row['infos'],
                'url'       => $row['url'],
                'login'     => $row['login'],
                'pass'      => $row['pass'],
                'price'     => $row['price'],
                'resseller' => $row['resseller'],
                'reported'  => $row['reported'],
                'reportid'  => $row['reportid']
            ];
            $purchaseTime = strtotime($row['date']);
            $endTime = strtotime("+600 minutes", $purchaseTime);
            $orderData['timeRemaining'] = max(0, $endTime - time());
            $orders[] = $orderData;
        }
        return $orders;
    }

    private function getOrderDetails($orderId, $user) {
        if ($orderId <= 0) {
            return ["error" => "Invalid order ID."];
        }
        $username = $user->username;
        $stmt = $this->db->prepare("SELECT * FROM purchases WHERE buyer=? AND id=?");
        $stmt->bind_param('si', $username, $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result || $result->num_rows == 0) {
            return ["error" => "Order not found."];
        }
        $order = $result->fetch_assoc();
        $details = [
            'id'        => $order['id'],
            's_id'      => $order['s_id'],
            'buyer'     => $order['buyer'],
            'type'      => strtoupper($order['type']),
            'date'      => $order['date'],
            'country'   => $order['country'],
            'infos'     => $order['infos'],
            'url'       => $order['url'],
            'login'     => $order['login'],
            'pass'      => $order['pass'],
            'price'     => $order['price'],
            'resseller' => $order['resseller'],
            'reported'  => $order['reported'],
            'reportid'  => $order['reportid']
        ];
        if (strtolower($order['acctype']) === "huntingtonbank" || strtolower($order['acctype']) === "chasebank") {
            $tableName = strtolower($order['acctype']) === "huntingtonbank" ? "huntingtonbanks" : "chasebanks";
            $stmt = $this->db->prepare("SELECT * FROM $tableName WHERE id=?");
     

        }
        return $details;
    }

    public function submitReport($request) {
        $user = User::getAuthenticatedUser();
        if (!$user) {
            echo json_encode(["success" => false, "message" => "Unauthorized"]);
            exit();
        }


        }
    }

	function srl($item)
		{
		$item0 = $item;
		$item1 = rtrim($item0);
		$item2 = ltrim($item1);
		return $item2;
		} 
$usrid     = mysqli_real_escape_string($dbcon, $_SESSION['sname']);
$orderid     = mysqli_real_escape_string($dbcon, $_GET['id']);
$q = mysqli_query($dbcon, "SELECT * FROM purchases WHERE buyer='$usrid' and id='$orderid'") or die(mysql_error());

while ($row = mysqli_fetch_assoc($q)) {
	///////////////// Cpanel
 if ($row['type'] == "cpanel") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM cpanels WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {
$country = $rowe['country'];
$hosting = $rowe['infos'];
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

<h4>CPANEL</h4>
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

  		
</table>
<?php
}
	 }
	 //////////////End if cPanel
	 ?>
<?php
	///////////////// Shell
 if ($row['type'] == "shell") {
	 $itemid = $row['s_id'];
   echo "shell";
$qe = mysqli_query($dbcon, "SELECT * FROM stufs WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$country = $rowe['country'];
$information = $rowe['url'];
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
?>
<script type="text/javascript">
	   $('.copyit').tooltip({
	   	trigger: 'click',
	   	placement: 'left',
	   	animation:true});
</script>
<h4>SHELL</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

  <tr>
  <td>Shell</td>
  <td><b><a href='<?php echo htmlspecialchars($information); ?>' onclick='window.open(this.href);return false;'><?php echo htmlspecialchars($information); ?></a></b></td>
</tr>

  		
</table>



<?php
}
	 }
	 //////////////End if Shell
	 ?>
<?php
	///////////////// rdp
 if ($row['type'] == "rdp") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM rdps WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$country = $rowe['country'];
$access = $rowe['access'];
$windows = $rowe['windows'];
$ram = $rowe['ram'];
$state = $rowe['city'];
$hosting = $rowe['hosting'];
$information = $rowe['url'];
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
$information = $rowe['url'];
		$d = explode("|", $information);
		$url = srl($d[0]);
		$login = srl($d[1]);
		$pass = srl($d[2]);
?>

<script type="text/javascript">
	   $('.copyit').tooltip({
	   	trigger: 'click',
	   	placement: 'left',
	   	animation:true});
</script>
<h4>RDP</h4>
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

  		
</table>



<?php
}
	 }
	 //////////////End if rdp
	 ?>
	 
<?php
	///////////////// Mailer
 if ($row['type'] == "mailer") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM mailers WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$country = $rowe['country'];
$information = $rowe['url'];
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
?>

<h4>MAILER</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

  <tr>
  <td>Mailer</td>
  <td><b><a href='<?php echo htmlspecialchars($information); ?>' onclick='window.open(this.href);return false;'><?php echo htmlspecialchars($information); ?></a></b></td>
</tr>

  		
</table>
<?php
}
	 }
	 //////////////End if mailer
	 ?>
<?php
	///////////////// Smtp
 if ($row['type'] == "smtp") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM smtps WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {
$country = $rowe['country'];
$hosting = $rowe['infos'];
$information = $rowe['url'];
		$d = explode("|", $information);
		$url = srl($d[0]);
		$login = srl($d[1]);
		$pass = srl($d[2]);
		$port = srl($d[3]);
		$maindom = parse_url($url, PHP_URL_HOST);
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
?>

<h4>SMTP</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

  <tr>
  <td>HOST/IP</td>
  <td><b><input id='host/ip' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($url); ?>' /></b></td>
</tr>

  <tr>
  <td>Port</td>
  <td><b><?php echo htmlspecialchars($port); ?></b></td>
</tr>

  <tr>
  <td>User</td>
  <td><b><input id='user' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($login); ?>' /></b></td>
</tr>

  <tr>
  <td>Pass</td>
  <td><b><input id='pass' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($pass); ?>' /></b></td>
</tr>

  <tr>
  <td>Sender Email</td>
  <td><b><input id='senderemail' onClick='this.setSelectionRange(0, this.value.length)' value='<?php echo htmlspecialchars($login); ?>' /></b></td>
</tr>
	
</table>
<?php
}
	 }
	 //////////////End if Smtp
	 ?>
	  
<?php
	///////////////// Leads
 if ($row['type'] == "leads") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM leads WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$country = $rowe['country'];
$description = $rowe['infos'];
$number = $rowe['number'];
$information = $rowe['url'];
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
?>

<script type="text/javascript">
	   $('.copyit').tooltip({
	   	trigger: 'click',
	   	placement: 'left',
	   	animation:true});
</script>
<h4>LEADS</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

  <tr>
  <td>Number</td>
  <td><b><?php echo htmlspecialchars($number); ?></b></td>
</tr>

  <tr>
  <td>About</td>
  <td><b><?php echo htmlspecialchars($description); ?></b></td>
</tr>

  <tr>
  <td>Download</td>
  <td><b><a href='<?php echo htmlspecialchars($information); ?>' onclick='window.open(this.href);return false;'><?php echo htmlspecialchars($information); ?></a></b></td>
</tr>

  		
</table>



<?php
}
	 }
	 //////////////End if leads
	 ?>

<?php
	///////////////// premium
 if ($row['type'] == "account") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM accounts WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$country = $rowe['country'];
$site = $rowe['sitename'];
$description = $rowe['infos'];
$information = $rowe['url'];
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
?>

<h4>PREMIUM</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

  <tr>
  <td>Available Information</td>
  <td><b><?php echo htmlspecialchars($description); ?></b></td>
</tr>

  <tr>
  <td>Website</td>
  <td><b><a><?php echo htmlspecialchars($site); ?></a></b></td>
</tr>

  <tr>
  <td>Account Info</td>
  <td><b><textarea rows='10' cols='30' ><?php echo htmlspecialchars($information); ?></textarea></b></td>
</tr>

  		
</table>
<?php
}
	 }
	 //////////////End if premium
	 ?>

<?php
	///////////////// banks
 if ($row['type'] == "banks") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM banks WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$country = $rowe['country'];
$bankname = $rowe['bankname'];
$balance = $rowe['balance'];
$description = $rowe['infos'];
$information = $rowe['url'];
	 $code = array_search("$country", $countrycodes);
	 $countrycode = strtolower($code);
?>

<h4>BANKS</h4>
<table class="table">
<tr>
  <td>Country</td>
  <td><b><span class="flag-icon flag-icon-<?php echo htmlspecialchars($countrycode); ?>"></span> <?php echo htmlspecialchars($country); ?></b></td>
</tr>

  <tr>
  <td>Bank Name</td>
  <td><b><?php echo htmlspecialchars($bankname); ?></b></td>
</tr>

  <tr>
  <td>Available Information</td>
  <td><b><?php echo htmlspecialchars($description); ?></b></td>
</tr>

  <tr>
  <td>Balance</td>
  <td><b><a><?php echo htmlspecialchars($balance); ?></a></b></td>
</tr>

  <tr>
  <td>Account Info</td>
  <td><b><textarea rows='10' cols='30' ><?php echo htmlspecialchars($information); ?></textarea></b></td>
</tr>

  		
</table>
<?php
}
	 }
	 //////////////End if banks
	 ?>

<?php
	///////////////// scampage
 if ($row['type'] == "scampage") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM scampages WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$scamname = $rowe['scamname'];
$description = $rowe['infos'];
$information = $rowe['url'];

?>

<h4>SCAMPAGE</h4>
<table class="table">
<tr>
  <td>Name</td>
  <td><b><?php echo htmlspecialchars($scamname); ?></b></td>
</tr>

  <tr>
  <td>Information</td>
  <td><b><?php echo htmlspecialchars($description); ?></b></td>
</tr>

  <tr>
  <td>Download</td>
  <td><b><a href='<?php echo htmlspecialchars($information); ?>' onclick='window.open(this.href);return false;'><?php echo htmlspecialchars($information); ?></a></b></td>
</tr>

  		
</table>
<?php
}
	 }
	 //////////////End if scampage
	 ?>

<?php
	///////////////// tutorial
 if ($row['type'] == "tutorial") {
	 $itemid = $row['s_id'];
$qe = mysqli_query($dbcon, "SELECT * FROM tutorials WHERE id='$itemid'") or die(mysql_error());
while ($rowe = mysqli_fetch_assoc($qe)) {

$tutoname = $rowe['tutoname'];
$description = $rowe['infos'];
$information = $rowe['url'];

?>

<h4>TUTORIAL</h4>
<table class="table">
<tr>
  <td>Name</td>
  <td><b><?php echo htmlspecialchars($tutoname); ?></b></td>
</tr>

  <tr>
  <td>Information</td>
  <td><b><?php echo htmlspecialchars($description); ?></b></td>
</tr>

  <tr>
  <td>Download</td>
  <td><b><a href='<?php echo htmlspecialchars($information); ?>' onclick='window.open(this.href);return false;'><?php echo htmlspecialchars($information); ?></a></b></td>
</tr>

  		
</table>
<?php
}
	 }
	 //////////////End if tutorial
	 ?>
	 <?php
} 
?>