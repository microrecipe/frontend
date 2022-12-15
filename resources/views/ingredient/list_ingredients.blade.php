<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head />
    <title>Ingredients</title>
</head>

<body>
    <x-navbar active-page="ingredient" />

    <main>
        <div class="container-fluid p-3">
            @if ($alert)
                <div class="alert alert-{{ $alert['type'] }} fade show d-flex justify-content-between m-3 align-items-center"
                    role="alert">
                    {{ $alert['message'] }}
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            @if (session()->get('is_admin'))
                <div class="d-flex justify-content-between m-3">
                    <div class=""></div>
                    <a href="{{ route('ingredients.view.add_ingredient') }}"
                        class="btn btn-outline-primary align-items-center text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                        </svg>
                        Add ingredient
                    </a>
                </div>
            @endif
            @if (count($ingredients) > 0)
                <div class="row align-items-center d-flex justify-content-center mx-3">
                    @foreach ($ingredients as $key => $ingredient)
                        <div class="col-12 card w-100 my-3 shadow" id="{{ $key }}">
                            <div class="card-body d-flex flex-column justify-content-center">
                                <div class="d-flex justify-content-between mb-3">
                                    <h3 class="card-text">{{ $ingredient['name'] }}</h3>
                                    @if (session()->get('is_admin'))
                                        <div class="d-flex flex-row">
                                            <form action="" method="POST" class="me-3">
                                                @csrf
                                                <button class="btn btn-outline-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-pencil-square"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd"
                                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('ingredients.delete_ingredient', ['ingredientId' => $ingredient['id']]) }}"
                                                method="POST">
                                                @csrf
                                                <button class="btn btn-outline-danger" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-trash3"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                </div>
                                <p class="card-text mb-3">Unit: {{ $ingredient['unit'] }}</p>
                                <p class="card-text mb-3">Price per unit: Rp.{{ $ingredient['price'] }}</p>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p class="card-title fw-bold">Nutrition facts: </p>
                                        <ul class="list-group">
                                            @foreach ($ingredient['nutritions'] as $key => $nutrition)
                                                <li class="list-group-item d-flex flex-row justify-content-between align-items-center text-bg-light p-3"
                                                    id="{{ $key }}">
                                                    <p class="m-0">{{ $nutrition['name'] }}</p>
                                                    <p class="m-0">Amount per gram: {{ $nutrition['per_gram'] }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row justify-content-center">
                    <h1 class="text-center">
                        Ingredients list is empty
                    </h1>
                </div>
            @endif
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
