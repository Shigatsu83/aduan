@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-12">
            <div class="aduan-card">
                <h2 class="mb-4">Cari Aduan</h2>
                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ route('aduan.search') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari aduan..." value="{{ request('keyword') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <select name="jenis" class="form-select">
                                        <option value="">Semua Jenis</option>
                                        @foreach($jenisAduan as $jenis)
                                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Sedang Ditangani" {{ request('status') == 'Sedang Ditangani' ? 'selected' : '' }}>Sedang Ditangani</option>
                                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-filter me-1"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Cari dengan Nomor Tiket</h5>
                                <p class="card-text">Jika Anda memiliki nomor tiket aduan, Anda dapat melacak status aduan secara langsung.</p>
                                <a href="{{ route('aduan.search.ticket') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-ticket-alt me-1"></i> Cari dengan Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">
                Hasil Pencarian
                @if(request('keyword'))
                    untuk "{{ request('keyword') }}"
                @endif
            </h3>
        </div>
    </div>
    
    <div class="row">
        @if(count($aduans) > 0)
            @foreach($aduans as $aduan)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 d-flex flex-column">
                        @if($aduan->lampiran)
                            <img src="{{ asset('storage/' . $aduan->lampiran) }}" class="card-img-top" alt="Lampiran Aduan" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-placeholder" style="height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ ucwords(strtolower($aduan->judul)) }}</h5>
                            <p class="card-text flex-grow-1">{{ Str::limit($aduan->isi, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">{{ \Carbon\Carbon::parse($aduan->created_at)->format('d M Y') }}</small>
                                @if($aduan->status == 'Pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                @elseif($aduan->status == 'Sedang Diproses')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-cog fa-spin me-1"></i> Sedang Ditangani
                                    </span>
                                @elseif($aduan->status == 'Selesai')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Selesai
                                    </span>
                                @endif
                            </div>
                            <!-- Ganti tombol "Lihat Detail" dengan link ke halaman detail -->
                            <div class="mt-3 text-center">
                                <a href="{{ route('aduan.show', $aduan->id) }}" class="btn btn-primary w-100">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> Tidak ada aduan yang ditemukan.
                </div>
            </div>
        @endif
    </div>
    
    <div class="d-flex justify-content-center mt-4 mb-5">
        {{ $aduans->appends(request()->query())->links('pagination.custom') }}
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Pagination Styling */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 20px 0;
        border-radius: 0.25rem;
    }

    .pagination li {
        margin: 0 2px;
    }

    .pagination li a, .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        color: #0d6efd;
        background-color: #fff;
        text-decoration: none;
        border-radius: 4px;
        min-width: 38px;
        height: 38px;
        font-size: 14px;
    }

    .pagination li.active span {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .pagination li.disabled span {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
    }

    .pagination li a:hover {
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    /* Styling untuk tombol panah */
    .pagination svg {
        width: 18px;
        height: 18px;
    }
</style>
@endpush