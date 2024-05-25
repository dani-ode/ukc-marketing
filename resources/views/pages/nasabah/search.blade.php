<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="bg-success-subtle text-success" scope="col">Nama</th>
                {{-- <th class="bg-success-subtle" scope="col">Titipan</th> --}}
                <!-- <th class="bg-success-subtle" scope="col">No HP</th> -->
                <th class="bg-success-subtle text-success" scope="col">Desa</th>
                <th class="bg-success-subtle text-success" scope="col"><i class="bi bi-star-fill"></i></th>
                <th class="bg-success-subtle text-success" scope="col"><i class="bi bi-calendar2-check-fill"></i>
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
                        {{ $nasabah->titipan }}
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
                <td class="bg-success-subtle text-center text-muted"><a href="/"><small class="text-body-tertiary"
                            id ="show-non-active"><i
                                class="bi bi-eye{{ $with_non_active == 'true' ? '-slash' : '' }}-fill"></i></small>
                </td>
                <td class="bg-success-subtle text-center text-muted"><small class="text-body-tertiary"
                        id="reset-check-button"><i class="bi bi-x-square-fill"></i></small></td>
            </tr>
        </tbody>
    </table>
</div>
