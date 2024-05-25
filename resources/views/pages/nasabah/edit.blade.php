@extends('layouts.app', ['class' => ''])

@section('content')
    @include('layouts.navbar.nav2', ['title' => $nasabah->nama])
    <div class="container">
        <p class="mt-2">Foto KTP</p>
        @if ($nasabah->foto_ktp)
            <img src="/storage/{{ $nasabah->foto_ktp }}" class="img-thumbnail" alt="">
        @endif
        <hr>
        <p class="mt-2">Foto Selfy </p>
        @if ($nasabah->foto_selfy)
            <img src="/storage/{{ $nasabah->foto_selfy }}" class="img-thumbnail" alt="">
        @endif
        <hr>
        <p class="mt-2">Foto Rumah</p>
        @if ($nasabah->foto_rumah)
            <img src="/storage/{{ $nasabah->foto_rumah }}" class="img-thumbnail" alt="">
        @endif
        <hr>
        <div class="card mb-4">
            <form action="/detail-nasabah/{{ $nasabah->id }}" method="POST" enctype="multipart/form-data"
                id="inputNasabahForm">

                @csrf

                <div class="card-body">


                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Nama" name="nama"
                                aria-label="Username" aria-describedby="addon-wrapping" value="{{ $nasabah->nama }}">
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Nomor HP" name="no_hp"
                                aria-label="Alamat" aria-describedby="addon-wrapping" value="{{ $nasabah->no_hp }}">
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control" placeholder="Desa" name="desa"
                                aria-describedby="addon-wrapping" value="{{ $nasabah->desa }}">
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="row m-0 p-0" style="width:100%;">
                            <div class="col m-0 p-0">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" placeholder="Titik Koordinat"
                                        name="koordinat" aria-label="Alamat" aria-describedby="addon-wrapping"
                                        value="{{ $nasabah->koordinat }}">
                                </div>
                            </div>
                            <div class="col-2 m-0 p-0 text-end">
                                <a href="{{ $nasabah->koordinat ?? 'https://www.google.com/maps' }}" target="_blank"
                                    class="btn btn-primary"><i class="bi bi-pin-map-fill"></i></a>
                            </div>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        @php
                            $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];
                        @endphp
                        <select class="form-select" aria-label="Default select example" name="kelompok">
                            @foreach ($days as $day)
                                <option value="{{ $day }}" {{ $day == $nasabah->kelompok ? 'selected' : '' }}>
                                    {{ $day }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="input-group mb-3">
                        <div class="input-group flex-nowrap">
                            <input id="input-titipan" type="text" class="form-control" placeholder="Titipan"
                                name="titipan" value="{{ $nasabah->titipan }}">
                        </div>
                    </div>

                    <div id="input-titipan-koordinat" class="input-group mb-3 {{ $nasabah->titipan ? '' : 'd-none' }}">
                        <div class="row m-0 p-0" style="width:100%;">
                            <div class="col m-0 p-0">
                                <div class="input-group flex-nowrap">
                                    <input type="text" class="form-control" placeholder="Titik Koordinat Titipan"
                                        name="koordinat_titipan" aria-label="Alamat" aria-describedby="addon-wrapping"
                                        value="{{ $nasabah->koordinat_titipan }}">
                                </div>
                            </div>
                            <div class="col-2 m-0 p-0 text-end">
                                <a href="{{ $nasabah->koordinat_titipan ?? 'https://www.google.com/maps' }}"
                                    target="_blank" class="btn btn-primary"><i class="bi bi-pin-map-fill"></i></a>
                            </div>
                        </div>
                    </div>

                    <span class="label">Foto KTP</span>
                    <div class="input-group mb-3">
                        <input name="foto_ktp" type="file" accept="image/*" class="form-control" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload">
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
                            <input type="text" class="form-control" placeholder="Keterangan" name="keterangan"
                                aria-describedby="addon-wrapping" value="{{ $nasabah->keterangan }}">
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <div class="row m-0 p-0" style="width:100%;">
                            <div class="col m-0 p-0">
                                @php
                                    $ratings = [0, 1, 2, 3, 4, 5];
                                @endphp
                                <select class="form-select" aria-label="Default select example" name="rating"
                                    {{ $nasabah->resort == $user->resort ? '' : 'disabled' }}>
                                    @foreach ($ratings as $rating)
                                        <option value="{{ $rating }}"
                                            {{ $rating == $user->rating ? 'selected' : '' }}>
                                            @if ($rating == 0)
                                                Belum Rating
                                            @else
                                                Rating {{ $rating }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1 m-0 p-0"></div>
                            <div class="col m-0 p-0">
                                @php
                                    $checked = [0 => 'blm dikunjungi', 1 => 'sdh dikunjungi'];
                                @endphp
                                <select class="form-select" aria-label="Default select example" name="checked"
                                    {{ $nasabah->resort == $user->resort ? '' : 'disabled' }}>
                                    @foreach ($checked as $key => $st)
                                        <option value="{{ $key }}"
                                            {{ $key == $nasabah->checked ? 'selected' : '' }}>
                                            {{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="input-group mb-3">
                        <div class="row m-0 p-0" style="width:100%;">
                            <div class="col m-0 p-0">
                                @php
                                    $resorts = [1, 2, 3, 4, 5, 6];
                                @endphp
                                <select class="form-select" aria-label="Default select example" name="resort"
                                    {{ $nasabah->resort == $user->resort ? '' : 'disabled' }}>
                                    @foreach ($resorts as $rst)
                                        <option value="{{ $rst }}"
                                            {{ $rst == $nasabah->resort ? 'selected' : '' }}>
                                            Resort {{ $rst }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1 m-0 p-0"></div>
                            <div class="col m-0 p-0">
                                @php
                                    $status = ['aktif', 'lunas', 'tidak aktif'];
                                @endphp
                                <select class="form-select" aria-label="Default select example" name="status"
                                    {{ $nasabah->resort == $user->resort ? '' : 'disabled' }}>
                                    @foreach ($status as $st)
                                        <option value="{{ $st }}"
                                            {{ $st == $nasabah->status ? 'selected' : '' }}>
                                            {{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="resort" value="{{ $nasabah->resort }}">

                <div class="p-3">
                    <button type="submit" class="btn btn-success"><i class="bi bi-floppy2"></i> Simpan</button>
                </div>
            </form>

            @if ($nasabah->resort == $user->resort && $nasabah->status != 'aktif')
                <form action="/detail-nasabah/{{ $nasabah->id }}" method="POST" id="deleteNasabahForm">

                    @csrf

                    <input type="hidden" name="destroy" value="true">

                    <div class="p-3">
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Apakah Anda yakin menghapus data ini?')"><i
                                class="bi bi-trash-fill"></i>
                            Hapus</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
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

        document.getElementById("inputNasabahForm").onsubmit = function onSubmit(form) {
            showClasicLoading();
        }
        const deleteNasabahForm = document.getElementById("deleteNasabahForm");

        if (deleteNasabahForm) {
            deleteNasabahForm.onsubmit = function onSubmit(form) {
                showClasicLoading();
            }
        }
    </script>
@endsection
