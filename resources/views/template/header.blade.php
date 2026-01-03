<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    :root {
        --gold-primary: #FFB800;
        --gold-light: #FFF4DC;
        --gold-medium: #FFD700;
        --gold-dark: #F4A300;
        --white: #FFFFFF;
        --black: #2C2C2C;
        --gray-50: #FAFAFA;
        --gray-600: #6B6B6B;
        --cream: #FFFEF7;
    }

    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    body {
        background: var(--white);
        color: var(--black);
        margin: 0;
        padding: 0;
    }

    /* HEADER STYLES */
    header {
        background: linear-gradient(to bottom, var(--white), var(--cream));
        box-shadow: 0 2px 20px rgba(255, 184, 0, 0.08);
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: all 0.3s ease;
        border-bottom: 2px solid var(--gold-light);
    }

    header:hover {
        box-shadow: 0 4px 30px rgba(255, 184, 0, 0.15);
        border-bottom-color: var(--gold-medium);
    }

    /* LOGO SECTION */
    header .d-flex.align-items-center {
        transition: transform 0.3s ease;
    }

    header .d-flex.align-items-center:hover {
        transform: translateY(-2px);
    }

    header .rounded-circle {
        width: 80px;
        height: 80px;
        border: 3px solid var(--gold-light);
        box-shadow: 0 4px 12px rgba(255, 184, 0, 0.15);
        transition: all 0.3s ease;
    }

    header .d-flex.align-items-center:hover .rounded-circle {
        box-shadow: 0 6px 20px rgba(255, 184, 0, 0.3), 0 0 0 4px var(--gold-light);
        transform: scale(1.05);
        border-color: var(--gold-medium);
    }

    header .fw-bold {
        transition: all 0.3s ease;
        color: var(--black);
        font-size: 1.25rem;
    }

    header .d-flex.align-items-center:hover .fw-bold {
        color: var(--gold-primary) !important;
        text-shadow: 0 2px 10px rgba(255, 184, 0, 0.2);
    }

    /* HAMBURGER BUTTON */
    .hamburger-btn {
        display: none;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0.5rem;
        font-size: 1.5rem;
        color: var(--gray-600);
    }

    /* NAVIGATION */
    header .nav-link {
        padding: 0.75rem 1.5rem !important;
        color: var(--gray-600) !important;
        font-weight: 500;
        font-size: 0.95rem;
        border-radius: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        text-decoration: none;
        background: transparent;
    }

    header .nav-link:hover {
        color: var(--gold-primary) !important;
        transform: translateY(-2px);
    }

    /* ACTIVE LINK */
    header .nav-link.active-link {
        color: var(--gold-primary) !important;
        background: transparent !important;
        font-weight: 600;
    }

    header .nav-link.active-link::after {
        content: '';
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background: var(--gold-primary);
        border-radius: 3px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .hamburger-btn {
            display: block;
        }

        header .rounded-circle {
            width: 60px;
            height: 60px;
            border-width: 2px;
        }

        header .fw-bold {
            font-size: 1rem;
        }

        header .nav {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(to bottom, var(--white), var(--cream));
            flex-direction: column;
            padding: 1.5rem;
            box-shadow: 0 8px 30px rgba(255, 184, 0, 0.15);
            animation: slideDown 0.3s ease;
            border-bottom: 2px solid var(--gold-light);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        header .nav.show {
            display: flex !important;
        }

        header .nav-link {
            padding: 1rem 1.5rem !important;
        }

        header .nav-link.active-link::after {
            display: none;
        }
    }

    @media (max-width: 480px) {
        header {
            padding: 0.75rem 1rem !important;
        }

        header .rounded-circle {
            width: 50px;
            height: 50px;
            margin-right: 8px !important;
        }

        header .fw-bold {
            font-size: 0.9rem;
        }

        .hamburger-btn {
            font-size: 1.3rem;
        }
    }
</style>

<!-- HEADER -->
<header class="d-flex justify-content-between align-items-center px-4 py-3">
    <div class="d-flex align-items-center">
        <img src="{{ url('/logo.jpg') }}" alt="Logo" class="rounded-circle"
            style="object-fit: cover; margin-right: 10px;">
        <span class="fw-bold">Ndalem Hanoman</span>
    </div>

    <!-- Hamburger Button -->
    <button class="hamburger-btn" id="hamburgerBtn">
        ☰
    </button>

    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('/') ? 'active-link' : '' }}" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu') ? 'active-link' : '' }}" href="/menu">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('reservasi*') ? 'active-link' : '' }}" href="/reservasi">Reservasi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('login') ? 'active-link' : '' }}" href="/login">Login</a>
            </li>
        </ul>
    </nav>
</header>

<script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const nav = document.querySelector('header nav ul');

    hamburgerBtn.addEventListener('click', function() {
        nav.classList.toggle('show');
    });
</script>