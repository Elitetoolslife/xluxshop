<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=EDGE" />
  <meta name="referrer" content="no-referrer" />
  <title>Orders - JeruxShop</title>
  
  <!-- CSS Dependencies -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5/bootstrap-4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="files/bootstrap/3/css/bootstrap.css?1" />
  <link rel="stylesheet" type="text/css" href="files/css/flags.css" />
  <link rel="shortcut icon" href="files/img/favicon.ico" />
  
  <!-- Custom Styles -->
  <style>
    body { padding-top: 70px; padding-bottom: 70px; }
    .navbar { background-color: #001f3f; }
    .label-as-badge { border-radius: 0.5em; }
    table th:not(.sorttable_sorted):not(.sorttable_sorted_reverse):not(.sorttable_nosort):after {
      content: " \25BE";
    }
    #mydiv { height: 400px; position: relative; }
    .ajax-loader {
      position: absolute;
      left: 0; top: 0; right: 0; bottom: 0;
      margin: auto;
    }
    @media (min-width: 768px) {
      .dropdown:hover .dropdown-menu { display: block; }
    }
  </style>
</head>
<body>

  <!-- Navigation Bar -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="navbar-brand" onclick="location.href='index.html'" style="cursor:pointer;">
          <b><span class="glyphicon glyphicon-fire"></span> Jerux SHOP <small><span class="glyphicon glyphicon-refresh"></span></small></b>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="topFixedNavbar1">
        <ul class="nav navbar-nav">
          <!-- Dropdowns and menu items (Hosts, Send, Leads, etc.) go here -->
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              Hosts <span class="glyphicon glyphicon-chevron-down" id="alhosts"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="rdp.html" onclick="pageDiv(1,'RDP - JeruxShop','rdp.html',0); return false;">
                  RDPs <span class="label label-primary label-as-badge" id="rdp"></span>
                </a>
              </li>
              <li>
                <a href="cPanel.html" onclick="pageDiv(2,'cPanel - JeruxShop','cPanel.html',0); return false;">
                  cPanels <span class="label label-primary label-as-badge" id="cpanel"></span>
                </a>
              </li>
              <li>
                <a href="shell.html" onclick="pageDiv(3,'Shell - JeruxShop','shell.html',0); return false;">
                  Shells <span class="label label-primary label-as-badge" id="shell"></span>
                </a>
              </li>
            </ul>
          </li>
          <!-- Additional dropdowns for Send, Leads, Accounts, Others, etc. -->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <?php
            // PHP block to check session data and display seller panel, tickets, etc.
            $uid = mysqli_real_escape_string($dbcon, $_SESSION['sname']);
            $q = mysqli_query($dbcon, "SELECT resseller FROM users WHERE username='$uid'") or die(mysqli_error());
            $r = mysqli_fetch_assoc($q);
            $reselerif = $r['resseller'];
            if ($reselerif == "1") {
                $uid = mysqli_real_escape_string($dbcon, $_SESSION['sname']);
                $q = mysqli_query($dbcon, "SELECT soldb FROM resseller WHERE username='$uid'") or die(mysqli_error());
                $r = mysqli_fetch_assoc($q);
                echo '<li><a href="https://jerux.to/seller/index.html">
                        <span class="badge" title="Seller Panel">
                          <span class="glyphicon glyphicon-cloud"></span>
                          <span id="seller"></span>
                        </span>
                      </a></li>';
            }
          ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              Tickets <span id="alltickets">
                <?php
                  $sze112 = mysqli_query($dbcon, "SELECT * FROM ticket WHERE uid='$uid' and seen='1'");
                  $r844941 = mysqli_num_rows($sze112);
                  if ($r844941 == "1") {
                      echo '<span class="label label-danger">1</span>';
                  }
                ?>
              </span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="tickets.html" onclick="pageDiv(11,'Tickets - JeruxShop','tickets.html',0); return false;">
                  Tickets <span class="label label-info"><span id="tickets"></span></span>
                  <?php
                    $s1 = mysqli_query($dbcon, "SELECT * FROM ticket WHERE uid='$uid' and seen='1'");
                    $r1 = mysqli_num_rows($s1);
                    if ($r1 == "1") {
                        echo '<span class="label label-success"> 1 New</span>';
                    }
                  ?>
                </a>
              </li>
              <li>
                <a href="reports.html" onclick="pageDiv(12,'Reports - JeruxShop','reports.html',0); return false;">
                  Reports <span class="label label-info"><span id="reports"></span></span>
                  <?php
                    $s1 = mysqli_query($dbcon, "SELECT * FROM reports WHERE uid='$uid' and seen='1'");
                    $r1 = mysqli_num_rows($s1);
                    if ($r1 == "1") {
                        echo '<span class="label label-success"> 1 New</span>';
                    }
                  ?>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="addBalance.html" onclick="pageDiv(13,'Add Balance - JeruxShop','addBalance.html',0); return false;">
              <span class="badge"><b><span id="balance"></span></b> <span class="glyphicon glyphicon-plus"></span></span>
            </a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              Account <span class="glyphicon glyphicon-user"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="setting.html" onclick="pageDiv(14,'Setting - JeruxShop','setting.html',0); return false;">Setting <span class="glyphicon glyphicon-cog pull-right"></span></a></li>
              <li><a href="orders.html" onclick="pageDiv(15,'Orders - JeruxShop','orders.html',0); return false;">My Orders <span class="glyphicon glyphicon-shopping-cart pull-right"></span></a></li>
              <li><a href="addBalance.html" onclick="pageDiv(13,'Add Balance - JeruxShop','addBalance.html',0); return false;">Add Balance <span class="glyphicon glyphicon-usd pull-right"></span></a></li>
              <li class="divider"></li>
              <li><a href="logout.html">Logout <span class="glyphicon glyphicon-off pull-right"></span></a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <!-- Main Content Area -->
  <div id="mainDiv">
    <div class="container">
      <h2 class="mb-4">Orders List</h2>
      <table class="table responsive table-striped table-hover" id="table">
        <thead class="thead-dark">
          <tr>
            <th>ID</th>
            <th>Type</th>
            <th>URL</th>
            <th>Price</th>
            <th>Seller</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $order)
            <tr>
              <td>{{ $order['id'] }}</td>
              <td>{{ $order['type'] }}</td>
              <td><a href="{{ $order['url'] }}" target="_blank">{{ $order['url'] }}</a></td>
              <td>${{ $order['price'] }}</td>
              <td>{{ $order['seller'] }}</td>
              <td>
                @if($order['reported'] == 1)
                  <span class="badge badge-danger">Reported</span>
                @elseif($order['status'] == "Time expired")
                  <span class="badge badge-warning">Expired</span>
                @else
                  <span class="badge badge-success">Active</span>
                @endif
              </td>
              <td>{{ $order['date'] }}</td>
              <td>
                <button class="btn btn-primary btn-sm open-modal" data-id="{{ $order['id'] }}">
                  View Details
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <!-- JavaScript Dependencies -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="files/js/jquery.js?1"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="files/bootstrap/3/js/bootstrap.js?1"></script>
  <script src="files/js/sorttable.js"></script>
  <script src="files/js/table-head.js?3334"></script>
  <script src="files/js/bootbox.min.js"></script>
  <script src="files/js/clipboard.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/js/script.js"></script>
  
  <!-- Custom JS Scripts -->
  <script>
    // Periodic AJAX call for updating info
    function ajaxinfo() {
      $.ajax({
        type: 'GET',
        url: 'ajaxinfo.html',
        timeout: 10000,
        success: function(data) {
          if(data != '01'){
            var data = JSON.parse(data);
            for(var prop in data){
              $("#" + prop).html(data[prop]).show();
            }
          } else {
            window.location = "logout.html";
          }
        }
      });
    }
    setInterval(ajaxinfo, 3000);
    ajaxinfo();

    // Keyboard control flag
    var cntrlIsPressed = false;
    $(document).keydown(function(event) {
      if(event.which == 17) cntrlIsPressed = true;
    });
    $(document).keyup(function() {
      cntrlIsPressed = false;
    });

    // Function to load page content via AJAX
    function pageDiv(n, t, u, x) {
      if(cntrlIsPressed){
        window.open(u, '_blank');
        return false;
      }
      var obj = { Title: t, Url: u };
      if( ("/" + obj.Url) != location.pathname ) {
        if(x != 1) {
          history.pushState(obj, obj.Title, obj.Url);
        } else {
          history.replaceState(obj, obj.Title, obj.Url);
        }
      }
      document.title = obj.Title;
      $("#mainDiv").html('<div id="mydiv"><img src="files/img/load2.gif" class="ajax-loader"></div>').show();
      $.ajax({
        type: 'GET',
        url: 'divPage' + n + '.html',
        success: function(data) {
          $("#mainDiv").html(data).show();
          var newTableObject = document.getElementById('table');
          sorttable.makeSortable(newTableObject);
          $(".sticky-header").floatThead({ top: 60 });
          if(x == 0) { ajaxinfo(); }
        }
      });
      if (typeof stopCheckBTC === 'function') { stopCheckBTC(); }
    }

    $(window).on("popstate", function(e) {
      location.replace(document.location);
    });

    $(window).on('load', function() {
      $('.dropdown').hover(function(){ $('.dropdown-toggle', this).trigger('click'); });
      pageDiv(15, 'Orders - JeruxShop', 'orders.html', 1);
      var clipboard = new Clipboard('.copyit');
      clipboard.on('success', function(e) {
        setTooltip(e.trigger, 'Copied!');
        hideTooltip(e.trigger);
        e.clearSelection();
      });
    });

    function setTooltip(btn, message) {
      $(btn).tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
    }

    function hideTooltip(btn) {
      setTimeout(function() {
        $(btn).tooltip('hide');
      }, 1000);
    }

    // Order Details Modal
    $(document).ready(function () {
      $(".open-modal").click(function () {
        var orderId = $(this).data("id");

        Swal.fire({
          title: 'Please wait...',
          html: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
          timer: 10000,
          allowOutsideClick: false,
          didOpen: () => { Swal.showLoading(); }
        }).then((result) => {
          $.ajax({
            url: "/get-order-details",
            method: "POST",
            data: { id: orderId },
            success: function(response) {
              Swal.fire({
                title: 'Order Details',
                html: response + 
                      '<hr>' +
                      '<form id="reportForm">' +
                        '<div class="form-group">' +
                          '<label for="reportReason">Report Reason:</label>' +
                          '<textarea id="reportReason" class="form-control" rows="3" placeholder="Enter reason..."></textarea>' +
                        '</div>' +
                        '<button type="button" id="submitReport" class="btn btn-primary">Submit Report</button>' +
                      '</form>',
                showConfirmButton: false
              });

              $(document).on('click', '#submitReport', function() {
                var reason = $('#reportReason').val();
                Swal.fire('Report submitted!', '', 'success');
              });
            },
            error: function() {
              Swal.fire('Error', 'Error loading data.', 'error');
            }
          });
        });
      });
    });
  </script>
</body>
</html>