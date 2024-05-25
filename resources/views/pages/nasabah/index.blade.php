@extends('layouts.app', ['class' => ''])

@section('content')
    @include('layouts.navbar.nav1', ['title' => 'List Nasabah'])
    <div class="container pt-4 bg-body-secondary">
        <!-- Button trigger modal -->


        <!-- No Internet Assets Trigger -->
        <div class="d-none">
            <img src="assets\img\no-internet-logo.png" alt="No Internet">
            <img src="assets\img\page-not-found-character.gif" alt="No Internet gif">
        </div>


        <div class="row m-2 mt-1 pr-3 pb-1">
            <div class="col-2 pl-0 m-0">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-person-plus-fill"></i>
                </button>
            </div>

            <div class="col-3 m-0 p-0">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ $hari }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="select-senin" class="dropdown-item" href="/">Senin</a></li>
                        <li><a id="select-selasa" class="dropdown-item" href="/">Selasa</a></li>
                        <li><a id="select-rabu" class="dropdown-item" href="/">Rabu</a></li>
                        <li><a id="select-kamis" class="dropdown-item" href="/">Kamis</a></li>
                        <li><a id="select-jumat" class="dropdown-item" href="/">Jum'at</a></li>
                        <li><a id="select-semua" class="dropdown-item" href="/">Tampilkan Semua</a></li>
                    </ul>
                </div>
            </div>
            <div class="col m-0 p-0 pl-2">
                <input type="text" class="form-control bg-body-tertiary" id="search" placeholder="Cari Nasabah">
            </div>

        </div>


        <div id="table-container">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="bg-success-subtle text-success" scope="col">Nama</th>
                            {{-- <th class="bg-success-subtle" scope="col">Titipan</th> --}}
                            <!-- <th class="bg-success-subtle" scope="col">No HP</th> -->
                            <th class="bg-success-subtle text-success" scope="col">Desa</th>
                            <th class="bg-success-subtle text-success" scope="col"><i class="bi bi-star-fill"></i></th>
                            <th class="bg-success-subtle text-success" scope="col"><i
                                    class="bi bi-calendar2-check-fill"></i>
                            </th>
                            <!-- <th class="bg-success-subtle" scope="col">Keterangan</th> -->
                            <!-- <th class="bg-success-subtle" scope="col">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($nasabahs as $nasabah)
                            <tr>
                                <td><a href="/detail-nasabah/{{ $nasabah->id }}"
                                        onclick="showLoading(3000)">{{ $nasabah->nama }}</a>
                                    <i class="bi bi-arrow-right-short {{ $nasabah->titipan ? '' : 'd-none' }}"></i>

                                    @if ($nasabah->koordinat_titipan)
                                        <a href="{{ $nasabah->koordinat_titipan }}" target="_blank"
                                            onclick="showLoading(3000)">{{ $nasabah->titipan }}</a>
                                    @else
                                        {{ $nasabah->titipan }}
                                    @endif
                                </td>
                                {{-- <td></td> --}}
                                <!-- <td>{{ $nasabah->no_hp }}</td> -->
                                <td>
                                    @if ($nasabah->koordinat)
                                        <a href="{{ $nasabah->koordinat }}" target="_blank"
                                            onclick="showLoading(3000)">{{ $nasabah->desa }}</a>
                                    @else
                                        {{ $nasabah->desa }}
                                    @endif
                                </td>
                                <!-- <td>{{ $nasabah->keterangan }}</td> -->
                                <!-- <td><i class="bi bi-trash-fill"></i> <i class="bi bi-pencil-square"></i></td> -->
                                <td class="text-body-tertiary">{{ $nasabah->rating > 0 ? $nasabah->rating : '-' }}</th>
                                    </th>
                                <td
                                    class="text-{{ $nasabah->checked ? 'success' : ($nasabah->status != 'aktif' ? 'danger' : 'body-tertiary') }}  {{ $nasabah->status != 'aktif' ? '' : 'check-button' }}">
                                    <i class="bi bi-check-all" id="{{ $nasabah->id }}"></i></th>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="bg-success-subtle text-center text-muted"><small>Total Nasabah:
                                    {{ $nasabahs->count() }}</small></a></td>
                            <td class="bg-success-subtle text-center text-muted"><a href="/"><small
                                        class="text-body-tertiary" id ="show-non-active"><i
                                            class="bi bi-eye{{ $with_non_active == 'true' ? '-slash' : '' }}-fill"></i></small>
                            </td>
                            <td class="bg-success-subtle text-center text-muted"><small class="text-body-tertiary"
                                    id="reset-check-button"><i class="bi bi-x-square-fill"></i></small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <div class="card m-2 p-2 mb-2">
            <div class="card-header"data-bs-toggle="collapse" data-bs-target="#collapseExcel" aria-expanded="false"
                aria-controls="collapseExcel">
                <div class="card-title">

                    <h6><i class="bi bi-caret-down-fill"></i> Import & Export Data Nasabah :</h6>
                </div>
            </div>
            <div class="collapse" id="collapseExcel">
                <div class="card-body">
                    <form action="/import-nasabah" method="POST" enctype="multipart/form-data" id="importNasabahForm">

                        @csrf

                        <div class="input-group mb-3">
                            <input name="data_nasabah" type="file"accept=".xls,.xlsx" class="form-control"
                                id="inputGroupFileNasabah" aria-describedby="inputGroupFileNasabah" aria-label="Upload">
                        </div>

                        <button id="btn-import-nasabah" type="submit" class="btn btn-success" disabled
                            onclick="return confirm('Pastikan format tabel sudah benar')"><i class="bi bi-upload"></i>
                            Import
                            Dari Excel</button>
                    </form>
                    <hr>
                    <form action="/export-nasabah" method="POST" enctype="multipart/form-data" id="importNasabahForm">

                        @csrf
                        <button id="btn-export-nasabah" type="submit" class="btn btn-primary"><i
                                class="bi bi-download"></i>
                            Export Ke Excel</button>
                    </form>
                </div>

            </div>
        </div>
        <div class="card m-2 p-2 mb-5">
            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#collapseAccount" aria-expanded="false"
                aria-controls="collapseAccount">
                <div class="card-title">
                    <h6><i class="bi bi-caret-down-fill"></i> Kelola Akun :</h6>
                </div>
            </div>
            <div class="collapse" id="collapseAccount">
                <div class="card-body">
                    <p><a href="/user/{{ auth()->user()->id }}">Profile</a></p>
                    @role('admin')
                        <p><a href="/user">Semua User</a></p>
                    @endrole
                    <p><a href="/logout">Logout</a></p>

                </div>
            </div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Nasabah</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/" method="POST" enctype="multipart/form-data" id="inputNasabahForm">

                        @csrf

                        <div class="card-body">


                            <div class="input-group mb-3">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" placeholder="Nama" name="nama"
                                        aria-label="Username" aria-describedby="addon-wrapping">
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" placeholder="Nomor HP" name="no_hp"
                                        aria-label="Alamat" aria-describedby="addon-wrapping">
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" placeholder="Desa" name="desa"
                                        aria-describedby="addon-wrapping">
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                <div class="row m-0 p-0" style="width:100%;">
                                    <div class="col m-0 p-0">
                                        <div class="input-group flex-nowrap">
                                            <input type="text" class="form-control" placeholder="Titik Koordinat"
                                                name="koordinat" aria-label="Alamat" aria-describedby="addon-wrapping">
                                        </div>
                                    </div>
                                    <div class="col-2 m-0 p-0 text-end">
                                        <a href="https://www.google.com/maps" target="_blank" class="btn btn-primary"><i
                                                class="bi bi-pin-map-fill"></i></a>
                                    </div>
                                </div>
                            </div>


                            <div class="input-group mb-3">
                                @php
                                    $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
                                @endphp
                                <select class="form-select" aria-label="Default select example" name="kelompok">
                                    @foreach ($days as $day)
                                        <option value="{{ $day }}" {{ $day == $hari ? 'selected' : '' }}>
                                            {{ $day }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="input-group mb-3">
                                <div class="input-group flex-nowrap">
                                    <input id="input-titipan" type="text" class="form-control" placeholder="Titipan"
                                        name="titipan">
                                </div>
                            </div>


                            <div id="input-titipan-koordinat" class="input-group mb-3 d-none">
                                <div class="row m-0 p-0" style="width:100%;">
                                    <div class="col m-0 p-0">
                                        <div class="input-group flex-nowrap">
                                            <input type="text" class="form-control"
                                                placeholder="Titik Koordinat Titipan" name="koordinat_titipan"
                                                aria-label="Alamat" aria-describedby="addon-wrapping">
                                        </div>
                                    </div>
                                    <div class="col-2 m-0 p-0 text-end">
                                        <a href="https://www.google.com/maps" target="_blank" class="btn btn-primary"><i
                                                class="bi bi-pin-map-fill"></i></a>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="input-group mb-3">
                                @php
                                    $resorts = [1, 2, 3, 4, 5, 6];
                                @endphp
                                <select class="form-select" aria-label="Default select example" name="resort">
                                    @foreach ($resorts as $rst)
                                        <option value="{{ $rst }}" {{ $rst == $resort ? 'selected' : '' }}>
                                            Resort {{ $rst }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <span class="label">Foto KTP</span>
                            <div class="input-group mb-3">
                                <input name="foto_ktp" type="file" accept="image/*" class="form-control"
                                    id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                            </div>


                            <span class="label">Foto Selfy</span>
                            <div class="input-group mb-3">
                                <input name="foto_selfy" type="file" accept="image/*" class="form-control"
                                    id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                            </div>

                            <span class="label">Foto Rumah</span>
                            <div class="input-group mb-3">
                                <input name="foto_rumah" type="file" accept="image/*" class="form-control"
                                    id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                            </div>


                            <div class="input-group mb-3">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" placeholder="Keterangan"
                                        name="keterangan" aria-describedby="addon-wrapping">
                                </div>
                            </div>

                        </div>

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="resort" value="{{ $resort }}">

                        <button type="submit" class="btn btn-success"><i class="bi bi-floppy2"></i> Simpan</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <script>
        let senin = document.getElementById('select-senin');
        let selasa = document.getElementById('select-selasa');
        let rabu = document.getElementById('select-rabu');
        let kamis = document.getElementById('select-kamis');
        let jumat = document.getElementById('select-jumat');
        let allDay = document.getElementById('select-semua');


        senin.addEventListener('click', function() {
            console.log('senin');
            document.cookie = "day=senin";
        });
        selasa.addEventListener('click', function() {
            document.cookie = "day=selasa";
        });
        rabu.addEventListener('click', function() {
            document.cookie = "day=rabu";
        });
        kamis.addEventListener('click', function() {
            document.cookie = "day=kamis";
        });
        jumat.addEventListener('click', function() {
            document.cookie = "day=jumat";
        });
        allDay.addEventListener('click', function() {
            document.cookie = "day=semua";
        });

        let showNonActive = document.getElementById('show-non-active');


        showNonActive.addEventListener('click', function() {
            /* get the cookie based on input */

            function getCookieByName(name) {
                const cookieString = document.cookie;
                const cookies = cookieString.split('; ');

                for (let cookie of cookies) {
                    const [cookieName, cookieValue] = cookie.split('=');
                    if (cookieName === name) {
                        return decodeURIComponent(cookieValue);
                    }
                }
                return null;
            }


            if (getCookieByName('withNonActive') == 'true') {
                document.cookie = "withNonActive=false";
            } else {
                document.cookie = "withNonActive=true";
            }
        });


        const search = document.getElementById('search');
        const tableContainer = document.getElementById('table-container');

        search.addEventListener('keyup', function() {
            const searchValue = search.value;

            if (searchValue.length > 0) {
                const xhr = new XMLHttpRequest();

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        tableContainer.innerHTML = xhr.responseText;
                    }
                }

                xhr.open('GET', '/search-nasabah?search=' + searchValue, true);
                xhr.send();

            } else {
                //refresh the page
                window.location.reload();
            }
        });

        const inputTitipan = document.getElementById('input-titipan');
        const inputTitipanKoordinat = document.getElementById('input-titipan-koordinat');

        inputTitipan.addEventListener('keyup', function() {
            if (inputTitipan.value.length > 1) {
                //remove d-none class
                inputTitipanKoordinat.classList.remove('d-none');
            } else {
                //add d-none class
                inputTitipanKoordinat.classList.add('d-none');
            };
        });

        const inputGroupFileNasabah = document.getElementById('inputGroupFileNasabah');
        const buttonImportNasabah = document.getElementById('btn-import-nasabah');

        inputGroupFileNasabah.addEventListener('change', function() {
            buttonImportNasabah.disabled = false;
        });

        document.getElementById("inputNasabahForm").onsubmit = function onSubmit(form) {
            showClasicLoading();
        }
        document.getElementById("importNasabahForm").onsubmit = function onSubmit(form) {
            showClasicLoading();
        }


        const btns = document.getElementsByClassName("check-button");

        Array.from(btns).forEach((i) => {
            i.addEventListener("click", (e) => {

                // toggle class text-success

                e.target.parentElement.classList.toggle('text-success');
                e.target.parentElement.classList.toggle('text-body-tertiary');

                showLoading();

                const xhr = new XMLHttpRequest();

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        hideLoading();
                    }
                }

                xhr.open('GET', '/checkin-nasabah/?id=' + e.target.id, true);
                xhr.send();

            });
        });

        const resetCheckButton = document.getElementById('reset-check-button');
        resetCheckButton.addEventListener('click', function() {

            Array.from(btns).forEach((i) => {
                i.classList.remove('text-success');
                i.classList.add('text-body-tertiary');

            });

            showLoading();
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    hideLoading();
                }
            }

            xhr.open('GET', '/checkin-nasabah', true);
            xhr.send();

        });
    </script>
@endsection
