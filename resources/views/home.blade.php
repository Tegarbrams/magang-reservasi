<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Ndalem Hanoman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@include('template.header')

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
        --shadow-sm: 0 1px 2px 0 rgba(212, 175, 55, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(212, 175, 55, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(212, 175, 55, 0.15);
    }

    /* HERO SECTION */
    .hero-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 600px;
        align-items: center;
    }

    .hero-content {
        padding: 4rem;
    }

    .hero-content h1 {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
        color: var(--black);
    }

    .hero-content .highlight {
        color: var(--gold-primary);
    }

    .hero-content p {
        font-size: 1.25rem;
        color: var(--gray-600);
        margin-bottom: 2rem;
    }

    .hero-image {
        height: 600px;
        overflow: hidden;
    }

    .hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-primary-custom {
        background: var(--gold-primary);
        color: var(--white);
        padding: 1rem 2rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
    }

    .btn-primary-custom:hover {
        background: var(--gold-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: var(--white);
    }

    /* ABOUT SECTION */
    .about-section {
        position: relative;
        min-height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 4rem 2rem;
        background-size: cover;
        background-position: center;
    }

    .about-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(26, 26, 26, 0.75);
        backdrop-filter: blur(2px);
    }

    .about-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        color: var(--white);
    }

    .about-content h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        letter-spacing: -0.01em;
    }

    .about-content p {
        font-size: 1.125rem;
        line-height: 1.8;
        opacity: 0.95;
    }

    /* AREA CARDS SECTION */
    .area-section {
        padding: 4rem 0;
        background: var(--gray-50);
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 0.5rem;
    }

    .section-header p {
        color: var(--gray-600);
        font-size: 1rem;
    }

    .area-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .area-card {
        background: var(--white);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--gray-200);
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .area-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--gold-primary);
    }

    .area-card-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .area-card-content {
        padding: 1.25rem;
    }

    .area-card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--black);
    }

    .area-card-info {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: 0.25rem;
    }

    .area-card-badge {
        display: inline-block;
        background: var(--gold-light);
        color: var(--gold-dark);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.75rem;
    }

    /* FACILITIES SECTION */
    .facilities-section {
        padding: 4rem 2rem;
        background: var(--white);
    }

    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .facility-item {
        text-align: center;
    }

    .facility-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--gold-light), var(--gold-primary));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        transition: all 0.2s ease;
    }

    .facility-icon:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    .facility-icon img {
        width: 50%;
        height: auto;
    }

    .facility-name {
        font-weight: 600;
        color: var(--black);
    }

    /* GALLERY SECTION */
    .gallery-section {
        padding: 4rem 2rem;
        background: var(--gray-50);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .gallery-grid img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .gallery-grid img:hover {
        transform: scale(1.03);
        box-shadow: var(--shadow-md);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .hero-section {
            grid-template-columns: 1fr;
        }

        .hero-content {
            padding: 2rem;
        }

        .hero-content h1 {
            font-size: 2rem;
        }

        .hero-image {
            height: 400px;
        }

        .area-grid {
            grid-template-columns: repeat(2, 1fr);
            padding: 0 1rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .gallery-grid img {
            height: 180px;
        }

        .facilities-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-content">
        <h1>Selamat Datang<br>di <span class="highlight">Café Ndalem Hanoman</span></h1>
        <p>Tempat nongkrong nyaman di tengah Yogyakarta</p>
        <a href="/reservasi" class="btn-primary-custom">Reservasi Sekarang</a>
    </div>
    <div class="hero-image">
        <img src="{{ url('/cafe-full.jpg') }}" alt="Cafe">
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="about-section mt-5" style="background-image: url('{{ url('/about-cafe.jpg') }}');">
    <div class="about-overlay"></div>
    <div class="about-content">
        <h2>CAFE AND RESTO TRADISIONAL MODERN</h2>
        <p>Café Ndalem Hanoman adalah tempat yang memadukan nuansa budaya Jawa dengan sentuhan modern. "Ndalem" berarti rumah dalam bahasa Jawa, sementara "Hanoman" adalah simbol keberanian dan ketulusan. Kafe ini menyajikan wedangan dan hidangan khas Jawa dalam suasana yang nyaman, hangat, dan autentik.</p>
    </div>
</section>

<!-- AREA CAFE SECTION -->
<section class="area-section">
    <div class="section-header">
        <h2>Area Café</h2>
        <p>Klik area yang Anda inginkan untuk melakukan reservasi</p>
    </div>
    <div class="area-grid">
        <a href="{{ route('reservasi.index', ['ruangan' => 1]) }}" class="area-card">
            <img src="{{ asset('img/vip.jpg') }}" alt="VIP Room" class="area-card-image">
            <div class="area-card-content">
                <h3 class="area-card-title">VIP Room</h3>
                <p class="area-card-info">10–15 orang</p>
                <p class="area-card-info">Tertutup & nyaman</p>
                <span class="area-card-badge">Klik untuk Reservasi</span>
            </div>
        </a>
        <a href="{{ route('reservasi.index', ['ruangan' => 2]) }}" class="area-card">
            <img src="{{ asset('img/meeting-room.jpg') }}" alt="Meeting Room" class="area-card-image">
            <div class="area-card-content">
                <h3 class="area-card-title">Meeting Room</h3>
                <p class="area-card-info">20–25 orang</p>
                <p class="area-card-info">Diskusi & rapat</p>
                <span class="area-card-badge">Klik untuk Reservasi</span>
            </div>
        </a>
        <a href="{{ route('reservasi.index', ['ruangan' => 3]) }}" class="area-card">
            <img src="{{ asset('img/indoor-ac.jpg') }}" alt="Indoor AC" class="area-card-image">
            <div class="area-card-content">
                <h3 class="area-card-title">Indoor AC</h3>
                <p class="area-card-info">30–40 orang</p>
                <p class="area-card-info">Sejuk & nyaman</p>
                <span class="area-card-badge">Klik untuk Reservasi</span>
            </div>
        </a>
        <a href="{{ route('reservasi.index', ['ruangan' => 4]) }}" class="area-card">
            <img src="{{ asset('img/backyard-outdoor.jpg') }}" alt="Backyard Outdoor" class="area-card-image">
            <div class="area-card-content">
                <h3 class="area-card-title">Backyard Outdoor</h3>
                <p class="area-card-info">40–50 orang</p>
                <p class="area-card-info">Outdoor asri</p>
                <span class="area-card-badge">Klik untuk Reservasi</span>
            </div>
        </a>
        <a href="{{ route('reservasi.index', ['ruangan' => 5]) }}" class="area-card">
            <img src="{{ asset('img/indoor-nonac.jpg') }}" alt="Indoor Non-AC" class="area-card-image">
            <div class="area-card-content">
                <h3 class="area-card-title">Indoor Non-AC</h3>
                <p class="area-card-info">25–30 orang</p>
                <p class="area-card-info">Klasik alami</p>
                <span class="area-card-badge">Klik untuk Reservasi</span>
            </div>
        </a>
    </div>
</section>

<!-- FACILITIES SECTION -->
<section class="facilities-section">
    <div class="section-header">
        <h2>Kenapa Harus Hanoman?</h2>
        <p>Karena kami menyediakan fasilitas lengkap yang mendukung kenyamanan Anda</p>
    </div>
    <div class="facilities-grid">
        <div class="facility-item">
            <div class="facility-icon">
                <img src="{{ asset('img/proyektor.png') }}" alt="LCD Proyektor">
            </div>
            <p class="facility-name">LCD Proyektor</p>
        </div>
        <div class="facility-item">
            <div class="facility-icon">
                <img src="{{ asset('img/tv.png') }}" alt="Smart TV">
            </div>
            <p class="facility-name">Smart TV</p>
        </div>
        <div class="facility-item">
            <div class="facility-icon">
                <img src="{{ asset('img/wifi.jpg') }}" alt="Free Wi-Fi">
            </div>
            <p class="facility-name">Free Wi-Fi</p>
        </div>
        <div class="facility-item">
            <div class="facility-icon">
                <img src="{{ asset('img/sound.jpg') }}" alt="Sound System">
            </div>
            <p class="facility-name">Sound System</p>
        </div>
    </div>
</section>

<!-- GALLERY SECTION -->
<section class="gallery-section">
    <div class="section-header">
        <h2>Galeri Suasana Café</h2>
    </div>
    <div class="gallery-grid">
        <img src="{{ asset('img/galeri1.png') }}" alt="Galeri 1">
        <img src="{{ asset('img/galeri2.png') }}" alt="Galeri 2">
        <img src="{{ asset('img/galeri3.png') }}" alt="Galeri 3">
        <img src="{{ asset('img/galeri4.png') }}" alt="Galeri 4">
        <img src="{{ asset('img/galeri5.png') }}" alt="Galeri 5">
        <img src="{{ asset('img/galeri6.png') }}" alt="Galeri 6">
        <img src="{{ asset('img/galeri7.png') }}" alt="Galeri 7">
        <img src="{{ asset('img/galeri8.png') }}" alt="Galeri 8">
    </div>
</section>

{{-- Footer --}}
@include('template.footer')

   <!-- JavaScript -->
<script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
    
    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Navbar Scroll Effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-lg', 'bg-opacity-100');
        } else {
            navbar.classList.remove('shadow-lg', 'bg-opacity-100');
        }
    });
</script>

</body>
</html>