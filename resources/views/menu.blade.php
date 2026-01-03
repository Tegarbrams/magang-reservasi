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
    --gold-primary: #FFB800;
    --gold-light: #FFF4DC;
    --gold-medium: #FFD700;
    --gold-dark: #F4A300;
    --white: #FFFFFF;
    --black: #2C2C2C;
    --gray-50: #FAFAFA;
    --gray-200: #EDEDED;
    --gray-600: #6B6B6B;
    --cream: #FFFEF7;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to bottom, var(--white), var(--cream));
  }

  /* HERO */
  .menu-hero {
    background: linear-gradient(135deg, var(--gold-primary), var(--gold-dark));
    padding: 4.5rem 2rem 3.5rem;
    color: var(--white);
    text-align: center;
  }

  .menu-hero h2 {
    font-size: 2.6rem;
    font-weight: 900;
    margin-bottom: .5rem;
    letter-spacing: -0.5px;
  }

  .menu-hero p {
    opacity: .95;
    font-size: 1.1rem;
  }

  /* FILTER BAR */
  .filter-wrapper {
    background: var(--white);
    border-bottom: 2px solid var(--gold-light);
    padding: 1.4rem 0;
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .btn-light {
    border: 2px solid var(--gold-light);
    color: var(--gray-600);
    font-weight: 700;
    border-radius: 999px;
    padding: .65rem 1.6rem;
    background: var(--white);
    transition: .25s ease;
  }

  .btn-light:hover {
    border-color: var(--gold-primary);
    background: var(--gold-light);
    color: var(--black);
    box-shadow: 0 6px 14px rgba(255, 184, 0, .25);
  }

  .btn-light.active {
    background: var(--gold-primary);
    border-color: var(--gold-primary);
    color: var(--white);
    box-shadow: 0 10px 20px rgba(255, 184, 0, .3);
    transform: translateY(-1px);
  }

  /* MENU SECTION */
  .menu-section {
    padding: 3.5rem 0;
  }

  .card {
    border-radius: 20px;
    background: var(--white);
    border: 2px solid var(--gold-light);
    box-shadow: 0 14px 30px rgba(255, 184, 0, .1);
    transition: .3s ease;
    height: 100%;
  }

  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 32px rgba(255, 184, 0, .25);
  }

  .card-img-top {
    height: 210px;
    object-fit: cover;
  }

  .card-body {
    padding: 1.4rem 1.4rem 1.2rem;
  }

  .card-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 800;
    margin-bottom: .65rem;
  }

  .price-badge {
    background: linear-gradient(135deg, var(--gold-primary), var(--gold-dark));
    padding: .45rem .9rem;
    border-radius: 10px;
    color: var(--white);
    font-weight: 900;
    box-shadow: 0 3px 10px rgba(255, 184, 0, .45);
  }

  .card-text {
    color: var(--gray-600);
    font-size: .92rem;
  }

  /* ANIMATION */
  .menu-item {
    animation: fadeInUp .45s ease forwards;
    opacity: 0;
  }

  @keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 768px) {
    .menu-hero h2 { font-size: 2rem; }
    .card-img-top { height: 180px; }
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