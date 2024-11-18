<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="{{URL::asset('water_icon.png')}}" type="image/png">
    <link href="{{ URL::asset('/css/css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('/css/style.css')}}">
    <link rel="stylesheet" href="style.css">

</head>
<body class="bg-primary">
<div class="container-fluid rounded-0">
    <div class="row my-4 py-5 d-flex justify-content-center align-items-center">
        <!-- Card with Login Form and Image -->
        <div class="card shadow-5-strong" style="max-width: 500px; width: 100%;">
            <div class="row g-0">
                <!-- Login Form -->
                <div class="col-md-12 d-flex align-items-center justify-content-center p-4 rounded-0">
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Logo -->
                        <div class="d-flex align-items-center mb-4">
                            <h2 class="logo text-strong">PDAM</h2> 
                        </div>

                        <h3 class="fw-normal mb-4" style="letter-spacing: 1px;">Log in</h3>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="form-outline mb-4">
                                <input type="name" id="name" name="name" class="form-control form-control-lg rounded-0"
                                    required />
                                <label class="form-label" for="name">Nama User</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg rounded-0" required />
                                <label class="form-label" for="password">Password</label>
                            </div>

                            <div class="mb-4">
                                <button class="btn btn-primary btn-lg w-100 rounded-0" type="submit">Login</button>
                            </div>

                            <p class="small text-center mb-4"><a class="text-muted" href="#!">Forgot password?</a></p>
                            <p class="text-center">Tidak Punya Akun? <a href="{{ route('register') }}"
                                    class="link-info">Daftar di Sini</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>