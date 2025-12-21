<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Ndalem Hanoman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .active-link {
            font-weight: bold;
            color: #FFB22C !important;
        }
        .nav-link:hover {
            color: #FFB22C !important;
        }
        
        /* Gallery Grid Style */
        .gallery-section {
            background-color: #f8f9fa;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        
        .gallery-grid img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        
        .gallery-grid img:hover {
            transform: scale(1.05);
        }
        
        /* Area Cafe Clickable Styles */
        .area-card {
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            color: inherit;
        }
        
        .area-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3) !important;
        }
        
        .area-card:hover .badge {
            background-color: #28a745 !important;
        }
        
        .area-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 178, 44, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
            border-radius: 1.5rem;
        }
        
        .area-card:hover::after {
            opacity: 1;
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .gallery-grid img {
                height: 180px;
            }
        }
    </style>
</head>
<body class="bg-white">
  
{{-- Header --}}
@include('template.header')

    <!-- HERO SECTION -->
    <section class="container-fluid py-5">
        <div class="row align-items-center">
            <!-- Kiri: Teks -->
            <div class="col-md-6 px-5">
                <h1 class="fw-bold mb-3">
                    Selamat Datang <br>
                    di <span class="text-warning">Café Ndalem Hanoman</span>
                </h1>
                <p class="fs-5 mb-4">Tempat nongkrong nyaman di tengah Yogyakarta</p>
                <a href="/reservasi" class="btn btn-warning px-4 py-2">Reservasi Sekarang</a>
            </div>

            <!-- Kanan: Gambar full -->
            <div class="col-md-6 p-0">
                <img src="{{ url('/cafe-full.jpg') }}" alt="Cafe" class="img-fluid w-100 h-100" style="object-fit: cover;">
            </div>
        </div>
    </section>

    <!-- SECTION: TENTANG CAFE -->
    <section class="position-relative text-white text-center py-5" style="background-image: url('{{ url('/about-cafe.jpg') }}'); background-size: cover; background-position: center;">
        <!-- Overlay gelap dan blur -->
        <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0,0,0,0.5); backdrop-filter: blur(3px); z-index: 1;"></div>

        <!-- Konten -->
        <div class="container position-relative d-flex flex-column justify-content-center align-items-center" style="z-index: 2; min-height: 60vh;">
            <h2 class="fw-bold mb-4">CAFE AND RESTO TRADISIONAL MODERN</h2>
            <p class="lead px-3 px-md-5" style="max-width: 800px;">
                Café Ndalem Hanoman adalah tempat yang memadukan nuansa budaya Jawa dengan sentuhan modern. "Ndalem" berarti rumah dalam bahasa Jawa, sementara "Hanoman" adalah simbol keberanian dan ketulusan. Kafe ini menyajikan wedangan dan hidangan khas Jawa dalam suasana yang nyaman, hangat, dan autentik.
            </p>
        </div>
    </section>

    <!-- Section Area Café - UPDATED WITH CLICKABLE CARDS -->
    <section class="py-5" style="background-color: #F7F7F7;">
        <div class="container">
            <h2 class="text-center mb-3 fw-bold">Area Café</h2>
            <p class="text-center text-muted mb-5">Klik area yang Anda inginkan untuk melakukan reservasi</p>

            <div class="row justify-content-center g-4">
                {{-- VIP Room --}}
                <div class="col-12 col-sm-6 col-lg-2" style="min-width: 200px;">
                    <a href="{{ route('reservasi.index', ['ruangan' => 1]) }}" class="text-decoration-none">
                        <div class="rounded-4 shadow-sm overflow-hidden text-center area-card" style="background-color: #FFB22C;">
                            <img src="{{ asset('img/vip.jpg') }}" alt="VIP Room" style="width: 100%; height: 160px; object-fit: cover;">
                            <div class="p-2">
                                <h6 class="fw-bold mb-1 text-dark">VIP Room</h6>
                                <p class="mb-1 small text-dark">10–15 orang</p>
                                <p class="mb-2 small text-dark">Tertutup & nyaman</p>
                                <span class="badge bg-dark">Klik untuk Reservasi</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Meeting Room --}}
                <div class="col-12 col-sm-6 col-lg-2" style="min-width: 200px;">
                    <a href="{{ route('reservasi.index', ['ruangan' => 2]) }}" class="text-decoration-none">
                        <div class="rounded-4 shadow-sm overflow-hidden text-center area-card" style="background-color: #FFB22C;">
                            <img src="{{ asset('img/meeting-room.jpg') }}" alt="Meeting Room" style="width: 100%; height: 160px; object-fit: cover;">
                            <div class="p-2">
                                <h6 class="fw-bold mb-1 text-dark">Meeting Room</h6>
                                <p class="mb-1 small text-dark">20–25 orang</p>
                                <p class="mb-2 small text-dark">Diskusi & rapat</p>
                                <span class="badge bg-dark">Klik untuk Reservasi</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Indoor AC --}}
                <div class="col-12 col-sm-6 col-lg-2" style="min-width: 200px;">
                    <a href="{{ route('reservasi.index', ['ruangan' => 3]) }}" class="text-decoration-none">
                        <div class="rounded-4 shadow-sm overflow-hidden text-center area-card" style="background-color: #FFB22C;">
                            <img src="{{ asset('img/indoor-ac.jpg') }}" alt="Indoor AC" style="width: 100%; height: 160px; object-fit: cover;">
                            <div class="p-2">
                                <h6 class="fw-bold mb-1 text-dark">Indoor AC</h6>
                                <p class="mb-1 small text-dark">30–40 orang</p>
                                <p class="mb-2 small text-dark">Sejuk & nyaman</p>
                                <span class="badge bg-dark">Klik untuk Reservasi</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Backyard Outdoor --}}
                <div class="col-12 col-sm-6 col-lg-2" style="min-width: 200px;">
                    <a href="{{ route('reservasi.index', ['ruangan' => 4]) }}" class="text-decoration-none">
                        <div class="rounded-4 shadow-sm overflow-hidden text-center area-card" style="background-color: #FFB22C;">
                            <img src="{{ asset('img/backyard-outdoor.jpg') }}" alt="Backyard Outdoor" style="width: 100%; height: 160px; object-fit: cover;">
                            <div class="p-2">
                                <h6 class="fw-bold mb-1 text-dark">Backyard Outdoor</h6>
                                <p class="mb-1 small text-dark">40–50 orang</p>
                                <p class="mb-2 small text-dark">Outdoor asri</p>
                                <span class="badge bg-dark">Klik untuk Reservasi</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Indoor Non-AC --}}
                <div class="col-12 col-sm-6 col-lg-2" style="min-width: 200px;">
                    <a href="{{ route('reservasi.index', ['ruangan' => 5]) }}" class="text-decoration-none">
                        <div class="rounded-4 shadow-sm overflow-hidden text-center area-card" style="background-color: #FFB22C;">
                            <img src="{{ asset('img/indoor-nonac.jpg') }}" alt="Indoor Non AC" style="width: 100%; height: 160px; object-fit: cover;">
                            <div class="p-2">
                                <h6 class="fw-bold mb-1 text-dark">Indoor Non-AC</h6>
                                <p class="mb-1 small text-dark">25–30 orang</p>
                                <p class="mb-2 small text-dark">Klasik alami</p>
                                <span class="badge bg-dark">Klik untuk Reservasi</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Kenapa Harus Hanoman -->
    <section class="py-5" style="background-color: #ffffff;">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Kenapa Harus Hanoman?</h2>
            <p class="mb-5">Karena kami menyediakan fasilitas lengkap yang mendukung kenyamanan Anda.</p>

            <div class="row justify-content-center g-4">
                {{-- LCD Proyektor --}}
                <div class="col-6 col-md-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                         style="width: 120px; height: 120px; background-color: #FFB22C; overflow: hidden;">
                        <img src="{{ asset('img/proyektor.png') }}" alt="LCD Proyektor" style="width: 60%; height: auto;">
                    </div>
                    <p class="mt-3 fw-semibold">LCD Proyektor</p>
                </div>

                {{-- Smart TV --}}
                <div class="col-6 col-md-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                         style="width: 120px; height: 120px; background-color: #FFB22C; overflow: hidden;">
                        <img src="{{ asset('img/tv.png') }}" alt="Smart TV" style="width: 60%; height: auto;">
                    </div>
                    <p class="mt-3 fw-semibold">Smart TV</p>
                </div>

                {{-- Free Wi-Fi --}}
                <div class="col-6 col-md-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                         style="width: 120px; height: 120px; background-color: #FFB22C; overflow: hidden;">
                        <img src="{{ asset('img/wifi.jpg') }}" alt="Free Wi-Fi" style="width: 60%; height: auto;">
                    </div>
                    <p class="mt-3 fw-semibold">Free Wi-Fi</p>
                </div>

                {{-- Sound System --}}
                <div class="col-6 col-md-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center shadow-sm"
                         style="width: 120px; height: 120px; background-color: #FFB22C; overflow: hidden;">
                        <img src="{{ asset('img/sound.jpg') }}" alt="Sound System" style="width: 60%; height: auto;">
                    </div>
                    <p class="mt-3 fw-semibold">Sound System</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Event -->
    <section class="py-5" style="background-color: #FFB22C;">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Event di Ndalem Hanoman</h2>

            <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>

                <div class="carousel-inner">

                    <!-- Slide 1: Pekan Hanoman -->
                    <div class="carousel-item active">
                        <div class="row d-md-flex align-items-center">
                            <div class="col-md-6 text-center mb-4 mb-md-0">
                                <img src="{{ asset('img/pekan.png') }}" alt="Pekan Hanoman" class="img-fluid" style="max-height: 360px; object-fit: contain;">
                            </div>
                            <div class="col-md-6">
                                <h4 class="fw-bold text-dark">Pekan Hanoman 2024 is Here!</h4>
                                <p class="text-dark">Siapkan diri kamu untuk menikmati akhir pekan seru di Ndalem Hanoman pada tanggal <strong>31 Agustus - 1 September 2024</strong>. Acara ini akan dipenuhi dengan tenant kreatif, penampilan menarik, fun run, dan workshop foto analog!</p>
                                <p>🎉 Open gate mulai pukul <strong>08.00 pagi</strong> hingga selesai. Jangan lewatkan kesempatan eksplorasi produk, penampilan seru, dan berbagai kegiatan menarik bersama teman-teman.</p>
                                <p><strong>Sampai jumpa di Pekan Hanoman!</strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Workshop Foto Analog -->
                    <div class="carousel-item">
                        <div class="row d-md-flex align-items-center">
                            <div class="col-md-6 text-center mb-4 mb-md-0">
                                <img src="{{ asset('img/analog.png') }}" alt="Workshop Foto Analog" class="img-fluid" style="max-height: 360px; object-fit: contain;">
                            </div>
                            <div class="col-md-6">
                                <h4 class="fw-bold text-dark">Workshop Foto Analog & Hunting</h4>
                                <p class="text-dark">Siapa nih yang punya film dari foto analog bagus, tapi bingung mau cetaknya gimana? Yuk ikutan workshop bareng <strong>@analogkanaja</strong>, <strong>@koyopasar</strong>, <strong>@huntingfullsenyum</strong>.</p>
                                <ul class="mb-2">
                                    <li>🗓️ Minggu, 01 September 2024</li>
                                    <li>⏰ 12.00 WIB (Workshop) | 14.00 WIB (Hunting)</li>
                                    <li>📍 Ndalem Hanoman, Lempuyangan</li>
                                    <li>🎟️ HTM Workshop: Rp 50.000 | Hunting: Free!</li>
                                </ul>
                                <p>✨ Peserta workshop dapat <strong>voucher 20% ALL Menu</strong>!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Fun Run -->
                    <div class="carousel-item">
                        <div class="row d-md-flex align-items-center">
                            <div class="col-md-6 text-center mb-4 mb-md-0">
                                <img src="{{ asset('img/funrun.png') }}" alt="Fun Run" class="img-fluid" style="max-height: 360px; object-fit: contain;">
                            </div>
                            <div class="col-md-6">
                                <h4 class="fw-bold text-dark">Jelajah Kampung Wisata - Fun Run 2024</h4>
                                <p class="text-dark">👋 Hai Runners! Yuk gabung di <strong>Fun Run 2024</strong> untuk jelajah kampung wisata bareng komunitas!</p>
                                <ul>
                                    <li>📅 Sabtu, 31 Agustus 2024</li>
                                    <li>⏰ Jam 06.00 WIB</li>
                                    <li>📍 Start & Finish di Ndalem Hanoman</li>
                                </ul>
                                <p>🎟️ <strong>GRATIS!</strong> Untuk pendaftaran cek link di bio yaa... Terima kasih 😊</p>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 4: Merdeka Run -->
                    <div class="carousel-item">
                        <div class="row d-md-flex align-items-center">
                            <div class="col-md-6 text-center mb-4 mb-md-0">
                                <img src="{{ asset('img/merdekarun.png') }}" alt="Merdeka Run" class="img-fluid" style="max-height: 360px; object-fit: contain;">
                            </div>
                            <div class="col-md-6">
                                <h4 class="fw-bold text-dark">Hanoman Merdeka Run 🇮🇩</h4>
                                <p class="text-dark">Persiapkan diri kamu untuk <strong>Merdeka Run</strong>! Rayakan kemerdekaan RI dengan lari penuh semangat dan lomba seru!</p>
                                <ul>
                                    <li>📅 Sabtu, 17 Agustus 2024</li>
                                    <li>⏰ Start jam 06.00 WIB</li>
                                    <li>📍 Start & Finish di Ndalem Hanoman</li>
                                </ul>
                                <p>🎉 Ada refreshment, dokumentasi fotografer, dan lomba 17an seru! Ajak teman & keluarga! 🏃‍♀️</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Section Galeri Foto -->
    <section class="py-5 gallery-section">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Galeri Suasana Café</h2>

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
        </div>
    </section>

{{-- Footer --}}
@include('template.footer')

<!-- Bootstrap Bundle JS (wajib untuk carousel) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>