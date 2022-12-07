<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .form-signup {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signup .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }

        .form-signup .form-control:focus {
            z-index: 2;
        }
    </style>
</head>

<body>
    <form class="form-signup" method="POST" action="{{ route('home') }}">
        <h1 class="h3 mb-3 font-weight-normal">Create a new account</h1>
        <label for="inputName" class="sr-only">Name</label>
        <input type="text" id="inputName" class="form-control mb-3" placeholder="Name" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control mb-3" placeholder="Email address" required>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control mb-3" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Create Account</button>
    </form>
</body>

</html>
