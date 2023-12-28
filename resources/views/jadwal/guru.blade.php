@extends('layouts.app')
@section('title', 'jadwal')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12">
            <form action="" class="row g-3 align-items-center">
                <div class="col-lg-6">
                    <div class="form-floating form-floating-outline">
                        <select name="filter" id="filter" class="form-select">
                            <option value="">All</option>
                            @foreach ($hari as $item)
                                <option @if (@isset($_GET['filter']) && $item == $_GET['filter']) selected @endif value="{{ $item }}">
                                    {{ $item }}</option>
                            @endforeach
                        </select>
                        <label for="filter">Filter By hari</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Jadwal Guru</h5>
                @if ($jadwals->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Jumlah siswa</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $jadwal->mapel->mapel }}</td>
                                        <td>{{ $jadwal->kelas->code }}</td>
                                        <td>{{ $jadwal->siswa->count() }}</td>
                                        <td>{{ $jadwal->hari }}</td>
                                        <td>{{ Str::limit($jadwal->jam_mulai, 5) }} -
                                            {{ Str::limit($jadwal->jam_selesai, 5) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{-- <div class="mt-3 px-2">
                        {{ $jadwals->links('pagination::bootstrap-5') }}
                    </div> --}}
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#filter').on('change', function() {
                // submit form
                $(this).closest('form').submit()
            })
        })
    </script>
@endsection
