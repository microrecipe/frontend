<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <x-head />
    <title>Checkout</title>
</head>

<body>
    <x-navbar :cart-items-count="$cartItemsCount" />
    <main>
        <div class="container-fluid p-3">
            <form action={{ route('orders.cart.place-order') }} method="POST">
                @csrf
                <div class="row w-75 mx-auto">
                    <div class="col-12 col-md-8">
                        <div class="form-floating mb-3">
                            <input type="text"
                                class="form-control @error('address')
                                is-invalid
                            @enderror"
                                id="address" name="address" placeholder="Address" value="{{ old('address') }}">
                            <label for="floatingInput">Address</label>
                            @error('address')
                                <div class="invalid-feedback">
                                    Address is required.
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select
                                class="form-select @error('deliveryCourier')
                                is-invalid
                            @enderror"
                                id="deliveryCourier" aria-label="deliveryCourier" name="deliveryCourier">
                                <option class="text-muted" disabled
                                    {{ is_null(old('deliveryCourier')) ? 'selected' : '' }}>--Select delivery courier--
                                </option>
                                @foreach ($deliveryCouriers as $courier)
                                    <option value={{ $courier['id'] }}
                                        {{ is_null(old('deliveryCourier')) ? (old('deliveryCourier') === $courier['id'] ? 'selected' : '') : '' }}>
                                        {{ $courier['name'] }}
                                        (Rp.{{ $courier['shipping_cost'] }})
                                    </option>
                                @endforeach
                            </select>
                            <label for="deliveryCourier">Delivery courier</label>
                            @error('deliveryCourier')
                                <div class="invalid-feedback">
                                    Please choose one delivery courier.
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select
                                class="form-select @error('paymentMethod')
                                is-invalid
                            @enderror"
                                id="paymentMethod" aria-label="paymentMethod" name="paymentMethod">
                                <option class="text-muted" disabled
                                    {{ is_null(old('deliveryCourier')) ? 'selected' : '' }}>--Select payment method--
                                </option>
                                @foreach ($paymentMethods as $pm)
                                    <option value={{ $pm['id'] }}
                                        {{ is_null(old('paymentMethod')) ? (old('paymentMethod') === $pm['id'] ? 'selected' : '') : '' }}>
                                        {{ $pm['name'] }}</option>
                                @endforeach
                            </select>
                            <label for="paymentMethod">Payment method</label>
                            @error('paymentMethod')
                                <div class="invalid-feedback">
                                    Please choose one payment method.
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="col-12 col-md-4">
                        <h4 class="mb-3">Transaction detail</h4>
                        <hr>
                        <h5 class="mb-3">Total price Rp. 50000</h5>
                    </div>
                </div>
                <div class="row w-75 mx-auto">
                    <div class="col-12">
                        <button class="btn btn-success btn-lg w-100" type="submit">
                            Place order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
