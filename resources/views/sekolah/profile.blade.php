@extends('layouts.app')
@section('title', 'Sekolah - Logo')

@section('content')
    <div class="row">
        <div class="col-lg-12 p-3 bg-white">
            <form action="{{ route('sekolah.update-profile') }}" class="row" method="POST">
                @csrf
                <div class="mb-3 col-md-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $sekolah->name }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $sekolah->email }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="no_telp" class="form-label">no_telp</label>
                    <input type="number" class="form-control" id="no_telp" name="no_telp" value="{{ $sekolah->no_telp }}"
                        required>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="alamat" class="form-label">alamat</label>
                    <textarea name="alamat" required id="alamat" rows="8" class="form-control">{{ $sekolah->alamat }}</textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="visi" class="form-label">visi</label>
                    <textarea name="visi" id="visi" required rows="8" class="form-control">{{ $sekolah->visi }}</textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="misi" class="form-label">misi</label>
                    <textarea name="misi" id="misi" required rows="8" class="form-control">{{ $sekolah->misi }}</textarea>
                </div>

                <div class="mb-3 col-md-6">
                    <label for="bio" class="form-label">bio</label>
                    <textarea name="bio" id="bio" required rows="8" class="form-control">{{ $sekolah->bio }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
