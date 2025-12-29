<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Menu - Café Ndalem Hanoman</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    :root {
      --gold-primary: #D4AF37;
      --gold-light: #F4E5C3;
      --gold-dark: #B8941F;
      --orange: #FFB22C;
      --white: #FFFFFF;
      --black: #1A1A1A;
      --gray-50: #FAFAFA;
      --gray-600: #525252;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    /* Hero Section */
    .menu-hero {
      background: linear-gradient(135deg, var(--gold-primary), var(--gold-dark));
      padding: 4rem 2rem 3rem;
      text-align: center;
      color: var(--white);
      margin-bottom: 0;
    }

    .menu-hero h2 {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
      letter-spacing: -0.02em;
    }

    .menu-hero p {
      font-size: 1.125rem;
      opacity: 0.95;
      margin-bottom: 0;
    }

    /* Filter Section */
    .filter-wrapper {
      background: var(--orange);
      padding: 2rem 0;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .btn-light {
      border: 2px solid #fff;
      background: rgba(255, 255, 255, 0.2);
      color: var(--white);
      font-weight: 600;
      padding: 0.75rem 2rem;
      border-radius: 50px;
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
    }

    .btn-light:hover {
      background-color: #fff;
      color: var(--orange);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .btn-light.active {
      background-color: #fff;
      color: var(--orange);
      border-color: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      transform: scale(1.05);
    }

    /* Menu Section */
    .menu-section {
      background: var(--gray-50);
      padding: 3rem 0;
      min-height: 60vh;
    }

    .card {
      border: none;
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      height: 100%;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 24px rgba(212, 175, 55, 0.2);
    }

    .card-img-top {
      height: 220px;
      object-fit: cover;
      border-bottom: 3px solid var(--gold-primary);
      transition: transform 0.3s ease;
    }

    .card:hover .card-img-top {
      transform: scale(1.05);
    }

    .card-body {
      padding: 1.5rem;
    }

    .card-title {
      color: var(--black);
      font-size: 1.125rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 0.5rem;
    }

    .card-title .menu-name {
      flex: 1;
    }

    .card-title .price-badge {
      background: linear-gradient(135deg, var(--gold-light), var(--gold-primary));
      color: var(--gold-dark);
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: 800;
      white-space: nowrap;
      box-shadow: 0 2px 4px rgba(212, 175, 55, 0.3);
    }

    .card-text {
      color: var(--gray-600);
      font-size: 0.9rem;
      line-height: 1.6;
    }

    /* Animation */
    .menu-item {
      animation: fadeInUp 0.5s ease forwards;
      opacity: 0;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Stagger animation */
    .menu-item:nth-child(1) { animation-delay: 0.1s; }
    .menu-item:nth-child(2) { animation-delay: 0.2s; }
    .menu-item:nth-child(3) { animation-delay: 0.3s; }
    .menu-item:nth-child(4) { animation-delay: 0.4s; }
    .menu-item:nth-child(5) { animation-delay: 0.5s; }
    .menu-item:nth-child(6) { animation-delay: 0.6s; }
    .menu-item:nth-child(7) { animation-delay: 0.7s; }
    .menu-item:nth-child(8) { animation-delay: 0.8s; }

    /* Responsive */
    @media (max-width: 768px) {
      .menu-hero h2 {
        font-size: 2rem;
      }

      .card-title {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
      }

      .card-title .price-badge {
        align-self: flex-end;
      }

      .btn-light {
        padding: 0.625rem 1.5rem;
        font-size: 0.9rem;
      }
    }

    @media (max-width: 576px) {
      .card-img-top {
        height: 180px;
      }

      .menu-hero {
        padding: 2rem 1rem;
      }

      .menu-hero h2 {
        font-size: 1.75rem;
      }
    }
  </style>
</head>
<body>

@include('template.header')

<!-- Hero Section -->
<div class="menu-hero">
  <h2>Menu Café Ndalem Hanoman</h2>
  <p>Nikmati berbagai pilihan wedangan, espresso, dan snack khas kami</p>
</div>

<!-- Filter Section -->
<div class="filter-wrapper">
  <div class="container">
    <div class="text-center">
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <button type="button" class="btn btn-light active" onclick="filterMenu('wedangan')">Wedangan</button>
        <button type="button" class="btn btn-light" onclick="filterMenu('espresso')">Espresso Based</button>
        <button type="button" class="btn btn-light" onclick="filterMenu('snack')">Snack</button>
      </div>
    </div>
  </div>
</div>

<!-- Menu Section -->
<section class="menu-section">
  <div class="container">
    <div class="row" id="menu-container">

      <!-- Menu Wedangan -->
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-laksmana.jpg') }}" class="card-img-top" alt="Wedang Laksmana">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Laksmana</span>
              <span class="price-badge">12K</span>
            </h5>
            <p class="card-text">Jahe, Vanila, dan Jeruk Nipis</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-bharata.jpg') }}" class="card-img-top" alt="Wedang Bharata">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Bharata</span>
              <span class="price-badge">12K</span>
            </h5>
            <p class="card-text">Teh, Jahe, Vanila, Kayu Manis</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-jeruk.jpg') }}" class="card-img-top" alt="Wedang Jeruk">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Jeruk</span>
              <span class="price-badge">7K</span>
            </h5>
            <p class="card-text">Jeruk Peras Khas Hanoman</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-anjani.jpg') }}" class="card-img-top" alt="Wedang Teh Anjani">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Teh Anjani</span>
              <span class="price-badge">5K</span>
            </h5>
            <p class="card-text">Teh Khas Ndalem Hanoman</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-dewi-sri.jpg') }}" class="card-img-top" alt="Wedang Dewi Sri">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Dewi Sri</span>
              <span class="price-badge">15K</span>
            </h5>
            <p class="card-text">Jeruk, Susu, dan Sereh</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-anila.jpg') }}" class="card-img-top" alt="Wedang Anila">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Anila</span>
              <span class="price-badge">15K</span>
            </h5>
            <p class="card-text">Jahe, Susu, Kayu Manis</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/wedang-aswanikumba.jpg') }}" class="card-img-top" alt="Wedang Aswanikumba">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Wedang Aswanikumba</span>
              <span class="price-badge">13K</span>
            </h5>
            <p class="card-text">Teh, Jahe, dan Susu</p>
          </div>
        </div>
      </div>

      <!-- Menu Espresso -->
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/daren.jpg') }}" class="card-img-top" alt="Daren">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Daren</span>
              <span class="price-badge">18K</span>
            </h5>
            <p class="card-text">Espresso, Secret Milk dan Whipcream</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/aren.jpg') }}" class="card-img-top" alt="Aren">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Aren</span>
              <span class="price-badge">18K</span>
            </h5>
            <p class="card-text">Espresso, Susu Segar dan Gula Aren</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/cap.jpg') }}" class="card-img-top" alt="Cappucino">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Cappucino</span>
              <span class="price-badge">18K</span>
            </h5>
            <p class="card-text">Espresso dan Susu Segar</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/vanila.jpg') }}" class="card-img-top" alt="Vanila Latte">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Vanila Latte</span>
              <span class="price-badge">18K</span>
            </h5>
            <p class="card-text">Espresso Susu Segar dan Vanila</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/caffelatte.jpg') }}" class="card-img-top" alt="Caffe Latte">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Caffe Latte</span>
              <span class="price-badge">18K</span>
            </h5>
            <p class="card-text">Espresso dan Susu Segar</p>
          </div>
        </div>
      </div>

      <!-- Menu Snack -->
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/d.jpg') }}" class="card-img-top" alt="Dimsum">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Dimsum</span>
              <span class="price-badge">15K</span>
            </h5>
            <p class="card-text">Dimsum Ayam</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/o.jpg') }}" class="card-img-top" alt="Otak-otak">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Otak-otak</span>
              <span class="price-badge">20K</span>
            </h5>
            <p class="card-text">Otak-otak Instan</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/p.jpg') }}" class="card-img-top" alt="Pisang Goreng">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Pisang Goreng</span>
              <span class="price-badge">20K</span>
            </h5>
            <p class="card-text">Pisang goreng dengan adonan manis</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/g.jpg') }}" class="card-img-top" alt="Gemblong Cotot">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Gemblong Cotot</span>
              <span class="price-badge">20K</span>
            </h5>
            <p class="card-text">Olahan Singkong Lembut Diisi Gula Manis</p>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-4 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow bg-white">
          <img src="{{ asset('img/k.jpg') }}" class="card-img-top" alt="Kentang Goreng">
          <div class="card-body">
            <h5 class="card-title">
              <span class="menu-name">Kentang Goreng</span>
              <span class="price-badge">20K</span>
            </h5>
            <p class="card-text">Olahan Kentang Crinkle</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

@include('template.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function filterMenu(category) {
  // Ambil semua tombol filter
  const buttons = document.querySelectorAll('.btn-light');
  buttons.forEach(btn => btn.classList.remove('active'));
  
  // Tandai tombol yang diklik sebagai active
  event.target.classList.add('active');
  
  // Ambil semua item menu
  const menuItems = document.querySelectorAll('.menu-item');
  
  // Hide semua item terlebih dahulu
  menuItems.forEach(item => {
    item.style.display = 'none';
    item.style.animation = 'none';
  });
  
  // Show item yang sesuai dengan kategori
  const selectedItems = document.querySelectorAll(`.menu-item.${category}`);
  selectedItems.forEach((item, index) => {
    item.style.display = 'block';
    // Reset animation
    void item.offsetWidth; // Trigger reflow
    item.style.animation = `fadeInUp 0.5s ease forwards ${index * 0.1}s`;
  });
}

// Set default tampilan saat halaman dimuat
window.onload = () => {
  filterMenu('wedangan');
};
</script>

</body>
</html>