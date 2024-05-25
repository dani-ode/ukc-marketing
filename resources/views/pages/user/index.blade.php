@extends('layouts.app', ['class' => ''])

@section('content')
    @include('layouts.navbar.nav2', ['title' => 'List user'])
    <div class="container bg-body-secondary">
        <!-- Button trigger modal -->


        <!-- No Internet Assets Trigger -->
        <div class="d-none">
            <img src="assets\img\no-internet-logo.png" alt="No Internet">
            <img src="assets\img\page-not-found-character.gif" alt="No Internet gif">
        </div>

        <div id="table-container">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="bg-success-subtle text-success" scope="col">Nama</th>
                            `<th class="bg-success-subtle text-success" scope="col">No HP</th>
                            <th class="bg-success-subtle text-success" scope="col"><i class="bi bi-receipt-cutoff"></i>
                            </th>
                            <th class="bg-success-subtle text-success" scope="col"><i class="bi bi-person-fill"></i></th>
                            <!-- <th class="bg-success-subtle" scope="col">Keterangan</th> -->
                            <!-- <th class="bg-success-subtle" scope="col">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            @if ($user->id == Auth::user()->id)
                                @continue
                            @endif

                            <tr>
                                <td><a href="/user/{{ $user->id }}" onclick="showLoading(3000)">{{ $user->nama }}</a>
                                </td>
                                <td>{{ $user->no_hp }}</td>
                                <td class="text-body-tertiary">{{ $user->resort > 0 ? $user->resort : '-' }}</td>
                                <td class="text-{{ $user->status == 'aktif' ? 'success' : 'body-tertiary' }}">
                                    <i class="bi bi-toggle2-{{ $user->status == 'aktif' ? 'on' : 'off' }}"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection
