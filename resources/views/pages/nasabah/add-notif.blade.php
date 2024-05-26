@extends('layouts.app', ['class' => ''])

@section('content')
    <div class="container p-3" style="height: 100%">
        <div class="card mt-5">
            <div class="card-header bg-success-subtle">
                <h4 class="card-title text-center text-success">Data Berhasil dikirim</h4>
            </div>
            <div class="card-body">
                @if ($nasabah)
                    <p class="mt-2">Nama : {{ $nasabah->nama }}</p>
                    <hr>
                    <p class="mt-2">Hari : {{ $nasabah->kelompok }}</p>
                    <hr>
                    <p class="mt-2">Keterangan : {{ $nasabah->keterangan }}</p>
                    <hr>
                    ...
                @else
                    <p class="mt-2">Total Data : {{ $total_data }}</p>
                @endif
                <br>
                <div class="text-center">
                    <button onclick="window.history.go(-1); return false;" class="btn btn-success"><i
                            class="bi bi-box-arrow-in-left"></i> Ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection
