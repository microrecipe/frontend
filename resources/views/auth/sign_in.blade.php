<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <x-head />

    <title>Login Form</title>
</head>

<body>
    <main>
        <div class="container p-5 vh-100">
            <div class="row h-100 w-50 mx-auto">
                <div class="col align-self-center">
                    @if ($loginError)
                        <div class="alert alert-danger">
                            Error: {{ $loginError }}
                        </div>
                    @endif
                    <form class="form-signin" method="POST" action={{ route('auth.signin') }}>
                        @csrf
                        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                        <div class="form-floating mb-5">
                            <input type="email" id="inputEmail" name="email"
                                class="form-control @error('email')
                            is-invalid
                            @enderror"
                                placeholder="Email address" required autofocus>
                            <label for="inputEmail" class="sr-only">Email address</label>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-floating mb-5">
                            <input type="password" id="inputPassword" name="password"
                                class="form-control @error('password')
                            is-invalid
                            @enderror"
                                placeholder="Password" required>
                            <label for="inputPassword" class="sr-only">Password</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg w-100 btn-primary btn-block" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </main>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

</html>
