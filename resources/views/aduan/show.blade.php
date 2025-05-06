@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-ticket-alt me-2"></i> Detail Aduan #{{ $aduan->tiket }}
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
                            <div class="mb-4">
                                <h5>Lampiran:</h5>
                                @if($aduan->lampiran)
                                    <img src="{{ asset('storage/' . $aduan->lampiran) }}" class="img-fluid rounded" alt="Lampiran Aduan">
                                @else
                                    <p class="text-muted">Tidak ada lampiran</p>
                                @endif
                            </div>
                            
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
                                                @if($prosesComment)
                                                <div class="card bg-white mt-2 p-2">
                                                    <p class="mb-0 small">{{ $prosesComment->komentar }}</p>
                                                </div>
                                                @endif
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
                                                @if($selesaiComment)
                                                <div class="card bg-white mt-2 p-2">
                                                    <p class="mb-0 small">{{ $selesaiComment->komentar }}</p>
                                                </div>
                                                @endif
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
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    list-style-type: none;
    position: relative;
    padding-left: 30px;
    margin-bottom: 0;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
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
    width: 20px;
    height: 20px;
    border-radius: 50%;
    left: -30px;
    top: 3px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-marker i {
    font-size: 10px;
}

/* Styling baru */
.icon-box {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: rgba(33, 150, 243, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2196F3;
}

.copy-ticket-container {
    display: flex;
    align-items: center;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 6px 12px;
}

#ticketNumber {
    flex-grow: 1;
    font-family: monospace;
    font-size: 14px;
    font-weight: 500;
}

.copy-btn {
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 4px 8px;
    transition: color 0.2s;
}

.copy-btn:hover {
    color: #0d6efd;
}

.info-item {
    padding: 10px;
    border-radius: 5px;
    background-color: #f8f9fa;
}

.icon-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.section-title {
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.info-title {
    font-size: 16px;
    margin-bottom: 8px;
}

.description-box {
    border-left: 4px solid #2196F3;
}

.content-section {
    border-left: 1px dashed #dee2e6;
}
</style>

<script>
function copyTicket() {
    const ticketText = document.getElementById('ticketNumber').innerText.replace('Tiket: ', '');
    navigator.clipboard.writeText(ticketText).then(() => {
        // Tampilkan feedback
        const btn = document.querySelector('.copy-btn i');
        btn.classList.remove('fa-copy');
        btn.classList.add('fa-check');
        setTimeout(() => {
            btn.classList.remove('fa-check');
            btn.classList.add('fa-copy');
        }, 1500);
    });
}
</script>
@endsection