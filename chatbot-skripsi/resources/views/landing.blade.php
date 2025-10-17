<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktik Bidan - NusaBERT Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --accent-color: #0dcaf0;
            --success-color: #198754;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,138.7C960,139,1056,117,1152,112C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .btn-hero {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-hero-primary {
            background: white;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            color: #667eea;
        }

        .btn-hero-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-hero-outline:hover {
            background: white;
            color: #667eea;
            transform: translateY(-3px);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .feature-description {
            color: #6c757d;
            line-height: 1.8;
        }

        /* About Section */
        .about-section {
            padding: 80px 0;
            background: white;
        }

        .about-img {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        /* Services Section */
        .services-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .service-item {
            padding: 25px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .service-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(10px);
        }

        .service-icon {
            font-size: 2rem;
            margin-right: 15px;
            color: #ffd700;
        }

        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: #f8f9fa;
            text-align: center;
        }

        .cta-box {
            background: white;
            border-radius: 15px;
            padding: 60px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        /* Footer */
        .footer {
            background: #2c3e50;
            color: white;
            padding: 40px 0 20px;
        }

        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #667eea;
        }

        .footer-social {
            font-size: 1.5rem;
        }

        .footer-social a {
            margin: 0 10px;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .footer-social a:hover {
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="bi bi-heart-pulse-fill me-2"></i>
                Praktik Bidan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/login">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content animate-fade-in-up">
                    <h1 class="hero-title">
                        Konsultasi Kesehatan <br>dengan Chatbot AI
                    </h1>
                    <p class="hero-subtitle">
                        Dapatkan informasi kesehatan ibu dan anak secara cepat dan akurat dengan teknologi NusaBERT AI
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/login" class="btn-hero btn-hero-primary">
                            <i class="bi bi-chat-dots me-2"></i>
                            Mulai Konsultasi
                        </a>
                        <a href="#fitur" class="btn-hero btn-hero-outline">
                            <i class="bi bi-info-circle me-2"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <div class="hero-image animate-fade-in-up" style="animation-delay: 0.2s;">
                        <i class="bi bi-robot" style="font-size: 15rem; opacity: 0.9;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title d-inline-block">Fitur Unggulan</h2>
                <p class="section-subtitle mt-3">
                    Teknologi AI terdepan untuk membantu konsultasi kesehatan Anda
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <h3 class="feature-title">Chatbot AI Cerdas</h3>
                        <p class="feature-description">
                            Chatbot berbasis NusaBERT yang dapat menjawab pertanyaan seputar kesehatan ibu dan anak
                            dengan bahasa Indonesia yang natural
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h3 class="feature-title">Tersedia 24/7</h3>
                        <p class="feature-description">
                            Akses konsultasi kapan saja dan dimana saja tanpa perlu antri atau menunggu jadwal praktek
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Aman & Terpercaya</h3>
                        <p class="feature-description">
                            Data pribadi dan riwayat konsultasi Anda dijaga kerahasiaannya dengan sistem keamanan
                            terbaik
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-journal-medical"></i>
                        </div>
                        <h3 class="feature-title">Riwayat Konsultasi</h3>
                        <p class="feature-description">
                            Simpan dan akses kembali semua riwayat percakapan dan konsultasi Anda dengan mudah
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h3 class="feature-title">Respons Cepat</h3>
                        <p class="feature-description">
                            Dapatkan jawaban instan untuk pertanyaan Anda tanpa harus menunggu lama
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-translate"></i>
                        </div>
                        <h3 class="feature-title">Bahasa Indonesia</h3>
                        <p class="feature-description">
                            Interface dan respon dalam Bahasa Indonesia yang mudah dipahami oleh semua kalangan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="text-center">
                        <i class="bi bi-hospital" style="font-size: 20rem; color: #667eea; opacity: 0.8;"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">Tentang Praktik Bidan</h2>
                    <p class="section-subtitle">
                        Solusi Digital untuk Kesehatan Ibu dan Anak
                    </p>
                    <p class="mb-4">
                        Praktik Bidan adalah platform konsultasi kesehatan digital yang menggabungkan pengalaman
                        praktisi kesehatan dengan teknologi Artificial Intelligence terkini. Kami hadir untuk memudahkan
                        masyarakat dalam mendapatkan informasi kesehatan yang akurat dan terpercaya.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.5rem;"></i>
                                <span>Konsultasi Profesional</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.5rem;"></i>
                                <span>Teknologi AI Terbaru</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.5rem;"></i>
                                <span>Privacy Terjamin</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success me-2" style="font-size: 1.5rem;"></i>
                                <span>Mudah Digunakan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="layanan" class="services-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title d-inline-block text-white" style="border-bottom-color: white;">
                    Layanan Konsultasi
                </h2>
                <p class="section-subtitle text-white mt-3">
                    Berbagai topik kesehatan yang dapat Anda konsultasikan
                </p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="service-item">
                        <i class="bi bi-heart-pulse service-icon"></i>
                        <div>
                            <h5 class="mb-2">Kesehatan Ibu Hamil</h5>
                            <p class="mb-0">Konsultasi seputar kehamilan, nutrisi ibu hamil, dan persiapan persalinan
                            </p>
                        </div>
                    </div>
                    <div class="service-item">
                        <i class="bi bi-emoji-smile service-icon"></i>
                        <div>
                            <h5 class="mb-2">Tumbuh Kembang Anak</h5>
                            <p class="mb-0">Informasi tentang pertumbuhan dan perkembangan anak serta imunisasi</p>
                        </div>
                    </div>
                    <div class="service-item">
                        <i class="bi bi-capsule service-icon"></i>
                        <div>
                            <h5 class="mb-2">Kesehatan Reproduksi</h5>
                            <p class="mb-0">Edukasi dan konsultasi mengenai kesehatan reproduksi wanita</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-item">
                        <i class="bi bi-person-hearts service-icon"></i>
                        <div>
                            <h5 class="mb-2">KB & Keluarga Berencana</h5>
                            <p class="mb-0">Informasi lengkap tentang kontrasepsi dan program KB</p>
                        </div>
                    </div>
                    <div class="service-item">
                        <i class="bi bi-droplet service-icon"></i>
                        <div>
                            <h5 class="mb-2">ASI & Menyusui</h5>
                            <p class="mb-0">Panduan menyusui, manajemen ASI, dan solusi masalah menyusui</p>
                        </div>
                    </div>
                    <div class="service-item">
                        <i class="bi bi-clipboard2-pulse service-icon"></i>
                        <div>
                            <h5 class="mb-2">Pemeriksaan Rutin</h5>
                            <p class="mb-0">Informasi jadwal dan jenis pemeriksaan kesehatan rutin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box">
                <h2 class="mb-4">Siap Memulai Konsultasi?</h2>
                <p class="lead mb-4">
                    Daftar sekarang dan mulai konsultasi kesehatan Anda dengan chatbot AI kami
                </p>
                <a href="/login" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 50px;">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login Sekarang
                </a>
                <p class="mt-4 text-muted">
                    <small>
                        <i class="bi bi-shield-check me-1"></i>
                        Data Anda aman dan terlindungi
                    </small>
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">
                        <i class="bi bi-heart-pulse-fill me-2"></i>
                        Praktik Bidan
                    </h5>
                    <p class="text-white-50">
                        Platform konsultasi kesehatan digital dengan teknologi AI untuk membantu kesehatan ibu dan anak.
                    </p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#beranda">Beranda</a></li>
                        <li class="mb-2"><a href="#fitur">Fitur</a></li>
                        <li class="mb-2"><a href="#tentang">Tentang</a></li>
                        <li class="mb-2"><a href="#layanan">Layanan</a></li>
                        <li class="mb-2"><a href="/login">Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Hubungi Kami</h5>
                    <p class="text-white-50">
                        <i class="bi bi-envelope me-2"></i>
                        info@praktikbidan.com
                    </p>
                    <p class="text-white-50">
                        <i class="bi bi-telephone me-2"></i>
                        +62 812-3456-7890
                    </p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-white-50">
                <p class="mb-0">
                    &copy; 2025 Praktik Bidan. Powered by NusaBERT AI. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 70; // navbar height
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(33, 37, 41, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
            } else {
                navbar.style.background = 'rgba(33, 37, 41, 0.8)';
            }
        });

        // Animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .service-item').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>
