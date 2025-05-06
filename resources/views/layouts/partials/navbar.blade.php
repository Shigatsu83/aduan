<div class="header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 logo-container">
                <img src="https://via.placeholder.com/60/2196F3/FFFFFF?text=LOGO" alt="Logo" class="logo">
                <h1>Aduan Masyarakat</h1>
            </div>
            <div class="col-md-8">
                <nav class="navbar navbar-expand">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('aduan.index') ? 'active' : '' }}" href="{{ route('aduan.index') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('aduan.create') ? 'active' : '' }}" href="{{ route('aduan.create') }}">Buat Aduan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('aduan.search') ? 'active' : '' }}" href="{{ route('aduan.search') }}">Cari Aduan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/#about">Tentang</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>