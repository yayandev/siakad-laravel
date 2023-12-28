@extends('layouts.app')
@section('title', 'guru')

@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGuruModal"><i class="mdi mdi-plus"></i>
                Add guru</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-lg-12">
            <form action="" class="d-flex justify-content-between gap-2">
                <input type="text" class="form-control" name="search" placeholder="Nip...">
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-magnify"></i></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Table guru</h5>
                @if ($gurus->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Nip</th>
                                    <th>No Tlp</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($gurus as $guru)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $guru->name }}</td>
                                        <td>{{ $guru->nip }}</td>
                                        <td>{{ $guru->no_hp }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editGuruModal" data-id="{{ $guru->id }}"
                                                        type="button"><i class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $guru->id }}"><i
                                                            class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 px-2">
                        {{ $gurus->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>


    {{-- modal edit guru --}}
    <div class="modal fade" id="editGuruModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Biodata guru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="loader" class="d-flex justify-content-center p-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form action="" id="formEditguru" method="POST" class="hidden">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" required id="name"
                                        name="name" autofocus />
                                    <label for="name">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="tel" id="no_tlp" value="" name="no_hp" required
                                            class="form-control" placeholder="202 555 0111" />
                                        <label for="no_tlp">No Tlp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required id="nip" name="nip"
                                        placeholder="" />
                                    <label for="nip">Nip</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea required class="form-control h-px-100" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                                    <label for="alamat">Alamat</label>
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
            $('#editGuruModal').on('show.bs.modal', function(event) {


                var button = $(event.relatedTarget)

                var id = button.data('id')

                var modal = $(this)

                $('#loader').removeClass('d-none');
                $('#formEditguru').addClass('d-none');

                $('#formEditguru').attr('action', '/guru/update/' + id);


                $.ajax({
                    type: "GET",
                    url: '/api/guru/' + id,
                    success: function(response) {
                        modal.find('.modal-body #name').val(response.data.name);
                        modal.find('.modal-body #no_tlp').val(response.data.no_hp);
                        modal.find('.modal-body #nip').val(response.data.nip);
                        modal.find('.modal-body #alamat').val(response.data.alamat);

                        $('#loader').addClass('d-none');
                        $('#formEditguru').removeClass('d-none');
                    }
                })
            })
        })
    </script>

    {{-- modal add guru --}}
    <div class="modal fade" id="addGuruModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add guru</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('guru.store') }}" id="formAddguru" method="POST" class="hidden">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" required id="name"
                                        name="name" autofocus />
                                    <label for="name">Nama</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="email" required id="email"
                                        name="email" autofocus />
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="tel" id="no_tlp" value="" name="no_hp" required
                                            class="form-control" placeholder="202 555 0111" />
                                        <label for="no_tlp">No Tlp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required id="nip" name="nip"
                                        placeholder="" />
                                    <label for="nip">Nip</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea required class="form-control h-px-100" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                                    <label for="alamat">Alamat</label>
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

                $('#deleteForm').attr('action', '/guru/destroy/' + id);
            })
        })
    </script>
@endsection
