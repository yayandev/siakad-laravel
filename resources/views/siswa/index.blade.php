@extends('layouts.app')
@section('title', 'Siswa')

@section('content')
    <div class="row mb-2">
        <div class="col-lg-12">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSiswaModal"><i class="mdi mdi-plus"></i>
                Add siswa</button>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-lg-12">
            <form action="" class="d-flex justify-content-between gap-2">
                <input type="text" class="form-control" name="search" placeholder="Nisn...">
                <button type="submit" class="btn btn-primary"><i class="mdi mdi-magnify"></i></button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h5 class="card-header">Table siswa</h5>
                @if ($siswas->count() > 0)
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Kelas</th>
                                    <th>Nisn</th>
                                    <th>Nis</th>
                                    <th>Ayah</th>
                                    <th>Ibu</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($siswas as $siswa)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $siswa->name }}</td>
                                        <td>
                                            @if ($siswa->kelas)
                                                {{ $siswa->kelas->name }}
                                            @else
                                                <span class="badge bg-danger">Belum ada kelas</span>
                                            @endif
                                        </td>
                                        <td>{{ $siswa->nisn }}</td>
                                        <td>{{ $siswa->nis }}</td>
                                        <td>{{ $siswa->ayah }}</td>
                                        <td>{{ $siswa->ibu }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <button class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editSiswaModal" data-id="{{ $siswa->id }}"
                                                        type="button"><i class="mdi mdi-pencil-outline me-1"></i>
                                                        Edit</button>
                                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal" data-id="{{ $siswa->id }}"><i
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
                        {{ $siswas->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <p class="text-center">No data</p>
                @endif
            </div>
        </div>
    </div>


    {{-- modal edit siswa --}}
    <div class="modal fade" id="editSiswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Biodata siswa</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="loader" class="d-flex justify-content-center p-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form action="" id="formEditSiswa" method="POST" class="hidden">
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
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="tel" id="no_tlp" value="" name="no_telp" required
                                            class="form-control" placeholder="202 555 0111" />
                                        <label for="no_tlp">No Tlp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required id="nisn" name="nisn"
                                        placeholder="" />
                                    <label for="nisn">Nisn</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" value="" required id="nis"
                                        name="nis" placeholder="" readonly />
                                    <label for="nis">Nis</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" value="" required id="nik"
                                        name="nik" placeholder="California" />
                                    <label for="nik">Nik</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="jk" name="jk" required class="select2 form-select">
                                        <option disabled selected value="">Select</option>
                                        <option value="laki-laki">
                                            laki-laki</option>
                                        <option value="perempuan">
                                            perempuan</option>
                                    </select>
                                    <label for="jk">Jenis kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" required type="text" id="tempat_lahir"
                                        name="tempat_lahir" placeholder="California" />
                                    <label for="tempat_lahir">Tempat lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" required value="" class="form-control" id="tgl_lahir"
                                        name="tgl_lahir" placeholder="231465" />
                                    <label for="tgl_lahir">Tanggal lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" id="ayah"
                                        name="ayah" required placeholder="joko" />
                                    <label for="ayah">Ayah</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" required type="text" id="ibu"
                                        name="ibu" placeholder="joko" />
                                    <label for="ibu">Ibu</label>
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
            $('#editSiswaModal').on('show.bs.modal', function(event) {


                var button = $(event.relatedTarget)

                var id = button.data('id')

                var modal = $(this)

                $('#loader').removeClass('d-none');
                $('#formEditSiswa').addClass('d-none');

                $('#formEditSiswa').attr('action', '/siswa/update/' + id)

                $.ajax({
                    type: "GET",
                    url: "/api/siswa/" + id,
                    success: function(response) {

                        $('#name').val(response.data.name)
                        $('#nisn').val(response.data.nisn)
                        $('#nis').val(response.data.nis)
                        $('#nik').val(response.data.nik)
                        $('#jk').val(response.data.jk)
                        $('#tempat_lahir').val(response.data.tempat_lahir)
                        $('#tgl_lahir').val(response.data.tgl_lahir)
                        $('#ayah').val(response.data.ayah)
                        $('#ibu').val(response.data.ibu)
                        $('#alamat').val(response.data.alamat)
                        $('#no_tlp').val(response.data.no_telp)


                        $('#loader').addClass('d-none');
                        $('#formEditSiswa').removeClass('d-none');
                    },
                    error: function(response) {
                        console.log('Error:', response)
                    }

                });

            })
        })
    </script>

    {{-- modal add siswa --}}
    <div class="modal fade" id="addSiswaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel1">Add siswa</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('siswa.store') }}" id="formAddSiswa" method="POST" class="hidden">
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
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="tel" id="no_tlp" value="" name="no_telp" required
                                            class="form-control" placeholder="202 555 0111" />
                                        <label for="no_tlp">No Tlp</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="email" id="email" value="" name="email" required
                                            class="form-control" placeholder="john@example.com" />
                                        <label for="email">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" required id="nisn" name="nisn"
                                        placeholder="" />
                                    <label for="nisn">Nisn</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="number" value="" required id="nik"
                                        name="nik" placeholder="California" />
                                    <label for="nik">Nik</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <select id="jk" name="jk" required class="select2 form-select">
                                        <option disabled selected value="">Select</option>
                                        <option value="laki-laki">
                                            laki-laki</option>
                                        <option value="perempuan">
                                            perempuan</option>
                                    </select>
                                    <label for="jk">Jenis kelamin</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" required type="text" id="tempat_lahir"
                                        name="tempat_lahir" placeholder="California" />
                                    <label for="tempat_lahir">Tempat lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="date" required value="" class="form-control" id="tgl_lahir"
                                        name="tgl_lahir" placeholder="231465" />
                                    <label for="tgl_lahir">Tanggal lahir</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" type="text" id="ayah"
                                        name="ayah" required placeholder="joko" />
                                    <label for="ayah">Ayah</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" value="" required type="text" id="ibu"
                                        name="ibu" placeholder="joko" />
                                    <label for="ibu">Ibu</label>
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

                $('#deleteForm').attr('action', '/siswa/destroy/' + id);
            })
        })
    </script>
@endsection
