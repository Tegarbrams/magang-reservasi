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

<<<<<<< HEAD
    <!-- FOTO -->
    <img src="{{ asset('assets/TV.png') }}" 
         class="w-full h-40 object-cover rounded-lg mb-6" alt="foto fasilitas">

    <!-- ICON -->
    <div class="bg-gold bg-opacity-10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
    </div>..

    <!-- JUDUL -->
    <h3 class="text-2xl font-bold mb-4">TV</h3>

</div>

                <!-- Fasilitas 2 -->
                <div class="bg-darker rounded-xl p-8 hover:transform hover:-translate-y-2 transition duration-300 border border-gray-800 hover:border-gold">
                    <div class="bg-gold bg-opacity-10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Spa & Wellness</h3>
                    <p class="text-gray-400">
                        Manjakan diri dengan treatment spa kelas dunia dan fasilitas wellness center yang lengkap.
                    </p>
                </div>
                
                <!-- Fasilitas 3 -->
                <div class="bg-darker rounded-xl p-8 hover:transform hover:-translate-y-2 transition duration-300 border border-gray-800 hover:border-gold">
                    <div class="bg-gold bg-opacity-10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Fine Dining</h3>
                    <p class="text-gray-400">
                        Restoran bintang lima dengan chef profesional yang menyajikan masakan internasional terbaik.
                    </p>
                </div>
                
                <!-- Fasilitas 4 -->
                <div class="bg-darker rounded-xl p-8 hover:transform hover:-translate-y-2 transition duration-300 border border-gray-800 hover:border-gold">
                    <div class="bg-gold bg-opacity-10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Infinity Pool</h3>
                    <p class="text-gray-400">
                        Kolam renang infinity di rooftop dengan pemandangan panorama yang spektakuler.
                    </p>
                </div>
                
                <!-- Fasilitas 5 -->
                <div class="bg-darker rounded-xl p-8 hover:transform hover:-translate-y-2 transition duration-300 border border-gray-800 hover:border-gold">
                    <div class="bg-gold bg-opacity-10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Fitness Center</h3>
                    <p class="text-gray-400">
                        Gym modern dengan peralatan lengkap dan personal trainer profesional yang siap membantu.
                    </p>
                </div>
                
                <!-- Fasilitas 6 -->
                <div class="bg-darker rounded-xl p-8 hover:transform hover:-translate-y-2 transition duration-300 border border-gray-800 hover:border-gold">
                    <div class="bg-gold bg-opacity-10 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Meeting Room</h3>
                    <p class="text-gray-400">
                        Ruang meeting dan ballroom yang elegan untuk acara bisnis dan special events Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-20 bg-darker">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-4">Hubungi <span class="text-gold">Kami</span></h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Tim kami siap melayani Anda 24/7. Jangan ragu untuk menghubungi kami
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Contact Form -->
                <div class="bg-dark rounded-xl p-8 border border-gray-800">
                    <h3 class="text-2xl font-bold mb-6">Kirim Pesan</h3>
                    <form class="space-y-6">
                        <div>
                            <label class="block text-gray-400 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full bg-darker border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-gold focus:outline-none transition duration-300" placeholder="Masukkan nama Anda">
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Email</label>
                            <input type="email" class="w-full bg-darker border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-gold focus:outline-none transition duration-300" placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-gray-400 mb-2">Pesan</label>
                            <textarea rows="4" class="w-full bg-darker border border-gray-700 rounded-lg px-4 py-3 text-white focus:border-gold focus:outline-none transition duration-300" placeholder="Tulis pesan Anda..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gold hover-gold text-black py-3 rounded-lg font-semibold transition duration-300">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div class="bg-dark rounded-xl p-8 border border-gray-800">
                        <div class="flex items-start space-x-4">
                            <div class="bg-gold bg-opacity-10 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Alamat</h4>
                                <p class="text-gray-400">Jl. Luxury Boulevard No. 123<br>Jakarta Selatan, 12345</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark rounded-xl p-8 border border-gray-800">
                        <div class="flex items-start space-x-4">
                            <div class="bg-gold bg-opacity-10 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Telepon</h4>
                                <p class="text-gray-400">+62 21 1234 5678<br>+62 812 3456 7890</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-dark rounded-xl p-8 border border-gray-800">
                        <div class="flex items-start space-x-4">
                            <div class="bg-gold bg-opacity-10 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Email</h4>
                                <p class="text-gray-400">info@luxury.com<br>reservasi@luxury.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark border-t border-gray-800 py-12">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-gold mb-4">LUXURY</h3>
                    <p class="text-gray-400">Pengalaman kemewahan yang tak terlupakan untuk setiap momen berharga Anda.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Menu Cepat</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#hero" class="hover:text-gold transition duration-300">Beranda</a></li>
                        <li><a href="#fasilitas" class="hover:text-gold transition duration-300">Fasilitas</a></li>
                        <li><a href="/reservasi" class="hover:text-gold transition duration-300">Reservasi</a></li>
                        <li><a href="#kontak" class="hover:text-gold transition duration-300">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-gold transition duration-300">Room Service</a></li>
                        <li><a href="#" class="hover:text-gold transition duration-300">Concierge</a></li>
                        <li><a href="#" class="hover:text-gold transition duration-300">Valet Parking</a></li>
                        <li><a href="#" class="hover:text-gold transition duration-300">Airport Transfer</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gold bg-opacity-10 w-10 h-10 rounded-lg flex items-center justify-center hover:bg-gold hover:bg-opacity-20 transition duration-300">
                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gold bg-opacity-10 w-10 h-10 rounded-lg flex items-center justify-center hover:bg-gold hover:bg-opacity-20 transition duration-300">
                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        <a href="#" class="bg-gold bg-opacity-10 w-10 h-10 rounded-lg flex items-center justify-center hover:bg-gold hover:bg-opacity-20 transition duration-300">
                            <svg class="w-5 h-5 text-gold" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 LUXURY. All rights reserved.</p>
            </div>
        </div>
    </footer>

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
=======
<!-- Bootstrap Bundle JS (wajib untuk carousel) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 9217c55a23b39b88ef2c3d69f4161cc65a8f52f5

</body>
</html>