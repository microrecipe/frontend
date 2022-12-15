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
    <x-navbar :cart-items-count="$cartItemsCount" />
    <main>
        <div class="{{ count($cartItems) > 0 ? 'container-fluid p-3' : 'container p-3 vh-100' }}">
            @if (!is_null($deleteItemAlert))
                @if ($deleteItemAlert === 'success')
                    <div class="row w-100">
                        <div class="col">
                            <div class="alert alert-success fade show d-flex justify-content-between m-3 align-items-center"
                                role="alert">
                                Items removed from cart.
                                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close">
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            @if (count($cartItems) > 0)
                <div class="container-fluid p-3">
                    <div class="d-flex row justify-content-between align-items-start p-3">
                        @foreach ($cartItems as $key => $item)
                            <div class="col-md-8 col-12 card w-50 mb-3" id={{ $key }}>
                                <div class="card-body d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <h5 class="cart-title">
                                            {{ $item['ingredient']['name'] }}
                                        </h5>
                                        <p class="card-text">Price: Rp.{{ $item['price'] }}</p>
                                        <p class="card-text">Quantity: {{ $item['quantity'] }}</p>
                                    </div>

                                    <form action={{ route('orders.delete.cart_item', ['itemId' => $item['id']]) }}
                                        method="POST">
                                        @csrf
                                        <button class="btn btn-outline-danger" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                            </svg>
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if ($key < 1)
                                <div class="col-md-4 col-12 mb-3 align-top align-items-center">
                                    <h3 class="mb-3">Total price</h3>
                                    <h4 class="mb-3">Rp.{{ $totalPrice }}</h4>
                                    <a href={{ route('orders.view.cart.checkout') }}
                                        class="btn btn-success w-100">Buy</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="row h-100 w-100">
                    <div class="col align-self-center text-center">
                        <h1>You don't have anything in your cart</h1>
                    </div>
                </div>
            @endif
        </div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
