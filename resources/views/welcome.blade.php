<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Millennium Academy - Excellence in Education</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a472a; /* Dark Green */
            --primary-dark: #0f2d1a;
            --primary-light: #2d5a3d;
            --secondary: #2c3e50;
            --accent: #f1c40f; /* Yellow */
            --accent-dark: #d4ac0d;
            --light: #f8fafc;
            --gray: #64748b;
            --dark: #1e293b;
            --border-radius: 10px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f9fafb;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header */
        header {
            background: var(--primary);
            color: white;
            padding: 1rem 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.02);
        }

        .logo-img {
            width: 60px;
            height: 60px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 800;
            font-size: 1.5rem;
            box-shadow: 0 0 0 4px rgba(241, 196, 15, 0.3);
        }

        .logo-text h1 {
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--accent);
        }

        .logo-text p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-top: 2px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 1.5rem;
            font-weight: 500;
            transition: var(--transition);
            position: relative;
            padding: 5px 0;
        }

        nav a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            left: 0;
            background-color: var(--accent);
            transition: var(--transition);
            border-radius: 2px;
        }

        nav a:hover {
            color: var(--accent);
        }

        nav a:hover:after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.05"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .hero-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-text {
            max-width: 600px;
        }

        .hero h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            text-decoration: none;
            font-weight: 600;
            padding: 14px 28px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--primary);
            box-shadow: 0 4px 14px rgba(241, 196, 15, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(241, 196, 15, 0.4);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .hero-image {
            position: relative;
            z-index: 1;
            width: 500px;
            height: 350px;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 3px solid rgba(241, 196, 15, 0.3);
        }

        .carousel {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .carousel-inner {
            width: 100%;
            height: 100%;
            position: relative;
        }

        .carousel-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            background-size: cover;
            background-position: center;
            background-color: var(--primary-light);
        }

        .carousel-item.active {
            opacity: 1;
        }

        .carousel-controls {
            position: absolute;
            bottom: 15px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 10px;
            z-index: 10;
        }

        .carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: var(--transition);
        }

        .carousel-dot.active {
            background: var(--accent);
            transform: scale(1.2);
        }

        /* Features Section */
        .features {
            padding: 5rem 5%;
            background: white;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .section-subtitle {
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            display: inline-block;
            padding: 5px 15px;
            background: rgba(26, 71, 42, 0.1);
            border-radius: 30px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--secondary);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            width: 80px;
            height: 4px;
            background: var(--accent);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .section-description {
            color: var(--gray);
            font-size: 1.1rem;
            margin-top: 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: var(--light);
            border-radius: var(--border-radius);
            padding: 40px 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            border-top: 4px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--accent);
            font-size: 32px;
            box-shadow: 0 4px 10px rgba(26, 71, 42, 0.2);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--secondary);
        }

        .feature-card p {
            color: var(--gray);
            margin-bottom: 20px;
        }

        /* Courses Section */
        .courses {
            padding: 5rem 5%;
            background: var(--light);
            position: relative;
        }

        .courses::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.03"><polygon fill="%231a472a" points="0,0 1000,1000 0,1000"/></svg>');
            background-size: cover;
        }

        .search-bar {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            z-index: 1;
        }

        .search-bar input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 50px;
            outline: none;
            font-size: 1rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .search-bar input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 71, 42, 0.1);
        }

        .search-bar i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            position: relative;
            z-index: 1;
        }

        .course-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid #e5e7eb;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .course-header {
            background: var(--primary);
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .course-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: rgba(241, 196, 15, 0.2);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .course-header h4 {
            font-size: 1.3rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .course-body {
            padding: 1.5rem;
        }

        .course-body p {
            color: var(--gray);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .course-features {
            list-style: none;
            margin-bottom: 1.5rem;
        }

        .course-features li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .course-features i {
            color: var(--primary);
            font-size: 0.8rem;
        }

        .course-price {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 1.5rem;
        }

        .course-price span {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--gray);
        }

        .course-btn {
            display: block;
            text-align: center;
            background: var(--primary);
            color: white;
            padding: 12px;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .course-btn:hover {
            background: var(--primary-dark);
        }

        /* How It Works Section */
        .how-it-works {
            padding: 5rem 5%;
            background: white;
        }

        .steps {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: var(--primary-light);
            z-index: 1;
        }

        .step {
            text-align: center;
            position: relative;
            z-index: 2;
            flex: 1;
            max-width: 200px;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            box-shadow: var(--shadow);
            border: 3px solid white;
            position: relative;
        }

        .step-number::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid var(--accent);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .step h4 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: var(--secondary);
        }

        .step p {
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Pricing Section */
        .pricing {
            padding: 5rem 5%;
            background: var(--light);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .pricing-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            position: relative;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .pricing-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
        }

        .pricing-card.featured {
            border: 2px solid var(--primary);
            transform: scale(1.05);
        }

        .pricing-card.featured::after {
            content: 'Most Popular';
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--accent);
            color: var(--primary);
            padding: 5px 30px;
            font-size: 0.8rem;
            font-weight: 700;
            transform: rotate(45deg);
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .pricing-card.featured:hover {
            transform: translateY(-10px) scale(1.05);
        }

        .pricing-header {
            margin-bottom: 2rem;
        }

        .pricing-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .pricing-period {
            color: var(--gray);
            font-size: 0.9rem;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 2rem;
        }

        .pricing-features li {
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--gray);
        }

        .pricing-features i {
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 4rem 5% 2rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.03"><polygon fill="white" points="0,0 1000,1000 0,1000"/></svg>');
            background-size: cover;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 3px;
            background: var(--accent);
            bottom: 0;
            left: 0;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-links a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #cbd5e1;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--accent);
            color: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
            background: none;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 1100px) {
            .hero h2 {
                font-size: 2.5rem;
            }

            .hero-image {
                width: 450px;
            }
        }

        @media (max-width: 1000px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }

            .hero-text {
                max-width: 100%;
                margin-bottom: 3rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .steps {
                flex-direction: column;
                align-items: center;
                gap: 3rem;
            }

            .steps::before {
                display: none;
            }

            .step {
                max-width: 100%;
            }

            .pricing-card.featured {
                transform: scale(1);
            }

            .pricing-card.featured:hover {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            nav {
                display: none;
                width: 100%;
                flex-direction: column;
                background: var(--primary);
                position: absolute;
                top: 100%;
                left: 0;
                text-align: left;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                padding: 20px 5%;
                gap: 0;
            }

            nav.active {
                display: flex;
            }

            nav a {
                margin: 0;
                padding: 12px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .hero h2 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .btn {
                padding: 12px 24px;
            }

            .grid, .features-grid, .pricing-grid {
                grid-template-columns: 1fr;
            }

            .hero-image {
                width: 100%;
                max-width: 450px;
                height: 300px;
            }
        }

        @media (max-width: 600px) {
            .hero h2 {
                font-size: 1.8rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .btn {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }

            .hero-image {
                height: 250px;
            }

            .logo-text h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <div class="logo-img">MA</div>
            <div class="logo-text">
                <h1>Millennium <span>Academy</span></h1>
                <p>Excellence in Education</p>
            </div>
        </div>

        <button class="menu-toggle" id="mobile-menu">
            <i class="fas fa-bars"></i>
        </button>

        <nav id="main-nav">
            <a href="#features">Features</a>
            <a href="#courses">Courses</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#pricing">Pricing</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            @endif
        </nav>
    </header>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h2>Empowering Learners for a Brighter Future</h2>
                <p>Access flexible, high-quality education tailored to your needs. Learn at your own pace with expert instructors and comprehensive resources.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-user-plus"></i> Enroll Now</a>
                    <a href="#courses" class="btn btn-secondary"><i class="fas fa-book"></i> Explore Courses</a>
                </div>
            </div>
            <div class="hero-image">
                <div class="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="background-image: url('images/1.jpg');"></div>
                        <div class="carousel-item" style="background-image: url('images/2.jpg');"></div>
                        <div class="carousel-item" style="background-image: url('images/3.jpg');"></div>
                        <div class="carousel-item" style="background-image: url('images/4.jpg');"></div>
                        <div class="carousel-item" style="background-image: url('images/5.jpg');"></div>
                        <div class="carousel-item" style="background-image: url('images/6.jpg');"></div>
                        <div class="carousel-item" style="background-image: url('images/7.jpg');"></div>
                    </div>
                    <div class="carousel-controls">
                        <div class="carousel-dot active" data-index="0"></div>
                        <div class="carousel-dot" data-index="1"></div>
                        <div class="carousel-dot" data-index="2"></div>
                        <div class="carousel-dot" data-index="3"></div>
                        <div class="carousel-dot" data-index="4"></div>
                        <div class="carousel-dot" data-index="5"></div>
                        <div class="carousel-dot" data-index="6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">Why Choose Us</p>
                <h2 class="section-title">Our Learning Advantage</h2>
                <p class="section-description">We provide a comprehensive online learning experience designed for success.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Flexible Learning</h3>
                    <p>Study at your own pace with 24/7 access to all course materials and resources.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from qualified teachers with extensive experience in their respective fields.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Interactive Sessions</h3>
                    <p>Participate in live sessions and connect with instructors and fellow students.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="courses" id="courses">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">Our Curriculum</p>
                <h2 class="section-title">Subjects & Courses</h2>
                <p class="section-description">Comprehensive courses designed to help you achieve academic success.</p>
            </div>

            <div class="search-bar">
                <input type="text" id="search" placeholder="Search subjects or courses..." onkeyup="filterCourses()">
                <i class="fas fa-search"></i>
            </div>

            <div class="grid" id="courseList">
                <div class="course-card">
                    <div class="course-header">
                        <h4>Accounting</h4>
                    </div>
                    <div class="course-body">
                        <p>Master financial principles, bookkeeping, and accounting practices for business success.</p>
                        <ul class="course-features">
                            <li><i class="fas fa-check"></i> Financial Statements</li>
                            <li><i class="fas fa-check"></i> Bookkeeping Fundamentals</li>
                            <li><i class="fas fa-check"></i> Budgeting & Analysis</li>
                        </ul>
                        <div class="course-price">
                            M250 <span>/ month</span>
                        </div>
                        <a href="{{ route('register') }}" class="course-btn">Enroll Now</a>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <h4>Mathematics</h4>
                    </div>
                    <div class="course-body">
                        <p>Develop strong problem-solving skills with algebra, geometry, and advanced mathematics.</p>
                        <ul class="course-features">
                            <li><i class="fas fa-check"></i> Algebra & Equations</li>
                            <li><i class="fas fa-check"></i> Geometry & Trigonometry</li>
                            <li><i class="fas fa-check"></i> Calculus Fundamentals</li>
                        </ul>
                        <div class="course-price">
                            M250 <span>/ month</span>
                        </div>
                        <a href="{{ route('register') }}" class="course-btn">Enroll Now</a>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <h4>Biology</h4>
                    </div>
                    <div class="course-body">
                        <p>Explore life sciences from cellular biology to ecosystems and human anatomy.</p>
                        <ul class="course-features">
                            <li><i class="fas fa-check"></i> Cellular Biology</li>
                            <li><i class="fas fa-check"></i> Genetics & Evolution</li>
                            <li><i class="fas fa-check"></i> Human Anatomy</li>
                        </ul>
                        <div class="course-price">
                            M250 <span>/ month</span>
                        </div>
                        <a href="{{ route('register') }}" class="course-btn">Enroll Now</a>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <h4>Physical Science</h4>
                    </div>
                    <div class="course-body">
                        <p>Understand the fundamental principles of physics and chemistry through practical applications.</p>
                        <ul class="course-features">
                            <li><i class="fas fa-check"></i> Physics Principles</li>
                            <li><i class="fas fa-check"></i> Chemical Reactions</li>
                            <li><i class="fas fa-check"></i> Scientific Method</li>
                        </ul>
                        <div class="course-price">
                            M250 <span>/ month</span>
                        </div>
                        <a href="{{ route('register') }}" class="course-btn">Enroll Now</a>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <h4>English</h4>
                    </div>
                    <div class="course-body">
                        <p>Enhance communication skills with comprehensive grammar, writing, and comprehension lessons.</p>
                        <ul class="course-features">
                            <li><i class="fas fa-check"></i> Grammar & Composition</li>
                            <li><i class="fas fa-check"></i> Reading Comprehension</li>
                            <li><i class="fas fa-check"></i> Communication Skills</li>
                        </ul>
                        <div class="course-price">
                            M250 <span>/ month</span>
                        </div>
                        <a href="{{ route('register') }}" class="course-btn">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">Our Process</p>
                <h2 class="section-title">How It Works</h2>
                <p class="section-description">A structured learning approach designed for maximum effectiveness.</p>
            </div>

            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h4>Enroll & Access</h4>
                    <p>Register for your chosen subjects and get immediate access to all learning materials.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h4>Weekly Learning</h4>
                    <p>Study topics at your own pace with videos, notes, and practice exercises throughout the week.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h4>Live Sessions</h4>
                    <p>Join interactive sessions with instructors to review concepts and ask questions.</p>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <h4>Monthly Assessment</h4>
                    <p>Test your knowledge with monthly assessments and track your progress.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="pricing" id="pricing">
        <div class="container">
            <div class="section-header">
                <p class="section-subtitle">Affordable Education</p>
                <h2 class="section-title">Simple Pricing</h2>
                <p class="section-description">Quality education accessible to everyone with flexible payment options.</p>
            </div>

            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Single Subject</h3>
                        <div class="pricing-price">M250</div>
                        <div class="pricing-period">per month</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> One subject of your choice</li>
                        <li><i class="fas fa-check"></i> Full access to all materials</li>
                        <li><i class="fas fa-check"></i> Weekly live sessions</li>
                        <li><i class="fas fa-check"></i> Monthly assessments</li>
                        <li><i class="fas fa-check"></i> Teacher support</li>
                    </ul>
                    <a href="{{ route('register') }}" class="course-btn">Get Started</a>
                </div>

                <div class="pricing-card featured">
                    <div class="pricing-header">
                        <h3>Full Package</h3>
                        <div class="pricing-price">M1,250</div>
                        <div class="pricing-period">per month</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> All 5 subjects included</li>
                        <li><i class="fas fa-check"></i> Complete curriculum access</li>
                        <li><i class="fas fa-check"></i> Priority teacher support</li>
                        <li><i class="fas fa-check"></i> Comprehensive assessments</li>
                        <li><i class="fas fa-check"></i> Certificate upon completion</li>
                    </ul>
                    <a href="{{ route('register') }}" class="course-btn">Get Started</a>
                </div>

                <div class="pricing-card">
                    <div class="pricing-header">
                        <h3>Registration</h3>
                        <div class="pricing-price">M150</div>
                        <div class="pricing-period">one-time fee</div>
                    </div>
                    <ul class="pricing-features">
                        <li><i class="fas fa-check"></i> One-time enrollment fee</li>
                        <li><i class="fas fa-check"></i> Account setup</li>
                        <li><i class="fas fa-check"></i> Learning platform access</li>
                        <li><i class="fas fa-check"></i> Course selection guidance</li>
                        <li><i class="fas fa-check"></i> Payment system setup</li>
                    </ul>
                    <a href="{{ route('register') }}" class="course-btn">Get Started</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Millennium Academy</h3>
                    <p style="color: #cbd5e1; margin-bottom: 20px;">Providing flexible, accessible education to empower learners of all backgrounds.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="#features"><i class="fas fa-chevron-right"></i> Features</a></li>
                        <li><a href="#courses"><i class="fas fa-chevron-right"></i> Courses</a></li>
                        <li><a href="#how-it-works"><i class="fas fa-chevron-right"></i> How It Works</a></li>
                        <li><a href="#pricing"><i class="fas fa-chevron-right"></i> Pricing</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Subjects</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Accounting</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Mathematics</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Biology</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> Physical Science</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right"></i> English</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <div class="footer-contact">
                        <p><i class="fas fa-envelope"></i> info@millenniumacademy.com</p>
                        <p><i class="fas fa-phone"></i> +266 57523929</p>
                        <p><i class="fas fa-map-marker-alt"></i> Maseru, Lesotho</p>
                    </div>
                </div>
            </div>

            <div class="copyright">
                <p>© <span id="currentYear"></span> Millennium Academy. All Rights Reserved. | Powered by TechSolve</p>
            </div>
        </div>
    </footer>

    <script>
        function filterCourses() {
            const input = document.getElementById('search').value.toLowerCase();
            const cards = document.querySelectorAll('.course-card');
            cards.forEach(card => {
                const title = card.querySelector('h4').innerText.toLowerCase();
                card.style.display = title.includes(input) ? 'block' : 'none';
            });
        }

        // Mobile menu toggle
        const menuToggle = document.getElementById('mobile-menu');
        const mainNav = document.getElementById('main-nav');

        menuToggle.addEventListener('click', () => {
            mainNav.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mainNav.contains(e.target) && !menuToggle.contains(e.target)) {
                mainNav.classList.remove('active');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if(targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });

                    // Close mobile menu after clicking
                    mainNav.classList.remove('active');
                }
            });
        });

        // Image Carousel Functionality
        const carouselItems = document.querySelectorAll('.carousel-item');
        const carouselDots = document.querySelectorAll('.carousel-dot');
        let currentIndex = 0;
        let interval;

        function showSlide(index) {
            // Hide all slides
            carouselItems.forEach(item => {
                item.classList.remove('active');
            });

            // Remove active class from all dots
            carouselDots.forEach(dot => {
                dot.classList.remove('active');
            });

            // Show the current slide and activate the corresponding dot
            carouselItems[index].classList.add('active');
            carouselDots[index].classList.add('active');

            currentIndex = index;
        }

        function nextSlide() {
            let nextIndex = (currentIndex + 1) % carouselItems.length;
            showSlide(nextIndex);
        }

        // Start the automatic slideshow
        function startCarousel() {
            interval = setInterval(nextSlide, 4000); // Change image every 4 seconds
        }

        // Add click event to dots
        carouselDots.forEach(dot => {
            dot.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                showSlide(index);
                // Reset the interval when manually changing slides
                clearInterval(interval);
                startCarousel();
            });
        });

        // Initialize the carousel
        startCarousel();

        // Set current year in footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</body>
</html>
