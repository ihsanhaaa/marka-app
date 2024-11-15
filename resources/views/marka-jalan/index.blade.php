@extends('layouts.app')

@section('title')
    Data Rambu
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
                                <h4 class="mb-sm-0">Data Rambu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Rambu</a></li>
                                        <li class="breadcrumb-item active">Data Rambu</li>
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

                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="fas fa-plus"></i> Tambah Data Rambu</button>
                                
                                <!-- First modal dialog -->
                                <div class="modal fade" id="uploadModal" aria-hidden="true" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Upload file geojson</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('data-marka-jalan.store') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <input class="form-control" type="file" name="file" accept=".geojson" required>
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

                            <div class="card">
                                <div class="card-body">
        
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Marka</th>
                                            <th>Jenis Marka</th>
                                            <th>Jalur</th>
                                            <th>Kecamatan</th>
                                            <th>Tahun Pembuatan</th>
                                            <th>Kondisi Marka</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
    

                                        <tbody>
                                        @foreach ($marka_jalans as $key => $marka_jalan)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $marka_jalan->nama_marka }}</td>
                                                <td>{{ $marka_jalan->jenis_marka }}</td>
                                                <td>{{ $marka_jalan->jalur }}</td>
                                                <td>{{ $marka_jalan->kecamatan->nama_kecamatan ?? ' ' }}</td>
                                                <td>{{ $marka_jalan->tahun_pembuatan }}</td>
                                                <td>{{ $marka_jalan->statusMarkaTerbaru->kondisi_marka ?? 'Kondisi marka jalan tidak tersedia' }}</td>
                                                <td>
                                                    <a href="{{ route('data-marka-jalan.show', $marka_jalan->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> lihat Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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