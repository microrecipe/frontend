<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a class="navbar-brand" href="#">Microrecipe</a>

        <div class="collapse navbar-collapse align-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    @if ($isLoggedIn)
                        <a href={{ route('auth.signout') }} class="btn btn-outline-danger">Logout</a>
                    @else
                        <a href={{ route('auth.signin') }} class="btn btn-primary">Sign In</a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>

</body>

</html>
