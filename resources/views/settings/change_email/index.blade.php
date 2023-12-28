@extends('layouts.app')
@section('title', 'Change Email')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Email</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.change_email') }}">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <input type="email" required name="email" value="{{ auth()->user()->email }}"
                                    class="form-control" id="email" placeholder="Enter your email" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">Password</label>
                            <div class="col-sm-10">
                                <input type="password" required name="password" class="form-control" id="password"
                                    placeholder="Enter your password" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
