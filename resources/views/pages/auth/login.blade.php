@extends('layouts.app', ['class' => ''])

@section('content')
    <main class="login-form p-3">
        <div class="cotainer mt-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Masuk Ke Akun</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('login.custom') }}" id="inputUserForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control"
                                        name="email" required autofocus>
                                </div>

                                <div class="form-group mb-3">

                                    <div class="row m-0 p-0" style="width:100%;">
                                        <div class="col m-0 p-0">
                                            <input type="password" placeholder="Password" id="password"
                                                class="form-control" name="password" required>
                                            @if ($errors->has('emailPassword'))
                                                <span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-1">
                                            <i class="bi bi-eye-slash-fill" id="togglePassword"></i>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-success btn-block">Login</button>
                                </div>
                            </form>

                            <br>
                            <div class="text-center">
                                <small class="text-muted">Belum Mendaftar? <a
                                        href="{{ route('register-user') }}">Daftar</a></small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const password = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        togglePassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            // toggle the icon
            this.classList.toggle("bi-eye-slash-fill");
            this.classList.toggle("bi-eye-fill");
        });


        document.getElementById("inputUserForm").onsubmit = function onSubmit(form) {
            showClasicLoading();
        }
    </script>
@endsection
