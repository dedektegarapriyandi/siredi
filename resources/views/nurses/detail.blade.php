@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation mr-1"></i>
            @foreach ($errors->all() as $error)
            {{ $error }}
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check mr-1"></i>
            {!! session('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <label for="file-input">
                        @if ($nurse->photo)
                        <img class="profile-user-img img-fluid img-circle" style="cursor: pointer"
                            src="{{ asset($nurse->photo) }}" alt="User profile picture">
                        @else
                        <img class="profile-user-img img-fluid img-circle" style="cursor: pointer"
                            src="{{ asset('img/nurse-img.png') }}" alt="User profile picture">
                        @endif
                    </label>
                    <form action="{{ route('perawat.update', $nurse->id_perawat) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" id="file-input" class="d-none" onchange="this.form.submit()" name="photo">
                    </form>
                </div>

                <h3 class="profile-username text-center">{{ $nurse->nama }}</h3>

                <p class="text-muted text-center">Perawat</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $nurse->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>No Hp</b> <a class="float-right">{{ $nurse->no_hp }}</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('perawat.destroy', $nurse->id_perawat) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block btn-sm"
                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                <i class="fa-solid fa-trash mr-1"></i>
                                Hapus Data
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Detail</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <strong><i class="fas fa-calendar-days mr-1"></i> Tanggal lahir</strong>
                <p class="text-muted">{{ $nurse->tgl_lahir }}</p>
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Tempat lahir</strong>
                <p class="text-muted">{{ $nurse->tempat_lahir }}</p>
                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                <p class="text-muted">{{ $nurse->alamat }}</p>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            {{-- update account --}}
            <div class="col-md-12">
                @if ($errors->any())
                <div class="card card-info">
                    @else
                    <div class="card card-info collapsed-card">
                        @endif
                        <div class="card-header">
                            <h3 class="card-title">Ubah Password</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="display: @error('password') block @enderror">
                            <form class="form-horizontal" method="POST"
                                action="{{ route('user.update', $nurse->user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text"
                                                class="form-control form-control-sm @error('username') is-invalid @enderror"
                                                id="username" value="{{ $nurse->user->username }}" name="username"
                                                readonly>
                                            @error('username')
                                            <p class="invalid-feedback">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password"
                                                class="form-control form-control-sm @error('password') is-invalid @enderror"
                                                id="password" placeholder="Password Baru" name="password">
                                            @error('password')
                                            <p class="invalid-feedback">
                                                {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info btn-sm"
                                        onclick="return confirm('Anda yakin ingin mengubah password ini?')">Update
                                        Password</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            {{-- update data --}}
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('perawat.update', $nurse->id_perawat) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama', $nurse->nama) }}" placeholder="Nama">
                            @error('nama')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"" id=" email"
                                name="email" value="{{ old('email', $nurse->email) }}" placeholder="Email">
                            @error('email')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No Hp</label>
                            <input type="number" class="form-control @error('no_hp') is-invalid @enderror"" id=" no_hp"
                                name="no_hp" value="{{ old('no_hp', $nurse->no_hp) }}" placeholder="No Hp">
                            @error('no_hp')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror"" id="
                                tgl_lahir" value="{{ old('tgl_lahir', $nurse->tgl_lahir) }}" name="tgl_lahir">
                            @error('tgl_lahir')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"" id="
                                tempat_lahir" value="{{ old('tempat_lahir', $nurse->tempat_lahir) }}"
                                name="tempat_lahir" placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat"
                                class="form-control @error('alamat') is-invalid @enderror"" rows=" 3"
                                placeholder="Alamat">{{ old('alamat', $nurse->alamat) }}</textarea>
                            @error('alamat')
                            <p class="invalid-feedback">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
