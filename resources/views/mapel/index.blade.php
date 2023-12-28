@extends('layouts.app')
@section('title', 'Mapel')

@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmapelModal"><i class="mdi mdi-plus"></i>
                Add mapel</button>
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
                <h5 class="card-header">Table mapel</h5>
                @if ($mapels->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mapel</th>
                                    <th>Jumlah Jadwal</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($mapels as $mapel)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $mapel->mapel }}</td>
                                        <td>{{ $mapel->jadwal->count() }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editMapelModal" data-mapel="{{ $mapel->mapel }}"
                                                        data-id="{{ $mapel->id }}" type="button"><i
                                                            class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $mapel->id }}"><i
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
                        {{ $mapels->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>


    {{-- modal edit mapel --}}
    <div class="modal fade" id="editMapelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Edit mapel</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" id="formEditmapel" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" required id="mapelUpdate"
                                        name="mapel" autofocus />
                                    <label for="mapel">Mapel</label>
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
            $('#editMapelModal').on('show.bs.modal', function(e) {
                var mapel = $(e.relatedTarget).data('mapel');
                var id = $(e.relatedTarget).data('id');


                $('#formEditmapel').attr('action', '/mapel/update/' + id);
                $('#mapelUpdate').val(mapel);
            })
        })
    </script>



    {{-- modal add mapel --}}
    <div class="modal fade" id="addmapelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add mapel</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('mapel.store') }}" id="formAddmapel" method="POST" class="hidden">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" required id="mapel"
                                        name="mapel" autofocus />
                                    <label for="mapel">Mapel</label>
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

                $('#deleteForm').attr('action', '/mapel/destroy/' + id);
            })
        })
    </script>
@endsection
