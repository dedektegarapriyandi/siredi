@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{ $pageTitle }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <!-- Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Tambah Data Antrian</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('antrian.store') }}" method="post">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="id_pasien">Pasien</label>
                                        <select id="patient-select"
                                            class="form-control @error('id_pasien') is-invalid @enderror"
                                            style="width: 100%;" tabindex="-1" aria-hidden="true" name="id_pasien">
                                            <option value="">Cari pasien</option>
                                            @foreach ($patients as $id => $patient)
                                            <option value="{{ $id }}">{{ $id . ' - ' . $patient }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('id_pasien')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    <div class="form-group" data-select2-id="42">
                                        <label for="id_pasien">Poli Tujuan</label>
                                        <select id="poly-select"
                                            class="form-control @error('id_poli') is-invalid @enderror"
                                            style="width: 100%;" tabindex="-1" aria-hidden="true" name="id_poli">
                                            <option value="">Cari poli tujuan</option>
                                            @foreach ($polies as $id => $poly)
                                            <option value="{{ $id }}">{{ $id . ' - ' . $poly }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('id_poli')
                                        <p class="invalid-feedback">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Tambah Ke
                                        Antrian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs mb-3" id="tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="unchecked-patient-tab" data-toggle="pill"
                            href="#unchecked-patient" role="tab" aria-controls="unchecked-patient"
                            aria-selected="true">Belum Diperiksa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="checked-patient-tab" data-toggle="pill" href="#checked-patient"
                            role="tab" aria-controls="checked-patient" aria-selected="false">Sudah Diperiksa</a>
                    </li>
                </ul>

                <div class="tab-content" id="tabContent">
                    {{-- unchecked patient --}}
                    <div class="tab-pane fade active show" id="unchecked-patient" role="tabpanel"
                        aria-labelledby="unchecked-patient-tab">
                        <div id="unchecked_queues_table_wrapper" class="dataTables_wrapper dt-bootstrap4">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info btn-sm mb-2" data-toggle="modal"
                                data-target="#addModal">
                                <i class="fa-solid fa-plus"></i>
                                Tambah Data
                            </button>

                            <div class="row">
                                <div class="col-sm-12">
                                    @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check mr-1"></i>
                                        {!! session('success') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    <table id="unchecked_queues_table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="unchecked_queues_table_info">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Nama Pasien</th>
                                                <th>Poli Tujuan</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Jam Masuk</th>
                                                <th>Status</th>
                                                <th style="width: 200px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($uncheckedQueues as $queue)
                                            <tr class="odd">
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $queue->patient->nama}}</td>
                                                <td>{{ $queue->poly->nama_poli }}</td>
                                                <td>{{ $queue->created_at->format('d M Y')}}</td>
                                                <td>{{ $queue->created_at->format('H:i')}}</td>
                                                <td>{!! $queue->status ? '<span class="badge bg-success">Sudah
                                                        Diperiksa</span>'
                                                    : '<span class="badge bg-secondary">Belum Diperiksa</span>' !!}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-info btn-sm">Action</button>
                                                        <button type="button"
                                                            class="btn btn-info btn-sm dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                            @if ($queue->status === 0)
                                                            <a class="dropdown-item text-info"
                                                                href="{{ route('antrian.check', $queue->id_antrian) }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                Periksa
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            @endif
                                                            <form
                                                                action="{{ route('antrian.destroy', $queue->id_antrian) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- checked patient --}}
                    <div class="tab-pane fade" id="checked-patient" role="tabpanel"
                        aria-labelledby="checked-patient-tab">
                        <div id="checked_queues_table_wrapper" class="dataTables_wrapper dt-bootstrap4">

                            <!-- Button Delete All -->
                            @if ($checkedQueues->count() > 0)
                            <form action="{{ route('antrian.destroyAll') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm mb-2"
                                    onclick="return confirm('Semua data pasien yang sudah diperiksa akan dihapus secara permanen, apakah anda yakin?')">
                                    <i class="fa-solid fa-ban mr-1"></i>
                                    Hapus Seluruh Data Pasien Sudah Diperiksa
                                </button>
                            </form>
                            @endif

                            <div class="row">
                                <div class="col-sm-12">
                                    @if (session()->has('delete_all_success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check mr-1"></i>
                                        {!! session('delete_all_success') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @endif

                                    <table id="checked_queues_table"
                                        class="table table-bordered table-striped dataTable dtr-inline"
                                        aria-describedby="checked_queues_table_info">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Nama Pasien</th>
                                                <th>Poli Tujuan</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Jam Masuk</th>
                                                <th>Status</th>
                                                <th style="width: 200px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($checkedQueues as $queue)
                                            <tr class="odd">
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $queue->patient->nama}}</td>
                                                <td>{{ $queue->poly->nama_poli }}</td>
                                                <td>{{ $queue->created_at->format('d M Y')}}</td>
                                                <td>{{ $queue->created_at->format('H:i')}}</td>
                                                <td>{!! $queue->status ? '<span class="badge bg-success">Sudah
                                                        Diperiksa</span>'
                                                    : '<span class="badge bg-secondary">Belum Diperiksa</span>' !!}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button"
                                                            class="btn btn-info btn-sm">Action</button>
                                                        <button type="button"
                                                            class="btn btn-info btn-sm dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <div class="dropdown-menu" role="menu">
                                                            @if ($queue->status === 0)
                                                            <a class="dropdown-item text-info"
                                                                href="{{ route('antrian.check', $queue->id_antrian) }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                                Periksa
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            @endif
                                                            <form
                                                                action="{{ route('antrian.destroy', $queue->id_antrian) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger"
                                                                    onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                    Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@section('custom_script')
<script>
    @if(count($errors) > 0)
    $('#addModal').modal('show');
    @endif

    $(document).ready(function () {
        $('#poly-select, #patient-select').select2({
            tags: true,
            dropdownParent: $('#addModal')
        });
    });

    $(function () {
        $("#unchecked_queues_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": false,
            "buttons": ["pdf", "print", "colvis"]
        }).buttons().container().appendTo('#unchecked_queues_table_wrapper .col-md-6:eq(0)');
        // $('#example2').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // });
    });

    $(function () {
        $("#checked_queues_table").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "ordering": false,
            "buttons": ["pdf", "print", "colvis"]
        }).buttons().container().appendTo('#checked_queues_table_wrapper .col-md-6:eq(0)');
        // $('#example2').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // });
    });

</script>
@endsection
@endsection
