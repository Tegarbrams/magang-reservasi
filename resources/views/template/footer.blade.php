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

  <style>
    :root {
        --gold-primary: #D4AF37;
        --gold-dark: #B8941F;
        --white: #FFFFFF;
        --black: #1A1A1A;
        --gray-100: #F5F5F5;
        --gray-200: #E5E5E5;
        --gray-600: #525252;
        --shadow-md: 0 4px 6px -1px rgba(212, 175, 55, 0.1);
    }

    /* FOOTER */
    footer {
        background: var(--gray-100);
        padding: 3rem 2rem 1.5rem;
        border-top: 1px solid var(--gray-200);
        margin-top: auto;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        margin-bottom: 2rem;
    }

    .footer-info h4 {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--black);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .footer-info p {
        color: var(--gray-600);
        font-size: 0.9375rem;
        margin-bottom: 0.5rem;
        line-height: 1.6;
    }

    .footer-info a {
        color: var(--gray-600);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-info a:hover {
        color: var(--gold-primary);
    }

    .footer-social h5 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--black);
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-links a {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        transition: all 0.2s ease;
        display: block;
    }

    .social-links a:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .social-links img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .footer-bottom {
        border-top: 1px solid var(--gray-200);
        padding-top: 1.5rem;
        text-align: center;
        color: var(--gray-600);
        font-size: 0.875rem;
    }

    .footer-bottom strong {
        color: var(--black);
        font-weight: 600;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        footer {
            padding: 2rem 1rem 1rem;
        }

        .footer-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .footer-social {
            text-align: left;
        }

        .social-links {
            justify-content: flex-start;
        }
    }
</style>

</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

  <!-- Konten Halaman Login -->
  <main class="flex-fill">
    @yield('content')
  </main>

  <!-- Footer -->
 <footer>
    <div class="footer-container" id="footer">
        <div class="footer-grid">
            <div class="footer-info">
                <h4>Café Ndalem Hanoman</h4>
                <p>Daerah Istimewa Yogyakarta</p>
                <p>Jl. Mas Suharto No.46, Tegal Panggung, Kec. Danurejan</p>
                <p>Telepon: <a href="tel:08954598564">08954598564</a></p>
                <p>Email: <a href="mailto:ndalemhanomanyk@gmail.com">ndalemhanomanyk@gmail.com</a></p>
            </div>
            <div class="footer-social">
                <h5>Ikuti Kami</h5>
                <div class="social-links">
                    <a href="https://www.instagram.com/ndalemhanoman" target="_blank" title="Instagram">
                        <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
                    </a>
                    <a href="https://wa.me/628954598564" target="_blank" title="WhatsApp">
                        <img src="{{ asset('img/whatsapp.png') }}" alt="WhatsApp">
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} <strong>Café Ndalem Hanoman</strong>. All rights reserved.</p>
        </div>
    </div>
</footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
