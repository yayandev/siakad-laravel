@extends('layouts.app')
@section('title', 'Sekolah - Logo')

@section('content')
    <div class="row">
        <div class="col-lg-4 p-3 bg-white">
            <div class="w-full d-flex justify-content-center">
                <img src="{{ $sekolah->logo }}" class="img-fluid" alt="{{ $sekolah->name }}">
            </div>
            <div class="w-full">
                <form action="{{ route('sekolah.update-logo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" class="form-control mb-3 mt-3" name="file" required>
                    <button class="btn btn-primary" type="submit">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
