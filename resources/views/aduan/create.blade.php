@extends('layouts.main')

@section('styles')
<style>
    .feature-icon {
        font-size: 24px;
        margin-bottom: 10px;
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
    .feature-box {
        text-align: center;
        padding: 20px;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        transition: all 0.3s;
        height: calc(100% - 20px);
    }
    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .decoration-dots {
        position: absolute;
        width: 150px;
        height: 150px;
        background-image: radial-gradient(#3F51B5 2px, transparent 2px);
        background-size: 15px 15px;
        opacity: 0.2;
        z-index: 0;
    }
    .dots-top-right {
        top: -50px;
        right: -50px;
    }
    .dots-bottom-left {
        bottom: -50px;
        left: -50px;
    }
    .content-row {
        display: flex;
        align-items: flex-start;
        margin-top: 30px;
    }
    .privacy-notice {
        font-size: 12px;
        color: #6c757d;
        margin-top: 20px;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 3px solid #3F51B5;
    }
</style>
@endsection

@section('content')
<div class="row content-row">
    <div class="col-md-8">
        <div class="aduan-card">
            <div class="decoration-dots dots-top-right"></div>
            <div class="decoration-dots dots-bottom-left"></div>
            <h2 class="mb-4">Form Pengaduan Masyarakat</h2>
            <p class="mb-4">Silakan isi formulir di bawah ini dengan lengkap dan jelas. Pengaduan Anda akan segera ditindaklanjuti oleh petugas terkait.</p>
            
            <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Aduan</label>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Contoh: Jalan Rusak di Jl. Pahlawan" required>
                </div>
                
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis Aduan</label>
                    <select class="form-select" id="jenis" name="jenis" required>
                        <option value="" selected disabled>Pilih Jenis Aduan</option>
                        <option value="Infrastruktur">Infrastruktur (Jalan, Jembatan, dll)</option>
                        <option value="Lingkungan">Lingkungan (Sampah, Polusi, dll)</option>
                        <option value="Pelayanan Publik">Pelayanan Publik</option>
                        <option value="Keamanan">Keamanan dan Ketertiban</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Contoh: Jl. Pahlawan No. 10, Kec. Semarang Tengah" required>
                </div>
                
                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Aduan</label>
                    <textarea class="form-control" id="isi" name="isi" rows="5" placeholder="Jelaskan secara detail permasalahan yang Anda alami..." required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                    <input type="file" class="form-control" id="lampiran" name="lampiran" accept="image/*,application/pdf">
                    <div class="form-text">Format yang diperbolehkan: JPG, JPEG, PNG, PDF. Maksimal 5MB.</div>
                </div>
                
                <div class="privacy-notice">
                    <i class="fas fa-info-circle me-2"></i> Dengan mengirimkan aduan ini, Anda menyetujui bahwa data yang Anda berikan akan diproses sesuai dengan kebijakan privasi kami.
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Aduan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="feature-box">
                    <div class="feature-icon icon-blue">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h4>Sampaikan Aduan</h4>
                    <p>Laporkan masalah di sekitar Anda dengan mudah dan cepat</p>
                </div>
            </div>
            
            <div class="col-12 mb-4">
                <div class="feature-box">
                    <div class="feature-icon icon-purple">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Proses Cepat</h4>
                    <p>Aduan Anda akan segera diproses oleh petugas terkait</p>
                </div>
            </div>
            
            <div class="col-12 mb-4">
                <div class="feature-box">
                    <div class="feature-icon icon-green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4>Pantau Status</h4>
                    <p>Pantau status aduan Anda secara real-time</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection