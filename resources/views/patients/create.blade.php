@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Data Pasien</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="no_bpjs">No BPJS <small>(Optional)</small></label>
                        <input type="number" class="form-control @error('no_bpjs') is-invalid @enderror" id="no_bpjs"
                            placeholder="No BPJS" name="no_bpjs" value="{{ old('no_bpjs') }}">
                        @error('no_bpjs')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            placeholder="Nama" name="nama" value="{{ old('nama') }}">
                        @error('nama')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                            name="jenis_kelamin">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="pria" {{ old('jenis_kelamin') == 'pria' ? 'selected' : '' }}>Pria</option>
                            <option value="wanita" {{ old('jenis_kelamin') == 'wanita' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                        @error('jenis_kelamin')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir"
                            name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                        @error('tgl_lahir')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                            id="tempat_lahir" placeholder="Tempat Lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}">
                        @error('tempat_lahir')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_hp">No Hp</label>
                        <input type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                            placeholder="No Hp" name="no_hp" value="{{ old('no_hp') }}">
                        @error('no_hp')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror"
                            rows="3" placeholder="Alamat" name="alamat">{{ old('alamat') }}</textarea>
                        @error('alamat')
                        <p class="invalid-feedback">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="berat_badan">Berat Badan (kg)</label>
                                <input type="number" class="form-control @error('berat_badan') is-invalid @enderror"
                                    id="berat_badan" placeholder="Berat Badan" name="berat_badan">
                                @error('berat_badan')
                                <p class="invalid-feedback">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="tinggi_badan">Tinggi Badan (cm)</label>
                                <input type="number" class="form-control @error('tinggi_badan') is-invalid @enderror"
                                    id="tinggi_badan" placeholder="Tinggi Badan" name="tinggi_badan">
                                @error('tinggi_badan')
                                <p class="invalid-feedback">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
