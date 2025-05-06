@extends('layouts.main')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(33, 150, 243, 0.8), rgba(63, 81, 181, 0.8)), url('https://via.placeholder.com/1200x400');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0;
        border-radius: 10px;
        margin-bottom: 40px;
    }
    .stats-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .stats-icon {
        font-size: 36px;
        margin-bottom: 15px;
    }
    .stats-number {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .stats-text {
        color: #6c757d;
    }
    .icon-blue {
        color: #2196F3;
    }
    .icon-green {
        color: #4CAF50;
    }
    .icon-purple {
        color: #9C27B0;
    }
    .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    .aduan-status {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-pending {
        background-color: #FFC107;
        color: #212529;
    }
    .status-process {
        background-color: #2196F3;
        color: white;
    }
    .status-done {
        background-color: #4CAF50;
        color: white;
    }
    .aduan-card {
        border-left: 4px solid #2196F3;
        padding-left: 15px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="hero-section text-center">
    <h1 class="display-4 mb-4">Sistem Aduan Masyarakat Kota Semarang</h1>
    <p class="lead mb-4">Platform resmi untuk menyampaikan keluhan, saran, dan masukan terkait layanan publik dan infrastruktur di Kota Semarang</p>
    <a href="{{ route('aduan.create') }}" class="btn btn-light btn-lg">Sampaikan Aduan Anda</a>
</div>

<div class="row mb-5">
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon icon-blue">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stats-number">{{ $totalAduans ?? '250' }}</div>
            <div class="stats-text">Total Aduan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon icon-green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stats-number">{{ $aduanSelesai ?? '180' }}</div>
            <div class="stats-text">Aduan Terselesaikan</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card">
            <div class="stats-icon icon-purple">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-number">{{ $aduanDiproses ?? '70' }}</div>
            <div class="stats-text">Aduan Dalam Proses</div>
        </div>
    </div>
</div>

<h2 class="mb-4">Aduan Terbaru</h2>
<div class="row">
    @if(isset($recentAduans) && count($recentAduans) > 0)
        @foreach($recentAduans as $aduan)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($aduan->lampiran)
                        <img src="{{ asset('storage/' . $aduan->lampiran) }}" class="card-img-top" alt="Lampiran Aduan">
                    @else
                        <img src="https://via.placeholder.com/300x180?text=Tidak+Ada+Lampiran" class="card-img-top" alt="Tidak Ada Lampiran">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $aduan->judul }}</h5>
                        <p class="card-text">{{ Str::limit($aduan->isi, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $aduan->created_at->format('d M Y') }}</small>
                            <span class="aduan-status status-{{ strtolower(str_replace(' ', '-', $aduan->status)) }}">{{ $aduan->status }}</span>
                        </div>
                        <a href="{{ route('aduan.show', $aduan->id) }}" class="btn btn-primary mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <!-- Data contoh jika tidak ada aduan -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x180?text=Infrastruktur" class="card-img-top" alt="Aduan Infrastruktur">
                <div class="card-body">
                    <h5 class="card-title">Perbaikan Jalan Rusak</h5>
                    <p class="card-text">Jalan di Jl. Pahlawan depan Kantor Walikota berlubang dan membahayakan pengendara sepeda motor.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">20 Apr 2025</small>
                        <span class="aduan-status status-process">Sedang Ditangani</span>
                    </div>
                    <a href="#" class="btn btn-primary mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x180?text=Lingkungan" class="card-img-top" alt="Aduan Lingkungan">
                <div class="card-body">
                    <h5 class="card-title">Tumpukan Sampah di Taman Kota</h5>
                    <p class="card-text">Tumpukan sampah di Taman Simpang Lima tidak diangkut selama 3 hari dan menimbulkan bau tidak sedap.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">18 Apr 2025</small>
                        <span class="aduan-status status-done">Selesai</span>
                    </div>
                    <a href="#" class="btn btn-primary mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x180?text=Pelayanan" class="card-img-top" alt="Aduan Pelayanan">
                <div class="card-body">
                    <h5 class="card-title">Pelayanan KTP di Kecamatan</h5>
                    <p class="card-text">Pelayanan pembuatan KTP di Kecamatan Semarang Tengah sangat lambat dan petugas kurang ramah.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">15 Apr 2025</small>
                        <span class="aduan-status status-pending">Belum Ditangani</span>
                    </div>
                    <a href="#" class="btn btn-primary mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="text-center mt-4 mb-5">
    <a href="{{ route('aduan.search') }}" class="btn btn-primary">Lihat Semua Aduan</a>
</div>

<div id="about" class="row mt-5">
    <div class="col-md-6">
        <h3>Tentang Sistem Aduan Masyarakat</h3>
        <p>Sistem Aduan Masyarakat Kota Semarang adalah platform resmi yang disediakan oleh Pemerintah Kota Semarang untuk menerima dan menindaklanjuti aduan, keluhan, saran, dan masukan dari masyarakat terkait layanan publik dan infrastruktur di Kota Semarang.</p>
        <p>Melalui platform ini, masyarakat dapat dengan mudah melaporkan berbagai permasalahan seperti jalan rusak, sampah yang tidak terangkut, lampu jalan mati, pelayanan publik yang kurang memuaskan, dan berbagai permasalahan lainnya.</p>
        <p>Setiap aduan yang masuk akan segera ditindaklanjuti oleh petugas terkait dan masyarakat dapat memantau status penanganan aduannya secara transparan.</p>
    </div>
    <div class="col-md-6">
        <h3>Cara Menyampaikan Aduan</h3>
        <div class="aduan-card">
            <h5><i class="fas fa-user-edit me-2 icon-blue"></i> Buat Aduan</h5>
            <p>Isi formulir aduan dengan lengkap dan jelas, sertakan lokasi dan lampiran foto jika ada.</p>
        </div>
        <div class="aduan-card">
            <h5><i class="fas fa-paper-plane me-2 icon-purple"></i> Kirim Aduan</h5>
            <p>Kirim aduan Anda dan sistem akan memberikan nomor tiket untuk melacak status aduan.</p>
        </div>
        <div class="aduan-card">
            <h5><i class="fas fa-search me-2 icon-green"></i> Pantau Status</h5>
            <p>Pantau status aduan Anda melalui nomor tiket yang diberikan setelah mengirim aduan.</p>
        </div>
    </div>
</div>
@endsection
