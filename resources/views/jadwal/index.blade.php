@extends('layouts.app')
@section('title', 'jadwal')

@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addjadwalModal"><i class="mdi mdi-plus"></i>
                Add jadwal</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-lg-12">
            <form action="" class="d-flex justify-content-between gap-2">
                <input type="text" class="form-control" name="search" placeholder="Search...">
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-magnify"></i></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Table jadwal</h5>
                @if ($jadwals->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mapel</th>
                                    <th>Kelas</th>
                                    <th>Guru</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($jadwals as $jadwal)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $jadwal->mapel->mapel }}</td>
                                        <td>{{ $jadwal->kelas->code }}</td>
                                        <td>{{ $jadwal->guru->name }}</td>
                                        <td>{{ $jadwal->hari }}</td>
                                        <td>{{ Str::limit($jadwal->jam_mulai, 5) }} -
                                            {{ Str::limit($jadwal->jam_selesai, 5) }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editjadwalModal" data-id="{{ $jadwal->id }}"
                                                        type="button"><i class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $jadwal->id }}"><i
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
                        {{ $jadwals->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>







    {{-- modal add jadwal --}}
    <div class="modal fade" id="addjadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add jadwal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jadwal.store') }}" id="formAddjadwal" method="POST" class="hidden">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_mapel" id="id_mapel" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($mapels as $mapel)
                                            <option value="{{ $mapel->id }}">{{ $mapel->mapel }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_mapel">Mapel</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_guru" id="id_guru" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($guru as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_guru">Guru</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_kelas" id="id_kelas" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_kelas">Kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="hari" id="hari" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($hari as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <label for="hari">Hari</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="time" class="form-control" name="jam_mulai" id="jam_mulai" required>
                                    <label for="jam_mulai">Jam mulai</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="time" class="form-control" name="jam_selesai" id="jam_selesai"
                                        required>
                                    <label for="jam_selesai">Jam selesai</label>
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

                $('#deleteForm').attr('action', '/jadwal/destroy/' + id);
            })
        })
    </script>


    <div class="modal fade" id="editjadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">edit jadwal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="formEditjadwal" method="POST" class="hidden">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_mapel" id="update_id_mapel" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($mapels as $mapel)
                                            <option value="{{ $mapel->id }}">{{ $mapel->mapel }}</option>
                                        @endforeach
                                    </select>
                                    <label for="update_id_mapel">Mapel</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_guru" id="update_id_guru" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($guru as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="update_id_guru">Guru</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_kelas" id="update_id_kelas" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->id }}">{{ $item->code }}</option>
                                        @endforeach
                                    </select>
                                    <label for="update_id_kelas">Kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select name="hari" id="update_hari" required class="form-select">
                                        <option value="" disabled selected>Select mapel</option>
                                        @foreach ($hari as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <label for="update_hari">Hari</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="time" class="form-control" name="jam_mulai" id="update_jam_mulai"
                                        required>
                                    <label for="update_jam_mulai">Jam mulai</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="time" class="form-control" name="jam_selesai"
                                        id="update_jam_selesai" required>
                                    <label for="update_jam_selesai">Jam selesai</label>
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

    <script>
        $(document).ready(function() {
            $('#editjadwalModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');


                $('#formEditjadwal').attr('action', '/jadwal/update/' + id);

                $.ajax({
                    type: "GET",
                    url: '/api/jadwal/' + id,
                    success: function(response) {
                        let data = response.data;

                        $('#update_id_mapel').val(data.id_mapel);
                        $('#update_id_guru').val(data.id_guru);
                        $('#update_id_kelas').val(data.id_kelas);
                        $('#update_hari').val(data.hari);
                        $('#update_jam_mulai').val(data.jam_mulai);
                        $('#update_jam_selesai').val(data.jam_selesai);
                    }
                })
            })
        })
    </script>


@endsection
