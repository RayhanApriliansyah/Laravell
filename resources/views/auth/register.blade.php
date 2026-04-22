<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }} " />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <title>Register | SBM Website</title>
</head>

<body>
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>

    <div id="main-wrapper" class="auth-customizer-none">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <img src="{{ asset('assets/images/logos/SBM1.png') }}" alt="SBM" width="100" class="position-absolute top-0 start-0 m-4">
                        <div class="d-none d-xl-flex align-items-center justify-content-center h-n80">
                            <img src="{{ asset('assets/images/backgrounds/login-security.svg') }}" alt="register-img" class="img-fluid" width="500">
                        </div>
                    </div>

                    <div class="col-xl-5 col-xxl-4">
                        <div class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                            <div class="auth-max-width col-sm-8 col-md-6 col-xl-7 px-4">
                                <h2 class="mb-1 fs-7 fw-bolder">Create Your Account</h2>
                                <p class="mb-7">Please fill in the details to register</p>

                                <form method="POST" action="{{ route('registerproses') }}">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control from-control-user" placeholder="Enter your name" name="name" value="{{ old('name') }}">
                                        @error('name')
                                        <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control from-control-user" placeholder="Enter your email" name="email" value="{{ old('email') }}">
                                        @error('email')
                                        <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control from-control-user" placeholder="Enter password" name="password">
                                        @error('password')
                                        <div class="text-danger mt-2 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control from-control-user" placeholder="Confirm your password" name="password_confirmation">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Register</button>

                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-medium">Already have an account?</p>
                                        <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Customizer -->
        <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
        </script>
    </div>

    <div class="dark-transparent sidebartoggler"></div>

    <!-- JS Files -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

    <!-- SweetAlert -->
    @session('success')
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success"
        });
    </script>
    @endsession
    @session('error')
    <script>
        Swal.fire({
            title: "Gagal!",
            text: "{{ session('error') }}",
            icon: "error"
        });
    </script>
    @endsession
</body>

</html>