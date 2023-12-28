@extends('layouts.app')
@section('title', 'Account / Profile')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('account.profile') }}"><i
                            class="mdi mdi-account-outline mdi-20px me-1"></i>Profile</a>
                </li>
                @if ($siswa->user->status === 'aktif')
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('siswa.kelas') }}"><i
                                class="mdi mdi-link mdi-20px me-1"></i>Kelas</a>
                    </li>
                @endif
            </ul>
            <div class="card mb-4">
                <h4 class="card-header">Kelas</h4>
                <!-- Account -->
                <div class="card-body pt-2 mt-1">
                    @if ($siswa->id_kelas === null)
                        <div class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
                            <span><strong>Warning!</strong> Kamu belum terdaftar di kelas apapun!</span>
                            <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                        </div>
                    @else
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" readonly type="text" required id="name"
                                        name="name" value="{{ $siswa->kelas->walikelas->name }}" autofocus />
                                    <label for="name">Wali kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" readonly type="text" required id="nip"
                                        name="nip" value="{{ $siswa->kelas->walikelas->nip }}" autofocus />
                                    <label for="nip">Nip Wali kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" readonly type="text" required id="no_hp"
                                        name="no_hp" value="{{ $siswa->kelas->walikelas->no_hp }}" autofocus />
                                    <label for="no_hp">No hp Wali kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="kelas" name="kelas"
                                        value="{{ $siswa->kelas->code }}" readonly placeholder="john.doe@example.com" />
                                    <label for="kelas">Kelas</label>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>
@endsection
