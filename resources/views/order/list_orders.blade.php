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
    <header>
        <x-navbar :access-token="$accessToken" :refresh-token="$refreshToken" />
    </header>
    <main>
        <div class="container">
            @if (count($orders) > 0)
                <div class="row align-items-center d-flex justify-content-center">
                    @foreach ($orders as $order)
                        <div class="card w-100 my-3 shadow" id={{ $order['id'] }}>
                            <div class="card-body">
                                <p class="card-text">id: {{ $order['id'] }}</p>
                                <p class="card-text">Total price: {{ $order['total_price'] }}</p>
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
