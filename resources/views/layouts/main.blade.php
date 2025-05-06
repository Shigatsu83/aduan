<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Aduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Ornamen titik di background */
        .dots-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(#3F51B5 2px, transparent 2px);
            background-size: 30px 30px;
            opacity: 0.05;
            z-index: -1;
            pointer-events: none;
        }
        
        /* Corak gelombang di background */
        .wave-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            z-index: -1;
        }

        .wave-bottom {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
            transform: rotate(180deg);
            z-index: -1;
        }

        .wave-svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 200px; /* Ukuran lebih besar */
        }

        .wave-shape-fill {
            fill: #3F51B5;
            opacity: 0.1; /* Opacity lebih tinggi */
        }
        
        /* CSS lainnya tetap sama */
        .header {
            background: linear-gradient(135deg, #2196F3, #3F51B5);
            color: white;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .logo-container {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 60px;
            height: 60px;
            margin-right: 15px;
            background-color: white;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 30px;
            padding: 5px;
        }
        .navbar .nav-link {
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            transition: all 0.3s;
            margin: 0 5px;
        }
        .navbar .nav-link:hover, .navbar .nav-link.active {
            background-color: white;
            color: #2196F3;
        }
        .btn-primary {
            background: linear-gradient(to right, #2196F3, #3F51B5);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            background: linear-gradient(to right, #1976D2, #303F9F);
        }
        footer {
            background: linear-gradient(135deg, #2196F3, #3F51B5);
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
        .aduan-card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            background-color: white;
            padding: 30px;
            margin-top: 0;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .aduan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #2196F3, #3F51B5);
        }
        .form-label {
            font-weight: 600;
            margin-top: 15px;
            color: #495057;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2196F3;
            box-shadow: 0 0 0 0.25rem rgba(33, 150, 243, 0.25);
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s;
            height: 100%;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(90deg, #2196F3, #3F51B5);
            color: white;
            font-weight: 600;
            border: none;
        }
        /* Styling untuk pagination */
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
    @yield('styles')
</head>
<body>
    <!-- Tambahkan div untuk pola titik di awal body -->
    <div class="dots-pattern"></div>
    
    <!-- Tambahkan corak gelombang di atas -->
    <div class="wave-top">
        <svg class="wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="wave-shape-fill"></path>
        </svg>
    </div>
    
    <!-- Tambahkan corak gelombang di bawah -->
    <div class="wave-bottom">
        <svg class="wave-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="wave-shape-fill"></path>
        </svg>
    </div>
    
    <!-- Header dan konten lainnya -->
    @include('layouts.partials.navbar')
    
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @yield('content')
    </div>
    
    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

