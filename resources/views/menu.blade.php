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
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }
    
    .btn-light {
      border: 2px solid #fff;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-light:hover {
      background-color: #fff;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-light.active {
      background-color: #fff;
      color: #FFB22C;
      border-color: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .card {
      border: none;
      border-radius: 15px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .card-img-top {
      border-bottom: 3px solid #FFB22C;
    }
    
    .card-title {
      color: #333;
      font-size: 1rem;
      font-weight: 700;
    }
    
    .card-title span {
      color: #FFB22C;
      font-weight: 800;
    }
    
    .card-text {
      color: #666;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

@include('template.header')

<section class="py-5" style="background-color: #FFB22C;">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold text-dark">Menu Café Ndalem Hanoman</h2>

    <!-- Filter Kategori -->
    <div class="text-center mb-4">
      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <button type="button" class="btn btn-light active" onclick="filterMenu('wedangan')">Wedangan</button>
        <button type="button" class="btn btn-light" onclick="filterMenu('espresso')">Espresso Based</button>
        <button type="button" class="btn btn-light" onclick="filterMenu('snack')">Snack</button>
      </div>
    </div>

    <!-- Menu Grid -->
    <div class="row" id="menu-container">

      <!-- Menu Wedangan -->
      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-laksmana.jpg') }}" class="card-img-top" alt="Wedang Laksmana" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Laksmana <span class="float-end">12K</span></h5>
            <p class="card-text">Jahe, Vanila, dan Jeruk Nipis</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-bharata.jpg') }}" class="card-img-top" alt="Wedang Bharata" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Bharata <span class="float-end">12K</span></h5>
            <p class="card-text">Teh, Jahe, Vanila, Kayu Manis</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-jeruk.jpg') }}" class="card-img-top" alt="Wedang Jeruk" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Jeruk <span class="float-end">7K</span></h5>
            <p class="card-text">Jeruk Peras Khas Hanoman</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-anjani.jpg') }}" class="card-img-top" alt="Wedang Teh Anjani" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Teh Anjani <span class="float-end">5K</span></h5>
            <p class="card-text">Teh Khas Ndalem Hanoman</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-dewi-sri.jpg') }}" class="card-img-top" alt="Wedang Dewi Sri" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Dewi Sri <span class="float-end">15K</span></h5>
            <p class="card-text">Jeruk, Susu, dan Sereh</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-anila.jpg') }}" class="card-img-top" alt="Wedang Anila" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Anila <span class="float-end">15K</span></h5>
            <p class="card-text">Jahe, Susu, Kayu Manis</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item wedangan">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/wedang-aswanikumba.jpg') }}" class="card-img-top" alt="Wedang Aswanikumba" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Wedang Aswanikumba <span class="float-end">13K</span></h5>
            <p class="card-text">Teh, Jahe, dan Susu</p>
          </div>
        </div>
      </div>

      <!-- Menu Espresso -->
      <div class="col-md-3 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/daren.jpg') }}" class="card-img-top" alt="Daren" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Daren <span class="float-end">18K</span></h5>
            <p class="card-text">Espresso, Secret Milk dan Whipcream</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/aren.jpg') }}" class="card-img-top" alt="Aren" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Aren <span class="float-end">18K</span></h5>
            <p class="card-text">Espresso, Susu Segar dan Gula Aren</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/cap.jpg') }}" class="card-img-top" alt="Cappucino" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Cappucino <span class="float-end">18K</span></h5>
            <p class="card-text">Espresso dan Susu Segar</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/vanila.jpg') }}" class="card-img-top" alt="Vanila Latte" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Vanila Latte <span class="float-end">18K</span></h5>
            <p class="card-text">Espresso Susu Segar dan Vanila</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item espresso" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/caffelatte.jpg') }}" class="card-img-top" alt="Caffe Latte" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Caffe Latte <span class="float-end">18K</span></h5>
            <p class="card-text">Espresso dan Susu Segar</p>
          </div>
        </div>
      </div>

      <!-- Menu Snack -->
      <div class="col-md-3 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/d.jpg') }}" class="card-img-top" alt="Dimsum" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Dimsum <span class="float-end">15K</span></h5>
            <p class="card-text">Dimsum Ayam</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/o.jpg') }}" class="card-img-top" alt="Otak-otak" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Otak-otak <span class="float-end">20K</span></h5>
            <p class="card-text">Otak-otak Instan</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/p.jpg') }}" class="card-img-top" alt="Pisang Goreng" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Pisang Goreng <span class="float-end">20K</span></h5>
            <p class="card-text">Pisang goreng dengan adonan manis</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/g.jpg') }}" class="card-img-top" alt="Gemblong Cotot" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Gemblong Cotot <span class="float-end">20K</span></h5>
            <p class="card-text">Olahan Singkong Lembut Diisi Gula Manis</p>
          </div>
        </div>
      </div>

      <div class="col-md-3 col-sm-6 mb-4 menu-item snack" style="display: none;">
        <div class="card shadow h-100 bg-white">
          <img src="{{ asset('img/k.jpg') }}" class="card-img-top" alt="Kentang Goreng" style="height: 180px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">Kentang Goreng <span class="float-end">20K</span></h5>
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
  // Sembunyikan semua menu
  document.querySelectorAll('.menu-item').forEach(item => {
    item.style.display = 'none';
  });
  
  // Tampilkan menu sesuai kategori
  document.querySelectorAll('.' + category).forEach(item => {
    item.style.display = 'block';
  });

  // Update tombol aktif
  document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
  const activeBtn = Array.from(document.querySelectorAll('.btn'))
    .find(btn => btn.textContent.toLowerCase().includes(category));
  if (activeBtn) activeBtn.classList.add('active');
}

// Set default tampilan saat halaman dimuat
window.onload = () => {
  filterMenu('wedangan');
};
</script>

</body>
</html>