<!-- HEADER -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Café Ndalem Hanoman</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (kalau ada) -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --gold-primary: #D4AF37;
            --gold-light: #F4E5C3;
            --gold-dark: #B8941F;
            --white: #FFFFFF;
            --black: #1A1A1A;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #E5E5E5;
            --gray-600: #525252;
            --shadow-md: 0 4px 6px -1px rgba(212, 175, 55, 0.1);
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: var(--white);
            color: var(--black);
        }

        /* HEADER STYLES */
        header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .logo-section img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--gold-light);
        }

        .logo-text {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--black);
            letter-spacing: -0.01em;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 0.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            padding: 0.5rem 1rem;
            color: var(--gray-600);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9375rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
            display: block;
        }

        .nav-link:hover {
            color: var(--gold-primary);
            background: var(--gray-50);
        }

        .nav-link.active {
            color: var(--gold-primary);
            font-weight: 600;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background: var(--gold-primary);
            border-radius: 2px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            flex-direction: column;
            gap: 4px;
        }

        .mobile-menu-btn span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--black);
            transition: 0.3s;
            border-radius: 2px;
        }

        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header-container {
                padding: 0 1rem;
            }

            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--white);
                flex-direction: column;
                padding: 1rem;
                border-bottom: 1px solid var(--gray-200);
                box-shadow: var(--shadow-md);
                gap: 0;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-link.active::after {
                display: none;
            }

            .mobile-menu-btn {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="header-container">
            <a href="/" class="logo-section">
                <img src="{{ url('/logo.jpg') }}" alt="Logo">
                <span class="logo-text">Ndalem Hanoman</span>
            </a>
            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="/" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="/menu" class="nav-link {{ Request::is('menu') ? 'active' : '' }}">Menu</a></li>
                    <li><a href="/reservasi" class="nav-link {{ Request::is('reservasi*') ? 'active' : '' }}">Reservasi</a></li>
                    <li><a href="/login" class="nav-link {{ Request::is('login') ? 'active' : '' }}">Login</a></li>
                </ul>
            </nav>
            <button class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <script>
        function toggleMenu() {
            const navMenu = document.getElementById('navMenu');
            const menuBtn = document.getElementById('mobileMenuBtn');
            navMenu.classList.toggle('active');
            menuBtn.classList.toggle('active');
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const menuBtn = document.getElementById('mobileMenuBtn');
            const header = document.querySelector('header');
            
            if (!header.contains(event.target)) {
                navMenu.classList.remove('active');
                menuBtn.classList.remove('active');
            }
        });
    </script>
</body>

    {{-- <header class="d-flex justify-content-between align-items-center px-4 py-3 shadow-sm"
        style="background-color: #F7F7F7;">
        <div class="d-flex align-items-center">
            <img src="{{ url('/logo.jpg') }}" alt="Logo" class="rounded-circle"
                style="width: 80px; height: 80px; object-fit: cover; margin-right: 10px;">
            <span class="fw-bold fs-5">Ndalem Hanoman</span>
        </div>
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active-link' : 'text-dark' }}" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('menu') ? 'active-link' : 'text-dark' }}" href="/menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('reservasi') ? 'active-link' : 'text-dark' }}"
                        href="/reservasi">Reservasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('login') ? 'active-link' : 'text-dark' }}"
                        href="/login">Login</a>
                </li>
            </ul>
        </nav>
    </header> --}}
