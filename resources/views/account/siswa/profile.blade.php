@extends('layouts.app')
@section('title', 'Account / Profile')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('account.profile') }}"><i
                            class="mdi mdi-account-outline mdi-20px me-1"></i>Profile</a>
                </li>
                @if ($siswa->user->status === 'aktif')
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                class="mdi mdi-account-group mdi-20px me-1"></i>Transkip nilai</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('siswa.kelas') }}"><i
                                class="mdi mdi-link mdi-20px me-1"></i>Kelas</a>
                    </li>
                @endif
            </ul>
            <div class="card mb-4">
                <h4 class="card-header">Profile Details</h4>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ $siswa->user->profile_picture }}" alt="user-avatar"
                            class="d-block w-px-120 h-px-120 rounded" id="uploadedAvatar" />
                        <form action="{{ route('account.change-profile-picture') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0" id="btn-upload">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="image" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />

                                </label>
                                <div id="btn-option" class="d-none">
                                    <button type="submit" class="btn btn-outline-primary account-image-reset mb-3">
                                        <i class="mdi mdi-reload d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">submit</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger account-image-reset mb-3"
                                        id="btn-cancel">
                                        <i class="mdi mdi-reload d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">cancel</span>
                                    </button>
                                </div>

                                <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</div>
                            </div>
                        </form>
                    </div>
                </div>
                @if (
                    $siswa->nisn === null ||
                        $siswa->nis === null ||
                        $siswa->nik === null ||
                        $siswa->ayah === null ||
                        $siswa->ibu === null ||
                        $siswa->alamat === null ||
                        $siswa->jk === null ||
                        $siswa->no_telp === null ||
                        $siswa->tempat_lahir === null)
                    <div class="p-3">
                        <div class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
                            <span><strong>Warning!</strong> Lengkapi data profil anda</span>
                            <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                @endif
                <div class="card-body pt-2 mt-1">
                    <form id="formAccountSettings" method="POST" action="{{ route('siswa.profile') }}">
                        @csrf
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" required id="name" name="name"
                                        value="{{ $siswa->user->name }}" autofocus />
                                    <label for="name">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ $siswa->user->email }}" disabled placeholder="john.doe@example.com" />
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="role" disabled name="role"
                                        value="{{ $siswa->user->role }}" />
                                    <label for="role">Role</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="tel" id="no_tlp" name="no_telp" required
                                            value="{{ $siswa->no_telp }}" class="form-control" placeholder="202 555 0111" />
                                        <label for="no_tlp">No Tlp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required value="{{ $siswa->nisn }}"
                                        id="nisn" name="nisn" placeholder="" />
                                    <label for="nisn">Nisn</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required value="{{ $siswa->nis }}"
                                        id="nis" name="nis" placeholder="" readonly />
                                    <label for="nis">Nis</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required value="{{ $siswa->nik }}"
                                        id="nik" name="nik" placeholder="California" />
                                    <label for="nik">Nik</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="jk" name="jk" required class="select2 form-select">
                                        <option disabled selected value="">Select</option>
                                        <option value="laki-laki" @if ($siswa->jk == 'laki-laki') selected @endif>
                                            laki-laki</option>
                                        <option value="perempuan" @if ($siswa->jk == 'perempuan') selected @endif>
                                            perempuan</option>
                                    </select>
                                    <label for="jk">Jenis kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" required type="text" id="tempat_lahir"
                                        value="{{ $siswa->tempat_lahir }}" name="tempat_lahir"
                                        placeholder="California" />
                                    <label for="tempat_lahir">Tempat lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" required class="form-control"
                                        value="{{ Str::substr($siswa->tgl_lahir, 0, 10) }}" id="tgl_lahir"
                                        name="tgl_lahir" placeholder="231465" />
                                    <label for="tgl_lahir">Tanggal lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" value="{{ $siswa->ayah }}"
                                        id="ayah" name="ayah" required placeholder="joko" />
                                    <label for="ayah">Ayah</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" required value=" {{ $siswa->ibu }}" type="text"
                                        id="ibu" name="ibu" placeholder="joko" />
                                    <label for="ibu">Ibu</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <textarea required class="form-control h-px-100" id="alamat" name="alamat" placeholder="Alamat">{{ $siswa->alamat }}</textarea>
                                    <label for="alamat">Alamat</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="d-block mb-2">Status</label>
                                <span
                                    @if ($siswa->user->status === 'aktif') class="badge rounded-pill bg-label-success mb-2"
                        @else
                        class="badge rounded-pill bg-label-danger mb-2" @endif>{{ $siswa->user->status }}</span>
                                @if ($siswa->user->status === 'tidak aktif')
                                    <p class="text-secondary text-muted">Silahkan aktifkan akun anda kepada administrator
                                        di sekolah!</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
        </div>
    </div>


    <script>
        let upload = document.getElementById('upload');
        let btnUpload = document.getElementById('btn-upload');

        let btnOptions = document.getElementById('btn-option');
        let priview = document.getElementById('uploadedAvatar');
        let files = document.getElementById('upload')

        upload.addEventListener('change', function() {
            if (files != '') {
                btnUpload.classList.add('d-none');
                btnOptions.classList.remove('d-none');
                btnOptions.classList.add('d-inline');

                // create priview
                priview.src = URL.createObjectURL(files.files[0]);
            } else {
                btnUpload.classList.remove('d-none');
                btnOptions.classList.remove('d-inline');
                btnOptions.classList.add('d-none');
            }
        })

        let btnCancel = document.getElementById('btn-cancel');

        btnCancel.addEventListener('click', function() {
            document.location.reload(true);
        })
    </script>
@endsection
