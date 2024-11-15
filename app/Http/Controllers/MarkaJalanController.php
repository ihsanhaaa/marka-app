<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Kecamatan;
use App\Models\KondisiMarka;
use App\Models\MarkaJalan;
use Illuminate\Http\Request;

class MarkaJalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marka_jalans = MarkaJalan::with('statusMarkaTerbaru', 'kecamatan')->get();

        return view('marka-jalan.index', compact('marka_jalans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json,geojson',
        ]);

        $geojsonFile = $request->file('file');
        $data = json_decode(file_get_contents($geojsonFile->getRealPath()), true);

        foreach ($data['features'] as $feature) {
            $properties = $feature['properties'];
            $geometry = $feature['geometry'];

            MarkaJalan::create([
                'nama_marka' => $properties['Name'] ?? null,
                'deskripsi' => $properties['descriptio'] ?? null,
                'tahun_pembuatan' => $properties['timestamp'] ?? null,
                'geojson' => json_encode($geometry),
            ]);
        }

        return redirect()->back()->with('success', 'GeoJSON berhasil disimpan dan di parsing.');
    }

    public function storeKondisiMarka(Request $request, $id)
    {
        $request->validate([
            'tgl_temuan' => 'required|date',
            'status_marka' => 'required',
            'kondisi_marka' => 'required',
            'deskripsi' => 'nullable|string'
        ]);

        $marka_jalan = MarkaJalan::findOrFail($id);

        // Buat instance Status baru
        $status = new KondisiMarka();
        $status->marka_jalan_id = $marka_jalan->id;
        $status->tgl_temuan = $request->tgl_temuan;
        $status->status_marka = $request->status_marka;
        $status->kondisi_marka = $request->kondisi_marka;
        $status->deskripsi = $request->deskripsi;
        $status->save();

        return redirect()->back()->with('success', 'Data status Marka Jalan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marka_jalan = MarkaJalan::findOrFail($id);

        return view('marka-jalan.show', compact('marka_jalan'));
    }

    public function showMap()
    {
        $marka_jalans = MarkaJalan::with(['fotos' => function($query) {
            $query->latest()->take(1);
        }])->get();

        $kecamatans = Kecamatan::all();

        // dd($marka_jalans);

        return view('marka-jalan.map', compact('marka_jalans', 'kecamatans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $marka_jalan = MarkaJalan::findOrFail($id);
        $kecamatans = Kecamatan::all();
        
        return view('marka-jalan.edit', compact('marka_jalan', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_marka' => 'required|string|max:255',
            'jenis_marka' => 'nullable|string|max:255',
            'panjang_jalan' => 'nullable|string|max:255',
            'jalur' => 'nullable|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:255',
            'panjang_marka' => 'nullable|string|max:255',
            'kecamatan_id' => 'required|exists:kecamatans,id',
        ]);

        $marka_jalan = MarkaJalan::findOrFail($id);

        $marka_jalan->update([
            'nama_marka' => $request->nama_marka,
            'jenis_marka' => $request->jenis_marka,
            'panjang_jalan' => $request->panjang_jalan,
            'jalur' => $request->jalur,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'panjang_marka' => $request->panjang_marka,
            'kecamatan_id' => $request->kecamatan_id,
        ]);

        return redirect()->route('data-marka-jalan.show', $id)->with('success', 'Data Marka Jalan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marka_jalan = MarkaJalan::findOrFail($id);
        $marka_jalan->delete();

        return redirect()->route('data-marka-jalan.peta')->with('success', 'Data berhasil dihapus.');
    }

    public function uploadPhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $file = $request->file('photo');

        if ($file) {
            // Menentukan path untuk penyimpanan
            $path = 'foto-marka-jalan/';
            $new_name = 'marka-jalan-' . $id . '-' . date('Ymd') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
    
            // Memindahkan file ke folder yang ditentukan
            $file->move(public_path($path), $new_name);
    
            // Menyimpan path ke database
            Foto::create([
                'marka_jalan_id' => $id,
                'foto_path' => $path . $new_name
            ]);
    
            return response()->json(['message' => 'Foto berhasil diunggah.']);
        }

        return response()->json(['message' => 'Gagal mengunggah foto.'], 500);
    }

    public function uploadPhotoDetail(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $marka_jalan = MarkaJalan::findOrFail($id);
        
        // Proses setiap file yang diunggah
        foreach ($request->file('photo') as $file) {
            // Menentukan path dan nama unik untuk setiap file
            $path = 'foto-marka-jalan/';
            $new_name = 'marka-jalan-' . $id . '-' . date('Ymd') . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        
            // Memindahkan file ke folder yang ditentukan
            $file->move(public_path($path), $new_name);
        
            // Menyimpan path ke database
            Foto::create([
                'marka_jalan_id' => $id,
                'foto_path' => $path . $new_name
            ]);
        }
    
        return redirect()->route('data-marka-jalan.show', $marka_jalan->id)->with('success', 'Foto berhasil diupload');
    }
}
