<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head />
    <title>Add Ingredient</title>
</head>

<body>
    <x-navbar active-page='ingredient' />
    <main>
        <div class="container-fluid p-3">
            @if ($alert)
                <div class="alert alert-{{ $alert['type'] }} alert-dismissible fade show justify-content-between m-3 align-items-center d-flex"
                    role="alert">
                    {{ $alert['message'] }}
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            <form action="{{ route('ingredients.add_ingredient') }}" method="POST">
                @csrf
                <div class="d-flex flex-column justify-content-center">
                    <div class="mb-3">
                        <label for="name" class="form-label">Ingredient name: </label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name')
                        form-invalid
                    @enderror required"
                            required value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit: </label>
                        <input type="text" name="unit" id="unit"
                            class="form-control @error('unit')
                        form-invalid
                    @enderror required"
                            required value="{{ old('unit') }}">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price: </label>
                        <input type="number" name="price" id="price"
                            class="form-control @error('price')
                        form-invalid
                    @enderror required"
                            required value="{{ old('price') }}">
                    </div>
                    <label for="" class="mb-3">Nutritions: </label>
                    <div class="card mb-3">
                        <div class="card-body p-3">
                            @foreach ($nutritions as $key => $nutrition)
                                <div class="row mb-3 align-items-center" id={{ $key }}>
                                    <div class="col">
                                        <p class="">{{ $nutrition['name'] }}</p>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" name={{ $nutrition['id'] }}
                                            id={{ $nutrition['id'] }} placeholder="Amount (Per gram)">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div></div>
                        <button class="btn btn-primary" type="submit">
                            Add ingredient
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
