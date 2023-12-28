@extends('layouts.app')
@section('title', 'Users')
@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal"><i
                    class="mdi mdi-plus"></i> Add User</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-lg-12">
            <form action="" class="d-flex justify-content-between gap-2">
                <input type="text" class="form-control" name="search" placeholder="Email or Name">
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-magnify"></i></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Table users</h5>
                @if ($users->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span
                                                @if ($user->role == 'admin') class="badge rounded-pill bg-label-success me-1"
                                        @else
                                        class="badge rounded-pill bg-label-info me-1" @endif>{{ $user->role }}</span>
                                        </td>
                                        <td><span
                                                @if ($user->status === 'aktif') class="badge rounded-pill bg-label-primary me-1"
                                    @else
                                    class="badge rounded-pill bg-label-danger me-1" @endif>{{ $user->status }}</span>
                                        </td>
                                        <td>
                                            <img src="{{ $user->profile_picture }}" alt="Avatar" width="40"
                                                height="40" class="rounded-circle" />
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal" data-id="{{ $user->id }}"
                                                        data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                        data-role="{{ $user->role }}" data-status="{{ $user->status }}"
                                                        type="button"><i class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    @if ($user->id !== auth()->user()->id)
                                                        <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal" data-id="{{ $user->id }}"><i
                                                                class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
                                                    @endif

                                                    <a href="{{ route('users.reset_password', $user->id) }}"
                                                        class="dropdown-item"><i class="mdi mdi-lock-reset"></i> Reset
                                                        password</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 px-2">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>

    {{-- modal update users --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Modal title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="editUserForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input required type="text" id="name" name="name" class="form-control"
                                        placeholder="xxxx@xxx.xx" />
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select required name="role" id="level" class="form-select">
                                        <option value="" disabled>Pilih level</option>
                                        <option value="admin">admin</option>
                                        <option value="guru">guru</option>
                                        <option value="siswa">siswa</option>
                                    </select>
                                    <label for="level">Level</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input required name="email" type="email" id="email" class="form-control"
                                        placeholder="xxxx@xxx.xx" />
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select required name="status" id="status" class="form-select">
                                        <option value="" disabled>Pilih Status</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="tidak aktif">Tidak Aktif</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editUserModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                var name = $(e.relatedTarget).data('name');
                var email = $(e.relatedTarget).data('email');
                var role = $(e.relatedTarget).data('role');
                var status = $(e.relatedTarget).data('status');

                $('#editUserForm').attr('action', '/users/update/' + id);
                $('#modalTitle').text('Edit ' + name);
                $('#name').val(name);
                $('#email').val(email);
                $('#level').val(role);
                $('#status').val(status);
            })
        })
    </script>


    {{-- modal confirm delete --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Konfirmasi Hapus!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="" id="deleteForm">
                    @csrf
                    <div class="modal-body">
                        <h3>Apakah anda yakin?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary">Yakin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');

                $('#deleteForm').attr('action', '/users/destroy/' + id);
            })
        })
    </script>

    <div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Create User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" required name="name" class="form-control" id="name"
                                    placeholder="John Doe" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <select name="status" required id="status" class="form-select">
                                    <option value="" disabled selected>Select status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="email">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="email" name="email" required id="email" class="form-control"
                                        placeholder="john.doe@example.com" aria-label="john.doe"
                                        aria-describedby="email" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="role">Role</label>
                            <div class="col-sm-10">
                                <select name="role" required id="role" class="form-select">
                                    <option value="" disabled selected>Select role</option>
                                    <option value="admin">admin</option>
                                    <option value="guru">guru</option>
                                    <option value="siswa">siswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="password">password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" required id="password" class="form-control"
                                        placeholder="*******" aria-label="password" aria-describedby="password" />
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="confirm_password">Confirm password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="password" name="confirm_password" required id="confirm_password"
                                        class="form-control" placeholder="*******" aria-label="confirm_password"
                                        aria-describedby="confirm_password" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
