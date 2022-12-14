<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <x-head />

    <title>Cart</title>
</head>

<body>
    <header>
        <x-navbar :access-token="$accessToken" :refresh-token="$refreshToken" :cart-items-count="$cartItemsCount" />
    </header>
    <main>
        <div class="container-fluid p-3">
            <div class="d-flex row justify-content-between align-items-start p-3">
                @foreach ($cartItems as $key => $item)
                    <div class="col-md-8 col-12 card w-50 mb-3" id={{ $key }}>
                        <div class="card-body">
                            <h5 class="cart-title">
                                {{ $item['ingredient']['name'] }}
                            </h5>
                            <p class="card-text">Price: Rp.{{ $item['price'] }}</p>
                            <p class="card-text">Quantity: {{ $item['quantity'] }}</p>
                        </div>
                    </div>
                    @if ($key < 1)
                        <div class="col-md-4 col-12 mb-3 align-top align-items-center">
                            <h3 class="mb-3">Total price</h3>
                            <h4 class="mb-3">Rp.{{ $totalPrice }}</h4>
                            <a href={{ route('orders.view.cart.checkout') }} class="btn btn-success w-100">Buy</a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>