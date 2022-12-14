<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head />

    <title>Orders</title>
</head>

<body>
    <x-navbar :access-token="$accessToken" :refresh-token="$refreshToken" :cart-items-count="$cartItemsCount" />
    <main>
        <div class="container-fluid p-3">
            <div class="row">
                <h1>Transaction History</h1>
            </div>
            @if (count($orders) > 0)
                <div class="row align-items-center d-flex justify-content-center">
                    @foreach ($orders as $order)
                        <div class="col col-12">
                            <div class="card w-100 my-3 shadow" id={{ $order['id'] }}>
                                <div class="card-body">
                                    <p class="card-text">
                                        {{ is_null($order['placed_at']) ? '' : \Carbon\Carbon::parse($order['placed_at'])->toDayDateTimeString() }}
                                    </p>
                                    <p class="card-text">Items:
                                    <ul class="list-group align-middle">
                                        @if (count($order['items']) > 0)
                                            @foreach ($order['items'] as $item)
                                                <li class="list-group-item">
                                                    <p>Item name: {{ $item['ingredient']['name'] }}</p>
                                                    <p>Price: Rp.{{ $item['price'] }} x {{ $item['quantity'] }}</p>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    </p>
                                    <p class="card-text">Order status:
                                        <span
                                            class="rounded-pill {{ is_null($order['status']) ? '' : ($order['status'] === 'finished' ? 'text-bg-success' : 'text-bg-primary') }} py-0 px-2">{{ is_null($order['status']) ? '' : ucfirst($order['status']) }}</span>
                                    </p>
                                    <p class="card-text">Total price: Rp.{{ $order['total_price'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row justify-content-center">
                    <h1 class="text-center">
                        You don't have any orders
                    </h1>
                </div>
            @endif
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

</html>
