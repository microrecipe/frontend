<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head />

    <title>Recipes</title>
</head>

<body>
    <x-navbar :is-logged-in="$isLoggedIn" active-page="recipe" />
    <div class="container-fluid">
        @if (count($recipes) > 0)
            <div class="row align-items-center d-flex justify-content-center mx-3">
                @foreach ($recipes as $recipe)
                    <div class="card w-100 my-3 shadow" id={{ $recipe['id'] }}>
                        <div class="card-body">
                            <p class="card-text d-block">Name: {{ $recipe['name'] }}</p>
                            <div class="d-flex flex-row justify-content-center">
                                <p class="mr-3">Ingredients:</p>
                                <ul class="list-group w-100">
                                    @foreach ($recipe['ingredients'] as $ingredient)
                                        <li class="list-group-item position-relative" id={{ $ingredient['id'] }}>
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <p class="m-0">{{ $ingredient['name'] }}</p>
                                                <div class="d-flex flex-column justify-content-end">
                                                    <p class="m-0">Quantity: {{ $ingredient['quantity'] }}
                                                        {{ $ingredient['unit'] }}
                                                    </p>
                                                    <p class="m-0">Price per unit: Rp.{{ $ingredient['price'] }}</p>
                                                </div>
                                            </div>
                                            {{-- <a href="" class="stretched-link invinsible"></a> --}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button class="btn btn-success w-100 mt-2 ml-auto">
                                Add ingredients to cart
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row justify-content-center">
                <h1 class="text-center">
                    Recipes list is empty
                </h1>
            </div>
        @endif
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

</html>
