@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <div class="aduan-card">
                <h2 class="mb-4">Cari Aduan dengan Nomor Tiket</h2>
                <p class="mb-4">Masukkan nomor tiket aduan Anda untuk melihat status dan detail aduan.</p>
                
                <form action="{{ route('aduan.search.ticket') }}" method="GET">
                    <div class="input-group mb-4">
                        <input type="text" name="ticket" class="form-control" placeholder="Masukkan nomor tiket..." value="{{ request('ticket') }}" required>
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
                
                @if($message)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i> {{ $message }}
                    </div>
                @endif
                
                @if($aduan)
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-ticket-alt me-2"></i> Detail Aduan #{{ $aduan->nomor_tiket }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="content-section p-3">
                                        <div class="section-title d-flex align-items-center mb-4">
                                            <div class="icon-circle bg-primary text-white me-3">
                                                <i class="fas fa-align-left"></i>
                                            </div>
                                            <h4 class="mb-0">Deskripsi Aduan</h4>
                                        </div>
                                        
                                        <div class="description-box p-3 bg-light rounded mb-4">
                                            <p class="mb-0">{{ $aduan->isi }}</p>
                                        </div>
                                        
                                        <div class="section-title d-flex align-items-center mb-3 mt-4">
                                            <div class="icon-circle bg-primary text-white me-3">
                                                <i class="fas fa-info-circle"></i>
                                            </div>
                                            <h4 class="mb-0">Informasi Tambahan</h4>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="info-box p-3 bg-light rounded">
                                                    <h5 class="info-title">
                                                        <i class="fas fa-tag text-primary me-2"></i>Jenis Aduan
                                                    </h5>
                                                    <p class="mb-0">{{ $aduan->jenis }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="info-box p-3 bg-light rounded">
                                                    <h5 class="info-title">
                                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>Lokasi
                                                    </h5>
                                                    <p class="mb-0">{{ $aduan->lokasi }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if($aduan->lampiran)
                                        <div class="mb-3">
                                            <h5>Lampiran:</h5>
                                            <img src="{{ asset('storage/' . $aduan->lampiran) }}" class="img-fluid rounded" alt="Lampiran Aduan">
                                        </div>
                                    @endif
                                    
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Timeline</h5>
                                            <ul class="timeline">
                                                <li class="timeline-item">
                                                    <div class="timeline-marker bg-success">
                                                        <i class="fas fa-file-alt text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>Aduan Dibuat</h6>
                                                        <p class="text-muted small">{{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y, H:i') }}</p>
                                                    </div>
                                                </li>
                                                @if($aduan->status != 'Pending')
                                                <li class="timeline-item">
                                                    <div class="timeline-marker bg-primary">
                                                        <i class="fas fa-cog text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>Aduan Diproses</h6>
                                                        <p class="text-muted small">{{ \Carbon\Carbon::parse($aduan->updated_at)->format('d M Y, H:i') }}</p>
                                                    </div>
                                                </li>
                                                @endif
                                                @if($aduan->status == 'Selesai')
                                                <li class="timeline-item">
                                                    <div class="timeline-marker bg-success">
                                                        <i class="fas fa-check text-white"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <h6>Aduan Selesai</h6>
                                                        <p class="text-muted small">{{ \Carbon\Carbon::parse($aduan->updated_at)->format('d M Y, H:i') }}</p>
                                                    </div>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('aduan.search') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Pencarian
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline {
    list-style-type: none;
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline:before {
    content: ' ';
    background: #dee2e6;
    display: inline-block;
    position: absolute;
    left: 9px;
    top: 0;
    width: 2px;
    height: 100%;
}

.timeline-marker {
    position: absolute;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    left: -30px;
    top: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-marker i {
    font-size: 8px;
}

.info-title {
    font-size: 0.9rem;
    font-weight: 600;
}
</style>
@endsection