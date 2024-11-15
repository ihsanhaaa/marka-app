@extends('layouts.app')

@section('title')
    Peta Rambu
@endsection

@section('content')
    @push('css-plugins')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <style>
            .carousel-image {
                width: 100%;
                height: auto;
                max-width: 320px;
                max-height: 320px;
                object-fit: cover;
            }
        </style>
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
                                <h4 class="mb-sm-0">Peta Rambu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Rambu</a></li>
                                        <li class="breadcrumb-item active">Peta</li>
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
                                    <div>
                                        <div id="map" style="width: 100%; height: 500px;"></div>
                                    </div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script>
            // Inisialisasi peta
            const map = L.map('map').setView([-0.05503, 109.3491], 13); // Sesuaikan koordinat pusat peta
    
            // Tambahkan Tile Layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
    
            // Data dari tabel marka_jalans
            const $marka_jalans = @json($marka_jalans);

            const customIcon = L.icon({
                iconUrl: 'warning.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });
    
            // Loop melalui setiap data marka jalan
            $marka_jalans.forEach(marka => {
                // Parsing GeoJSON untuk mendapatkan geometry data
                const geometry = JSON.parse(marka.geojson);
    
                var deleteForm = `
                        <form action="/data-marka-jalan/${marka.id}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="mx-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    `;
    
                // Tambahkan marker atau bentuk lainnya sesuai tipe geometrinya
                if (geometry.type === "Point") {
                    const detailButton = `<a href="{{ url('/data-marka-jalan') }}/${marka.id}" class="btn btn-sm btn-info text-white mx-1" target="_blank"><i class="fas fa-eye"></i> Lihat Detail</a>`;
    
                    if (marka.fotos.length > 0) {
                        // Ambil foto terbaru jika ada
                        pictureUrl = `{{ asset('') }}${marka.fotos[0].foto_path}`; // Hapus 'foto-rambu/' dari sini
                    } else {
                        pictureUrl = 'Tidak ada foto';
                    }
    
                    var popupContent = `
                        <div class="carousel-container mb-3">
                            ${marka.fotos.length === 0 ? '<p class="text-center">Tidak ada foto</p>' : `<img src="${pictureUrl}" class="carousel-image" alt="Foto ${marka.nama_marka}">`}
                        </div>
    
                        <table class="table table-bordered">
                            <tr><th>Nama Marka</th><td>${marka.nama_marka || 'N/A'}</td></tr>
                            <tr><th>Jenis Marka</th><td>${marka.jenis_marka || 'N/A'}</td></tr>
                            <tr><th>Jalur</th><td>${marka.jalur || 'N/A'}</td></tr>
                            <tr><th>Panjang Marka</th><td>${marka.panjang_marka || 'N/A'}</td></tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        ${detailButton}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    `;
    
                    L.marker([geometry.coordinates[1], geometry.coordinates[0]], { icon: customIcon }).addTo(map)
                            .bindPopup(popupContent);
                }
                // Contoh tambahan jika tipe geometri bukan point, misalnya LineString atau Polygon
                else if (geometry.type === "LineString") {
                    L.polyline(geometry.coordinates.map(coord => [coord[1], coord[0]])).addTo(map)
                        .bindPopup(`<strong>Name:</strong> ${marka.nama_marka || 'N/A'}<br>
                                    <strong>Description:</strong> ${marka.deskripsi || 'N/A'}`);
                } else if (geometry.type === "Polygon") {
                    L.polygon(geometry.coordinates[0].map(coord => [coord[1], coord[0]])).addTo(map)
                        .bindPopup(`<strong>Name:</strong> ${marka.nama_marka || 'N/A'}<br>
                                    <strong>Description:</strong> ${marka.deskripsi || 'N/A'}`);
                }
            });

            var layerBatasKecamatanData = @json($kecamatans);
            layerBatasKecamatanData.forEach(data => {
                var geojsonUrl = data.geojson;

                fetch(geojsonUrl)
                .then(response => response.json())
                .then(geojsonData => {
                    // Add GeoJSON layer with popup for each feature
                    L.geoJSON(geojsonData, {
                        style: {
                            color: 'green',
                            weight: 1
                        },
                        onEachFeature: function (feature, layer) {
                            // Get Kecamatan name from properties
                            var kecamatanName = feature.properties.KECAMATAN;

                            // Bind a popup to each feature with the Kecamatan name
                            layer.bindPopup(`<strong>Nama Kecamatan:</strong> ${kecamatanName}`);
                        }
                    }).addTo(map);
                })
                .catch(error => {
                    console.error("Error fetching or processing GeoJSON data:", error);
                });
            });
    
        </script>
    @endpush
@endsection