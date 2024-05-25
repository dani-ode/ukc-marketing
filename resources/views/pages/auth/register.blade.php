@extends('layouts.app', ['class' => ''])

@section('content')
    <main class="signup-form p-3">
        <div class="cotainer mt-5">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Formulir pendaftaran</h3>
                        <div class="card-body">

                            <form action="{{ route('register.custom') }}" method="POST" id="inputUserForm">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Nama" id="nama" class="form-control"
                                        name="nama" required autofocus>
                                    @if ($errors->has('nama'))
                                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email_address" class="form-control"
                                        name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group mb-3">

                                    <div class="row m-0 p-0" style="width:100%;">
                                        <div class="col m-0 p-0">
                                            <input type="password" placeholder="Password" id="password"
                                                class="form-control" name="password" required>
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-1">
                                            <i class="bi bi-eye-slash-fill" id="togglePassword"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    @php
                                        $resorts = [1, 2, 3, 4, 5, 6];
                                    @endphp
                                    <select class="form-select" aria-label="Default select example" name="resort">
                                        @foreach ($resorts as $rst)
                                            <option value="{{ $rst }}" {{ $rst == 1 ? 'selected' : '' }}>
                                                Resort {{ $rst }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group mb-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="remember"> Remember Me</label>
                                    </div>
                                </div>



                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-success btn-block">Sign up</button>
                                </div>
                            </form>
                            <br>
                            <div class="text-center">
                                <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}">Login</a></small>
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
