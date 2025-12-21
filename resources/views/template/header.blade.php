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
    .active-link {
      font-weight: bold;
      color: #ff9100 !important;
      border-bottom: 2px solid #ff9100;
    }
    .nav-link {
      padding: 8px 15px;
      transition: all 0.3s ease;
    }
    .nav-link:hover {
      color: #ff9100 !important;
    }
  </style>
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

  <header class="d-flex justify-content-between align-items-center px-4 py-3 shadow-sm" style="background-color: #F7F7F7;">
    <div class="d-flex align-items-center">
      <img src="{{ url('/logo.jpg') }}" alt="Logo" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; margin-right: 10px;">
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
          <a class="nav-link {{ Request::is('reservasi') ? 'active-link' : 'text-dark' }}" href="/reservasi">Reservasi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('login') ? 'active-link' : 'text-dark' }}" href="/login">Login</a>
        </li>
      </ul>
    </nav>
  </header>
