//huntington/index.php
//huntington/divPage1.php
//huntington/buy.php
Fix blade full

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
convert to bladeOne js  
<script>
function sendt(id) {
    var msg = $("#msg" + id).val();
    $.ajax({
        method: "GET",
        url: "CreateReport?id=" + id + "&m=" + btoa(msg),
        dataType: "text",
        success: function(data) {
            $("#resulta" + id).html(data).show();
        },
    });
}
convert to bladeOne js  
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


    </div>

</body>
</html>