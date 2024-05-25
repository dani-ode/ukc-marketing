@extends('layouts.app', ['class' => ''])

@section('content')
    @include('layouts.navbar.nav2', ['title' => $user->nama])
    <div class="container">
        <div class="card mb-4">
            <form action="/user/{{ $user->id }}" method="POST" enctype="multipart/form-data" id="inputUserForm">

                @csrf

                <div class="card-body">


                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Nama" name="nama"
                                aria-label="Username" aria-describedby="addon-wrapping" value="{{ $user->nama }}">
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Nomor HP" name="no_hp"
                                aria-label="Alamat" aria-describedby="addon-wrapping" value="{{ $user->no_hp }}">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Nomor HP" name="email"
                                aria-label="Alamat" aria-describedby="addon-wrapping" value="{{ $user->email }}">
                        </div>
                    </div>

                    @role('admin')
                        <div class="input-group mb-3">
                            <div class="row m-0 p-0" style="width:100%;">
                                <div class="col m-0 p-0">
                                    @php
                                        $resorts = [0, 1, 2, 3, 4, 5, 6];
                                    @endphp
                                    <select class="form-select" aria-label="Default select example" name="resort"
                                        {{ $user->resort == $user->resort ? '' : 'disabled' }}>
                                        @foreach ($resorts as $rst)
                                            <option value="{{ $rst }}" {{ $rst == $user->resort ? 'selected' : '' }}>
                                                Resort {{ $rst }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-1 m-0 p-0"></div>
                                <div class="col m-0 p-0">
                                    @php
                                        $status = ['aktif', 'tidak aktif'];
                                    @endphp
                                    <select class="form-select" aria-label="Default select example" name="status"
                                        {{ $user->resort == $user->resort ? '' : 'disabled' }}>
                                        @foreach ($status as $st)
                                            <option value="{{ $st }}" {{ $st == $user->status ? 'selected' : '' }}>
                                                {{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endrole

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Ubah Password ?
                        </label>
                    </div>

                    <div class="input-group mb-3 d-none" id="inputPassword">
                        <div class="input-group flex-nowrap">
                            <div class="row m-0 p-0" style="width:100%;">
                                <div class="col m-0 p-0">
                                    <input id="password" type="password" class="form-control" placeholder="Password"
                                        name="password" aria-label="Alamat" aria-describedby="addon-wrapping">
                                </div>
                                <div class="col-1">
                                    <i class="bi bi-eye-slash-fill" id="togglePassword"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="p-3">
                        <button type="submit" class="btn btn-success"><i class="bi bi-floppy2"></i> Simpan</button>
                    </div>
            </form>

            @role('admin')
                @if (Auth::user()->id != $user->id)
                    <form action="/user/{{ $user->id }}" method="POST" id="deleteUserForm">

                        @csrf

                        <input type="hidden" name="destroy" value="true">

                        <div class="p-3">
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Apakah Anda yakin menghapus Karyawan ini?')"><i
                                    class="bi bi-trash-fill"></i>
                                Hapus</button>
                        </div>
                    </form>
                @endif
            @endrole
        </div>
    </div>

    <script>
        const inputPassword = document.getElementById("inputPassword");
        const password = document.getElementById("password");

        document.getElementById("flexCheckDefault").onclick = function() {
            if (this.checked) {
                inputPassword.classList.remove("d-none");
            } else {

                password.value = '';
                inputPassword.classList.add("d-none");
            }
        }

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
        const deleteUserForm = document.getElementById("deleteUserForm");

        if (deleteUserForm) {
            deleteUserForm.onsubmit = function onSubmit(form) {
                showClasicLoading();
            }
        }
    </script>
@endsection
