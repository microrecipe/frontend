<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head />
    <title>Add Recipe</title>
</head>

<body>
    <x-navbar :access-token="$accessToken" :refresh-token="$refreshToken" active-page='recipe' :cart-items-count="$cartItemsCount" />
    <div class="container-fluid p-3">
        @if ($noIngredientSelected)
            <div class="alert alert-danger" role="alert">
                One or more ingredient is required.
            </div>
        @endif
        <form action={{ route('recipes.add_recipe') }} method="POST">
            @csrf
            <div class="d-flex flex-column justify-content-center">
                <div class="mb-3">
                    <label for="name" class="form-label">Recipe name</label>
                    <input type="text" name="name" id="recipe-name" class="form-control required" required>
                </div>
                <label for="">Ingredients</label>
                <div class="card mb-3">
                    <div class="card-body p-3">
                        @foreach ($ingredients as $ingredient)
                            <div class="row mb-3 d-flex align-items-center" id={{ $ingredient['id'] }}>
                                <div class="col">
                                    <p class="text-end">{{ $ingredient['name'] }}</p>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name={{ $ingredient['id'] }}
                                        id={{ $ingredient['id'] }} placeholder="Quantity" value="0">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div></div>
                    <button class="btn btn-primary" type="submit">
                        Add recipe
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

</html>
