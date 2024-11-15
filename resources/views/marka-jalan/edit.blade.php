@extends('layouts.app')

@section('title')
    Edit Data Rambu
@endsection

@section('content')
    @push('css-plugins')
        
    @endpush

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- header -->
        @include('components.navbar_admin')
        
        <!-- Start right Content here -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Edit Data Rambu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('data-marka-jalan.index') }}">Rambu</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Detail Rambu</a></li>
                                        <li class="breadcrumb-item active">Edit Rambu</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <strong>{{ $error }}</strong><br>
                            @endforeach
                        </div>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>Success!</strong> {{ $message }}.
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">
        
                                    <h4 class="card-title">Edit Data Rambu {{ $marka_jalan->nama_marka }}</h4>

                                    <form action="{{ route('data-marka-jalan.update', $marka_jalan->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="row mb-3">
                                            <label for="nama_marka" class="col-sm-2 col-form-label">Nama Marka</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('nama_marka') is-invalid @enderror" type="text" id="nama_marka" name="nama_marka" value="{{ old('nama_marka', $marka_jalan->nama_marka ?? '') }}" required>
                                                @error('nama_marka')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="jenis_marka" class="col-sm-2 col-form-label">Jenis Marka</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('jenis_marka') is-invalid @enderror" type="text" id="jenis_marka" name="jenis_marka" value="{{ old('jenis_marka', $marka_jalan->jenis_marka ?? '') }}" required>
                                                @error('jenis_marka')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="panjang_jalan" class="col-sm-2 col-form-label">Panjang Jalan</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('panjang_jalan') is-invalid @enderror" type="text" id="panjang_jalan" name="panjang_jalan" value="{{ old('panjang_jalan', $marka_jalan->panjang_jalan ?? '') }}" required>
                                                @error('panjang_jalan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="jalur" class="col-sm-2 col-form-label">Jalur</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('jalur') is-invalid @enderror" type="text" id="jalur" name="jalur" value="{{ old('jalur', $marka_jalan->jalur ?? '') }}" required>
                                                @error('jalur')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="tahun_pembuatan" class="col-sm-2 col-form-label">Tahun Pembuatan</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('tahun_pembuatan') is-invalid @enderror" type="date" id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan', $marka_jalan->tahun_pembuatan ?? '') }}" required>
                                                @error('tahun_pembuatan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="panjang_marka" class="col-sm-2 col-form-label">Panjang Marka</label>
                                            <div class="col-sm-10">
                                                <input class="form-control @error('panjang_marka') is-invalid @enderror" type="text" id="panjang_marka" name="panjang_marka" value="{{ old('panjang_marka', $marka_jalan->panjang_marka ?? '') }}" required>
                                                @error('panjang_marka')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="kecamatan_id" class="col-sm-2 col-form-label">Kecamatan</label>
                                            <div class="col-sm-10">
                                                <select class="form-control @error('kecamatan_id') is-invalid @enderror" id="kecamatan_id" name="kecamatan_id" required>
                                                    <option value="">-- Pilih Kecamatan --</option>
                                                    @foreach($kecamatans as $kecamatan)
                                                        <option value="{{ $kecamatan->id }}" {{ old('kecamatan_id', $marka_jalan->kecamatan_id ?? '') == $kecamatan->id ? 'selected' : '' }}>
                                                            {{ $kecamatan->nama_kecamatan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('kecamatan_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Data Rambu</button>
                                    </form>


                                </div>
                            </div> 
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                
            </div>
            <!-- End Page-content -->
           
            <!-- footer -->
            @include('components.footer_admin')
            
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @push('javascript-plugins')
        
    @endpush
@endsection