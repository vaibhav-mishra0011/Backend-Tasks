<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Login User</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4 class="mt-4">Login</h4>
                <hr>
                <form method="post" action="login">
                    @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('fail'))
                    <div class="alert alert-danger">{{Session::get('fail')}}</div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="email"> Email </label>
                        <input type="email" class="form-control" placeholder="Enter Your Email address" name="email"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="password"> Password </label>
                        <input type="password" class="form-control" placeholder="Enter Your password" name="password"
                            value="">
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-block btn-primary" type="submit">Login</button>
                    </div>
                    <div class="form-group mt-3">
                        <h5 class="mx-3">New User Register here <a href="/register">Register here</a></h5>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

</html>