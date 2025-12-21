<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Café Ndalem Hanoman - Login</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

  <!-- Konten Halaman Login -->
  <main class="flex-fill">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer style="background-color: #EDEDED; padding: 60px 0 30px; color: #333;">
    <div class="container">
      <div class="row gy-4 justify-content-between">

        <!-- Info Café -->
        <div class="col-lg-6 col-md-6">
          <h4 class="fw-bold mb-3 text-uppercase">Café Ndalem Hanoman</h4>
          <p class="mb-1">Daerah Istimewa Yogyakarta</p>
          <p class="mb-1">Jl. Mas Suharto No.46, Tegal Panggung, Kec. Danurejan</p>
          <p class="mb-1">
            Telepon: <a href="tel:08954598564" class="text-decoration-none text-dark">08954598564</a>
          </p>
          <p class="mb-0">
            Email: <a href="mailto:ndalemhanomanyk@gmail.com" class="text-decoration-none text-dark">ndalemhanomanyk@gmail.com</a>
          </p>
        </div>

        <!-- Social Media -->
        <div class="col-lg-4 col-md-6 text-md-end text-start">
          <h5 class="fw-semibold mb-3">Ikuti Kami</h5>
          <div class="d-flex justify-content-md-end justify-content-start gap-3">
            <a href="https://www.instagram.com/ndalemhanoman" target="_blank" title="Instagram">
              <img src="{{ asset('img/instagram.png') }}" alt="Instagram" width="36" height="36" style="border-radius: 50%;">
            </a>
            <a href="https://wa.me/628954598564" target="_blank" title="WhatsApp">
              <img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp" width="36" height="36" style="border-radius: 50%;">
            </a>
          </div>
        </div>
      </div>

      <hr class="my-4" style="border-color: #bbb;">
      <div class="text-center" style="font-size: 14px; color: #666;">
        &copy; {{ date('Y') }} <strong>Café Ndalem Hanoman</strong>. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
