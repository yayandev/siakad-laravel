@extends('layouts.app')
@section('title', 'Absensi')
@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="mdi mdi-plus"></i>
                Add Absensi</button>
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
                <h5 class="card-header">Table Absensi</h5>
                @if ($absensi->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Siswa</th>
                                    <th>Mapel</th>
                                    <th>Tahun Akademik</th>
                                    <th>Semester</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($absensi as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $item->siswa->name }}</td>
                                        <td>{{ $item->mapel->mapel }}</td>
                                        <td>{{ $item->tahun_akademik->tahun_akademik }}</td>
                                        <td>{{ $item->semester->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editModal" data-id="{{ $item->id }}"
                                                        data-tahun_akademik="{{ $item->tahun_akademik }}" type="button"><i
                                                            class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $item->id }}"><i
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
                        {{ $absensi->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="formDelete" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Konfirmasi!</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-2">
                                <h3>Apakah anda yakin ingin menghapus data ini?</h3>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Tidak
                        </button>
                        <button type="submit" class="btn btn-primary">IYa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')

                var modal = $(this)

                modal.find('#formDelete').attr('action', '/absensi/destroy/' + id)
            })
        })
    </script>

    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Add Absensi</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_siswa" id="id_siswa" class="form-select" required>
                                        <option value="" disabled selected>Select Siswa</option>
                                        @foreach ($siswa as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_siswa">Absensi</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_mapel" id="id_mapel" class="form-select" required>
                                        <option value="" disabled selected>Select Mapel</option>
                                        @foreach ($mapel as $item)
                                            <option value="{{ $item->id }}">{{ $item->mapel }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_mapel">Mata pelajaran</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_tahun_akademik" id="id_tahun_akademik" class="form-select" required>
                                        <option value="" disabled selected>Select tahun akademik</option>
                                        @foreach ($tahun_akademik as $item)
                                            <option value="{{ $item->id }}">{{ $item->tahun_akademik }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_tahun_akademik">Tahun akademik</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <select name="id_semester" id="id_semester" class="form-select" required>
                                        <option value="" disabled selected>Select semester</option>
                                        @foreach ($semester as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="id_semester">Tahun akademik</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" name="hadir" id="hadir"
                                        placeholder="Masukan jumlah hadir">
                                    <label for="hadir">Jumlah hadir</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" name="alpa" id="alpa"
                                        placeholder="Masukan jumlah alpa">
                                    <label for="alpa">Jumlah alpa</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" name="sakit" id="sakit"
                                        placeholder="Masukan jumlah sakit">
                                    <label for="sakit">Jumlah sakit</label>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" name="ijin" id="ijin"
                                        placeholder="Masukan jumlah ijin">
                                    <label for="ijin">Jumlah ijin</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="formEdit" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Add Semester</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-2">
                            <div class="col mb-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" required id="update_absensi" name="absensi"
                                        class="form-control" placeholder="Enter year" />
                                    <label for="update_absensi">Absensi</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#editModal').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                var absensi = $(e.relatedTarget).data('absensi');
                var id_semester = $(e.relatedTarget).data('id_semester');

                $('#formEdit').attr('action', '/absensi/update/' + id);

                $('#update_absensi').val(absensi);

            })
        })
    </script>
@endSection
