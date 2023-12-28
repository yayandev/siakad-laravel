@extends('layouts.app');
@section('title', 'Account Profile');
@section('content')

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="javascript:void(0);"><i
                            class="mdi mdi-account-outline mdi-20px me-1"></i>Account</a>
                </li>
            </ul>
            <div class="card mb-4">
                <h4 class="card-header">Profile Details</h4>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="{{ auth()->user()->profile_picture }}" alt="user-avatar"
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
                <div class="card-body pt-2 mt-1">
                    @if ($guru->no_hp === null || $guru->nip === null || $guru->alamat === null)
                        <div class="p-3">
                            <div class="alert alert-warning d-flex align-items-center justify-content-between"
                                role="alert">
                                <span><strong>Warning!</strong> Lengkapi data profil anda</span>
                                <button class="btn-close" type="button" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    @endif
                    <form id="formAccountSettings" method="POST" action="{{ route('guru.profile') }}">
                        @csrf
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" required type="text" id="name"
                                        value="{{ $guru->name }}" name="name" value="John" autofocus />
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" id="email" name="email"
                                        value="{{ auth()->user()->email }}" disabled placeholder="john.doe@example.com" />
                                    <label for="email">E-mail</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="role" disabled
                                        value="{{ auth()->user()->role }}" name="role" value="ThemeSelection" />
                                    <label for="role">Role</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" required id="no_hp" name="no_hp"
                                            value="{{ $guru->no_hp }}" class="form-control" placeholder="202 555 0111" />
                                        <label for="no_hp">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" required id="nip" name="nip"
                                            value="{{ $guru->nip }}" class="form-control" placeholder="202 555 0111" />
                                        <label for="nip">Nip</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <textarea required required class="form-control h-px-100" id="alamat" name="alamat" placeholder="Alamat">{{ $guru->alamat }}</textarea>
                                    <label for="alamat">Alamat</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
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
