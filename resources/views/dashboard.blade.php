@extends('layouts.app')
@section('title', 'Dashboard')


@section('content')
    <div class="row mb-3 gy-3">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center gy-3 text-center">
                        <div class="col-md-4">
                            <img src="/assets/img/logo/1.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-md-8">
                            <h3>Selamat datang <strong>{{ auth()->user()->name }}</strong> di Sistem Informasi
                                Akademik!
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ auth()->user()->profile_picture }}" width="100" height="100" class="rounded-circle"
                        alt="">
                    <div class="mt-2">
                        <span
                            @if (auth()->user()->status === 'aktif') class="badge rounded-pill bg-label-success mb-2"
                        @else
                        class="badge rounded-pill bg-label-danger mb-2" @endif>{{ auth()->user()->status }}</span>
                    </div>
                    <p class="card-text mt-2">{{ auth()->user()->name }}</p>
                    <p class="card-text mt-2">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </div>


    @if (auth()->user()->role === 'admin')
        <div class="row gy-4">
            <!-- Statistik -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2">Statistik</h5>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="transactionID" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Update</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-primary rounded shadow">
                                            <i class="mdi mdi-account-group mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="small mb-1">Users</div>
                                        <h5 class="mb-0">{{ $users }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-success rounded shadow">
                                            <i class="mdi mdi-account-group mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="small mb-1">Siswa</div>
                                        <h5 class="mb-0">{{ $siswa }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-warning rounded shadow">
                                            <i class="mdi mdi-account-group mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="small mb-1">Guru</div>
                                        <h5 class="mb-0">{{ $guru }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar">
                                        <div class="avatar-initial bg-info rounded shadow">
                                            <i class="mdi mdi-account-group mdi-24px"></i>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <div class="small mb-1">Pendaftar</div>
                                        <h5 class="mb-0">{{ $pendaftar }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistik -->

        </div>
    @elseif(auth()->user()->role === 'siswa' && auth()->user()->status === 'aktif')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <h5 class="card-header">Jadwal Hari {{ $hari_ini }}</h5>
                    @if ($jadwals->count() > 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mapel</th>
                                        <th>Guru</th>
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
                                            <td>{{ $jadwal->guru->name }}</td>
                                            <td>{{ $jadwal->hari }}</td>
                                            <td>{{ Str::limit($jadwal->jam_mulai, 5) }} -
                                                {{ Str::limit($jadwal->jam_selesai, 5) }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Tidak ada jadwal</p>
                    @endif
                </div>
            </div>
        </div>
    @elseif(auth()->user()->role === 'guru' && auth()->user()->status === 'aktif')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <h5 class="card-header">Jadwal Hari {{ $hari_ini }}</h5>
                    @if ($jadwals->count() > 0)
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mapel</th>
                                        <th>Kelas</th>
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
                                            <td>{{ $jadwal->hari }}</td>
                                            <td>{{ Str::limit($jadwal->jam_mulai, 5) }} -
                                                {{ Str::limit($jadwal->jam_selesai, 5) }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Tidak ada jadwal</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

@endsection
