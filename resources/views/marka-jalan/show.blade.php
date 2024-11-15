@extends('layouts.app')

@section('title')
    Detail Rambu
@endsection

@section('content')
    @push('css-plugins')
        <!-- Lightbox css -->
        <link href="assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    @endpush

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- header -->
        @include('components.navbar_admin')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Detail Rambu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Rambu</a></li>
                                        <li class="breadcrumb-item active">Detail Rambu</li>
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
                        <div class="col-3">
                            <div class="card">
                                <div class="card-body">

                                    <form action="{{ route('data-marka-jalan.uploadFotos', $marka_jalan->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Tambah Foto</label>
                                            <input class="form-control" type="file" name="photo[]" id="photo" accept="image/*" multiple required>
                                        </div>
                                        <button type="submit" class="btn btn-primary mb-2 btn-sm">Upload Foto</button>
                                    </form>
                                    
                                    <div class="zoom-gallery">

                                        @if($marka_jalan->fotos && $marka_jalan->fotos->isNotEmpty())
                                            @foreach($marka_jalan->fotos as $foto)
                                                <a class="float-start my-2" href="{{ asset($foto->foto_path) }}" title="{{ $marka_jalan->nama_marka }}"><img src="{{ asset($foto->foto_path) }}" alt="img-3" width="350"></a>
                                            @endforeach
                                        @else
                                            <p>Tidak ada foto tersedia.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-9">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="invoice-title">
                                                
                                                <h3>
                                                    <i class="fas fa-clone"></i> 
                                                </h3>
                                            </div>
                                            <hr>
                                            
                                            <div class="row">
                                                <div class="d-flex mb-3">
                                                    <a href="{{ route('data-marka-jalan.edit', $marka_jalan->id) }}" class="btn btn-warning waves-effect waves-light"><i class="fas fa-edit"></i> Edit</a>
    
                                                    <form id="input"
                                                        action="{{ route('data-marka-jalan.destroy', $marka_jalan->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border: none;" class="btn btn-danger waves-effect waves-light ms-2"><i class="fas fa-trash-alt"></i> Hapus</button>
                                                    </form>
                                                </div>
                                                <div class="row-12">
                                                    <h4 class="font-size-18"><strong>{{ $marka_jalan->nama_marka }}</strong></h4>
                                                    <strong>Jenis Marka: {{ $marka_jalan->jenis_marka ?? '-' }}</strong><br>
                                                    <strong>Jalur: {{ $marka_jalan->jalur ?? '-' }}</strong><br>
                                                    <strong>Panjang Jalan: {{ $marka_jalan->panjang_jalan ?? '-' }}</strong><br>
                                                    <strong>Tahun Pembuatan: {{ $marka_jalan->tahun_pembuatan ?? '-' }}</strong><br>
                                                    <strong>Kecamatan: {{ $marka_jalan->kecamatan->nama_kecamatan ?? '-' }}</strong><br>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="font-size-18 mt-4"><strong>Status Marka</strong></h4>

                                        <div>
                                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#statusModal"><i class="fas fa-plus"></i> Tambah Data Rambu</button>
                                            
                                            <!-- First modal dialog -->
                                            <div class="modal fade" id="statusModal" aria-hidden="true" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tambah Status Marka</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('data-marka-jalan.storeKondisi', $marka_jalan->id) }}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="tgl_temuan" class="col-form-label">Tanggal Temuan</label>
                                                                    <input class="form-control @error('tgl_temuan') is-invalid @enderror" type="date" id="tgl_temuan" name="tgl_temuan" value="{{ old('tgl_temuan', $marka_jalan->tgl_temuan ?? '') }}" required>
                                                                    @error('tgl_temuan')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="status_marka" class="col-form-label">Status Marka</label>
                                                                    <input class="form-control @error('status_marka') is-invalid @enderror" type="text" id="status_marka" name="status_marka" value="{{ old('status_marka', $marka_jalan->status_marka ?? '') }}">
                                                                    @error('status_marka')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                    
                                                                <div class="mb-3">
                                                                    <label for="kondisi_marka" class="col-form-label">Kondisi Marka</label>
                                                                    <select class="form-control @error('kondisi_marka') is-invalid @enderror" id="kondisi_marka" name="kondisi_marka" required>
                                                                        <option value="">-- Pilih Kondisi Marka --</option>
                                                                        <option value="Baik">Baik</option>
                                                                        <option value="Rusak Ringan">Rusak Ringan</option>
                                                                        <option value="Rusak Berat">Rusak Berat</option>
                                                                    </select>
                                                                    @error('kondisi_marka')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                    <label for="deskripsi" class="col-form-label">Keterangan</label>
                                                                    <input class="form-control @error('deskripsi') is-invalid @enderror" type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $marka_jalan->deskripsi ?? '') }}">
                                                                    @error('deskripsi')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>Tanggal Temuan</th>
                                                <th>Status Marka</th>
                                                <th>Kondisi Marka</th>
                                                <th>Keterangan</th>
                                            </tr>
                                            </thead>
        
    
                                            <tbody>
                                            @foreach ($marka_jalan->statuses as $status)
                                                <tr>
                                                    <td>{{ $status->tgl_temuan }}</td>
                                                    <td>{{ $status->status_marka }}</td>
                                                    <td>{{ $status->kondisi_marka }}</td>
                                                    <td>{{ $status->deskripsi }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

        </div>
        <!-- end main content-->

        <!-- footer -->
        @include('components.footer_admin')

    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    @push('javascript-plugins')
        <!-- Magnific Popup-->
        <script src="assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- lightbox init js-->
        <script src="assets/js/pages/lightbox.init.js"></script>
    @endpush
@endsection
