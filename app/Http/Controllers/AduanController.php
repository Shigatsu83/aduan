<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aduan;

class AduanController extends Controller
{
    public function index()
    {
        $aduan = Aduan::first();
        $recentAduans = Aduan::orderBy('created_at', 'desc')->take(3)->get();
        $totalAduans = Aduan::count();
        $aduanSelesai = Aduan::where('status', 'Selesai')->count();
        $aduanDiproses = Aduan::where('status', 'Sedang Diproses')->count();
        return view("aduan.index", compact("aduan", 'recentAduans', 'totalAduans', 'aduanSelesai', 'aduanDiproses'));

    }

    public function create(){
        return view("aduan.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'jenis' => 'required|string|max:50',
            'lokasi' => 'required|string|max:255',
            'lampiran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB per file
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
        }

        $aduan = new Aduan();
        $aduan->judul = $validated['judul'];
        $aduan->isi = $validated['isi'];
        $aduan->jenis = $validated['jenis'];
        $aduan->lokasi = $validated['lokasi'];
        $aduan->lampiran = $lampiranPath;
        $aduan->status = 'Pending';
        $aduan->save();

        return redirect()->route('aduan.create')->with('success', 'Aduan berhasil dikirim!');
    }
    
    /**
     * Menampilkan halaman pencarian aduan
     */
    public function search(Request $request)
    {
        $query = Aduan::where('is_public', true)->latest();
        
        // Filter berdasarkan kata kunci jika ada
        if ($request->has('keyword') && $request->keyword) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('isi', 'like', "%{$keyword}%");
            });
        }
        
        // Filter berdasarkan jenis aduan jika ada
        if ($request->has('jenis') && $request->jenis) {
            $query->where('jenis', $request->jenis);
        }
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $aduans = $query->paginate(9);
        
        // Mendapatkan daftar jenis aduan untuk filter
        $jenisAduan = [
            'Infrastruktur' => 'Infrastruktur',
            'Lingkungan' => 'Lingkungan',
            'Pelayanan Publik' => 'Pelayanan Publik',
            'Keamanan' => 'Keamanan',
            'Lainnya' => 'Lainnya',
        ];
        
        return view('aduan.search', compact('aduans', 'jenisAduan'));
    }
    
    /**
     * Mencari aduan berdasarkan nomor tiket
     */
    public function searchByTicket(Request $request)
    {
        $aduan = null;
        $message = null;
        
        if ($request->has('ticket') && $request->ticket) {
            $aduan = Aduan::where('tiket', $request->ticket)->first();
            
            if (!$aduan) {
                $message = 'Aduan dengan nomor tiket tersebut tidak ditemukan.';
            }
        }
        
        return view('aduan.search-ticket', compact('aduan', 'message'));
    }
    
    /**
     * Menampilkan detail aduan
     */
    public function show($id)
    {
        $aduan = Aduan::with('adminComments')->findOrFail($id);
        
        // Dapatkan komentar admin berdasarkan status
        $pendingComment = $aduan->adminComments()->where('status_aduan', 'pending')->latest()->first();
        $prosesComment = $aduan->adminComments()->where('status_aduan', 'Sedang Diproses')->latest()->first();
        $selesaiComment = $aduan->adminComments()->where('status_aduan', 'Selesai')->latest()->first();
        
        return view('aduan.show', compact('aduan', 'pendingComment', 'prosesComment', 'selesaiComment'));
    }
}
