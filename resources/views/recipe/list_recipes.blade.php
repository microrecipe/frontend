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
    <div class="container-fluid p-3">
        @if (!is_null($isLoggedIn))
            <div class="d-flex justify-content-between mx-3">
                <div class=""></div>
                <a href={{ route('recipes.view.add_recipe') }} class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path
                            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                    </svg>
                    Add recipe
                </a>
            </div>
        @endif
        @if (count($recipes) > 0)
            <div class="row align-items-center d-flex justify-content-center mx-3">
                @foreach ($recipes as $key => $recipe)
                    <div class="card w-100 my-3 shadow" id={{ $recipe['id'] }}>
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3 class="card-text d-block">{{ $recipe['name'] }}</h3>
                            <div class="d-flex flex-row justify-content-center">
                                <ul class="list-group w-100 accordion accordion-flush">
                                    @foreach ($recipe['ingredients'] as $key2 => $ingredient)
                                        <li class="list-group-item position-relative accordion-item"
                                            id="{{ $key }}-{{ $key2 }}">
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <a href="#" class="m-0 accordion-button stretched-link"
                                                    role="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $key }}-{{ $key2 }}"
                                                    aria-controls="collapseOne">
                                                    {{ $ingredient['name'] }}</a>
                                                <div class="d-flex flex-column justify-content-end">
                                                    <p class="m-0">Quantity: {{ $ingredient['quantity'] }}
                                                        {{ $ingredient['unit'] }}
                                                    </p>
                                                    <p class="m-0">Price per unit: Rp.{{ $ingredient['price'] }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <div id="collapse-{{ $key }}-{{ $key2 }}"
                                            class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="card d-flex flex-row justify-content-between p-3">
                                                    <p class="mr-5">Nutrition facts:</p>
                                                    <ul class="list-group w-50">
                                                        @foreach ($ingredient['nutritions'] as $nutrition)
                                                            <li class="list-group-item">
                                                                <div class="d-flex justify-content-between">
                                                                    <p>{{ $nutrition['name'] }}:</p>
                                                                    <p>{{ $nutrition['per_gram'] }} per gram</p>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                            @if (!is_null($isLoggedIn))
                                <button class="btn btn-success w-50 mt-3 mx-auto">
                                    Add ingredients to cart
                                </button>
                            @endif
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
