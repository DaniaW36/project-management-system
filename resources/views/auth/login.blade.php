<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/soft-ui-dashboard.css?v=1.1.0') }}" rel="stylesheet">
</head>
<body class="g-sidenav-show bg-gray-100">

    <div class="container mt-5">
    <div class="row g-0 justify-content-center">
    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
      <div class="card card-plain mt-8">
        <div class="card-header pb-0 text-left bg-transparent">
          <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
          <p class="mb-0">Enter your email and password to sign in</p>
        </div>

        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Email</label>
            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>

            <label>Password</label>
            <div class="mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>

            <div class="text-center">
              <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
            </div>
          </form>
        </div>

        <div class="card-footer text-center pt-0 px-lg-2 px-1">
          <p class="mb-4 text-sm mx-auto">
            Don’t have an account? Please contact admin.
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-6 d-none d-md-block position-relative overflow-hidden">
        <div class="oblique position-absolute top-0 end-0 h-100 w-100">
          <div class="oblique-image bg-cover h-100 w-100"
               style="background-image:url('{{ asset('img/favicon.png') }}')"></div>
        </div>
      </div>
    </div>
</div>

</body>
</html>
