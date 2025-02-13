@extends('layouts.buyer')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Huntington Bank Listings</h2>
    
    <h4>Welcome, <span class="text-primary">{{ $username }}</span></h4>
    <p>Your Balance: <span id="user_balance_display" class="text-success">${{ number_format($balance, 2) }}</span></p>

    <input type="hidden" id="csrf_token" value="{{ $csrf_token }}">
    <input type="hidden" id="user_balance" value="{{ $balance }}">

    <!-- Filter Options -->
    <div class="row mb-4">
        <div class="col-md-6">
            <select id="filterCountry" class="form-select">
                <option value="">Filter by Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country }}">{{ $country }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <select id="filterSeller" class="form-select">
                <option value="">Filter by Seller</option>
                @foreach($sellers as $seller)
                    <option value="{{ $seller }}">{{ $seller }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Huntington Banks Listings -->
    <div class="row">
        @foreach($huntingtonbanks as $bank)
        <div class="col-md-4 bank-item" data-country="{{ $bank['country'] }}" data-seller="{{ $bank['resseller'] }}">
            <div class="card p-3">
                <h5 class="card-title">{{ $bank['acctype'] }}</h5>
                <p><strong>Country:</strong> {{ $bank['country'] }}</p>
                <p><strong>Seller:</strong> {{ $bank['resseller'] }}</p>
                <p><strong>Price:</strong> ${{ number_format($bank['price'], 2) }}</p>
                <button class="btn btn-buy w-100" onclick="confirmPurchase({{ $bank['id'] }}, {{ $bank['price'] }})">Buy Now</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
function confirmPurchase(bankId, price) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to buy this bank account for $" + price.toFixed(2),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, buy it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/buyHuntingtonbank',
                method: 'POST',
                data: {
                    _token: document.getElementById('csrf_token').value,
                    id: bankId,
                    price: price
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Purchased!', 'Your purchase has been completed.', 'success');
                        // Update the user's balance display
                        var newBalance = parseFloat(document.getElementById('user_balance').value) - price;
                        document.getElementById('user_balance').value = newBalance.toFixed(2);
                        document.getElementById('user_balance_display').innerText = '$' + newBalance.toFixed(2);
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'There was an error processing your purchase.', 'error');
                }
            });
        }
    });
}
</script>
@endsection