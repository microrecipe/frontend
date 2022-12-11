<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <title>Orders</title>
</head>

<body>
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
</body>

</html>