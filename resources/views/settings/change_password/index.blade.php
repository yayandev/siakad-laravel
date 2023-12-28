@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.change_password') }}">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="oldPassword">Old password</label>
                            <div class="col-sm-10">
                                <input type="password" required name="oldPassword" class="form-control" id="oldPassword"
                                    placeholder="Enter old password" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="newPassword">New password</label>
                            <div class="col-sm-10">
                                <input type="password" required name="newPassword" class="form-control" id="newPassword"
                                    placeholder="Enter new password" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="confirmNewPassword">Confirm new password</label>
                            <div class="col-sm-10">
                                <input type="password" required name="confirmNewPassword" class="form-control"
                                    id="confirmNewPassword" placeholder="Enter confirm new password" />
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
