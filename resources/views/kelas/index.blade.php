@extends('layouts.app')
@section('title', 'kelas')

@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKelasModal"><i class="mdi mdi-plus"></i>
                Add kelas</button>
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
                <h5 class="card-header">Table kelas</h5>
                @if ($kelas->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Wali kelas</th>
                                    <th>Jumlah siswa</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($kelas as $item)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->code }}</td>
                                        <td>{{ $item->walikelas->name }}</td>
                                        <td>{{ $item->siswa->count() }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editKelasModal" data-id="{{ $item->id }}"
                                                        data-name="{{ $item->name }}" data-code="{{ $item->code }}"
                                                        data-id_wali="{{ $item->id_wali }}" type="button"><i
                                                            class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $item->id }}"><i
                                                            class="mdi mdi-trash-can-outline me-1"></i> Delete</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#modalListSiswa" data-id="{{ $item->id }}"><i
                                                            class="mdi mdi-account-group me-1"></i> Siswa</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 px-2">
                        {{ $kelas->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>


    {{-- modal edit kelas --}}
    <div class="modal fade" id="editKelasModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Edit Kelas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="formEditKelas" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" required id="name"
                                        name="name" autofocus />
                                    <label for="name">Nama kelas</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="tel" id="code" value="" name="code" required
                                            class="form-control" placeholder="202 555 0111" />
                                        <label for="code">Code kelas</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" required name="id_wali" id="id_wali">
                                            <option value="" selected disabled>Select wali kelas</option>
                                            @foreach ($walis as $wali)
                                                <option value="{{ $wali->id }}">{{ $wali->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="id_wali">Wali kelas</label>
                                    </div>
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
            $('#editKelasModal').on('show.bs.modal', function(event) {

                var button = $(event.relatedTarget)

                var id = button.data('id')
                var name = button.data('name')
                var code = button.data('code')
                var id_wali = button.data('id_wali')

                var modal = $(this)

                $('#formEditKelas').attr('action', '/kelas/update/' + id);

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #code').val(code);
                modal.find('.modal-body #id_wali').val(id_wali);

            })
        })
    </script>

    {{-- modal add kelas --}}
    <div class="modal fade" id="addKelasModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add kelas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kelas.store') }}" id="formAddkelas" method="POST" class="hidden">
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="row mt-2 gy-4">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" value="" type="text" required
                                            id="name" name="name" autofocus />
                                        <label for="name">Nama kelas</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="tel" id="code" value="" name="code" required
                                                class="form-control" placeholder="202 555 0111" />
                                            <label for="code">Code kelas</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select" required name="id_wali" id="id_wali">
                                                <option value="" selected disabled>Select wali kelas</option>
                                                @foreach ($walis as $wali)
                                                    <option value="{{ $wali->id }}">{{ $wali->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="id_wali">Wali kelas</label>
                                        </div>
                                    </div>
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

                $('#deleteForm').attr('action', '/kelas/destroy/' + id);
            })
        })
    </script>

    {{-- modal list siswa --}}

    <div class="modal fade" id="modalListSiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Daftar siswa di kelas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Nisn</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="listSiswa">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-primary mb-2" id="addSiswa" type="button"> <i class="mdi mdi-plus"></i> Add
                        siswa</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalAddSiswa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="formAddSiswa" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalTitle">Add Siswa</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf
                    <div class="modal-body">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" disabled value="" type="text" required
                                        id="nameKelas" name="name" autofocus />
                                    <input class="form-control" value="" type="hidden" required id="idKelas"
                                        name="id_kelas" />
                                    <label for="id_kelas">Nama kelas</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <select class="form-select" required name="id_siswa" id="id_siswa">
                                            <option value="" selected disabled>Select siswa</option>
                                            @foreach ($siswa as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="id_siswa">Siswa</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-primary mb-2" type="submit">
                            Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#modalListSiswa').on('show.bs.modal', function(event) {
                var id = $(event.relatedTarget).data('id');

                $('#listSiswa').html('');

                $('#addSiswa').attr('data-id', id);

                $.ajax({
                    type: "GET",
                    url: '/api/kelas/' + id,
                    success: function(response) {
                        let data = response.data;
                        let siswa = data.siswa;

                        $('#addSiswa').attr('data-name', data.name);


                        if (siswa.length > 0) {
                            siswa.map((item, index) => {
                                $('#listSiswa').append(`<tr>
                                    <td>
                                        ${index + 1}
                                    </td>
                                    <td>${item.name}</td>
                                    <td>${item.nisn}</td>
                                    <td>
                                        <a class="dropdown-item" href="/kelas/deleteSiswa/${item.id}"><i class="mdi mdi-trash-can-outline me-1"></i>
                                            Delete</a>
                                    </td>
                                </tr>`)
                            })
                        } else {
                            $('#listSiswa').append(`<tr>
                                    <td colspan="4">
                                        Tidak ada siswa
                                    </td>
                                </tr>`)
                        }
                    }
                })
            })


            $('#addSiswa').on('click', function(e) {
                var id = $('#addSiswa').data('id');
                var name = $('#addSiswa').data('name');

                $('#modalListSiswa').modal('hide');

                $('#modalAddSiswa').modal('show');


                $('#formAddSiswa').attr('action', '/kelas/addSiswa/' + id);


                $('#nameKelas').val(name);
                $('#idKelas').val(id);

            })
        })
    </script>



@endsection
