<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Estimate Form - Professional Estimation System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #F2A61D;
            --secondary-color: #0D2949;
            --accent-color: #F2A61D;
            --dark-color: #1f2937;
            --light-color: #f8f9fa;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', 'Open Sans', sans-serif;
            color: var(--dark-color);
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: var(--secondary-color);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .navbar-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 900;
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9) !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .btn-primary-custom {
            background: var(--accent-color);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: white;
        }

        .btn-primary-custom:hover {
            background: #d4941a;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(242, 166, 29, 0.4);
            color: white;
        }

        /* Hero Carousel Section */
        .hero-carousel {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .carousel-item {
            height: 100vh;
            min-height: 600px;
            position: relative;
        }

        .carousel-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(8px);
            transform: scale(1.1);
            z-index: 1;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            color: white;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }


        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            animation: fadeInUp 1s ease;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.8;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .hero-buttons {
            animation: fadeInUp 1s ease 0.6s both;
        }

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

        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            margin: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-hero-primary {
            background: var(--accent-color);
            color: white;
            border: 2px solid var(--accent-color);
            font-weight: 600;
        }

        .btn-hero-primary:hover {
            background: #d4941a;
            border-color: #d4941a;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(242, 166, 29, 0.4);
        }

        .btn-hero-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
            font-weight: 600;
        }

        .btn-hero-outline:hover {
            background: white;
            color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        /* Carousel Controls */
        .carousel-control-prev,
        .carousel-control-next {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            backdrop-filter: blur(10px);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .carousel-control-prev {
            left: 30px;
        }

        .carousel-control-next {
            right: 30px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background: rgba(255, 255, 255, 0.3);
            opacity: 1;
        }

        .carousel-indicators {
            bottom: 30px;
        }

        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid white;
        }

        .carousel-indicators .active {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Features Section */
        .features-section {
            padding: 5rem 0;
            background: var(--light-color);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .section-subtitle {
            text-align: center;
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #e2e8f0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(13, 41, 73, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--secondary-color);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .feature-description {
            color: #718096;
            line-height: 1.8;
        }

        /* Company Highlight Section */
        .company-section {
            padding: 5rem 0;
            background: var(--secondary-color);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .company-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 50px 50px;
        }

        .company-content {
            position: relative;
            z-index: 1;
        }

        .company-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .company-name {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        .company-description {
            font-size: 1.2rem;
            line-height: 1.9;
            opacity: 0.95;
            max-width: 800px;
            margin: 0 auto;
        }

        /* About Section */
        .about-section {
            padding: 5rem 0;
            background: white;
        }

        .about-content {
            font-size: 1.1rem;
            line-height: 1.9;
            color: #4a5568;
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: var(--light-color);
        }

        .cta-card {
            background: var(--secondary-color);
            padding: 4rem;
            border-radius: 30px;
            text-align: center;
            color: white;
            box-shadow: 0 20px 60px rgba(13, 41, 73, 0.3);
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .cta-description {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }

        /* Footer */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 3rem 0 1.5rem;
        }

        .footer-content {
            text-align: center;
        }

        .footer-links {
            margin: 2rem 0;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-copyright {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .company-name {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url(); ?>">
                <img src="<?php echo base_url('assets/img/logo.webp'); ?>" alt="Virtual Estimator Logo" class="logo-img">
                <span>Virtual Estimator</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#company">Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('admin'); ?>">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel Section -->
    <section class="hero-carousel">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="carousel-background" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');"></div>
                    <div class="carousel-overlay"></div>
                    <div class="hero-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 mx-auto text-center">
                                    <h1 class="hero-title">Virtual Estimate Form</h1>
                                    <p class="hero-subtitle">Professional Estimation System</p>
                                    <p class="hero-description">
                                        Streamline your estimation process with our cutting-edge virtual estimator. 
                                        Generate accurate estimates quickly and efficiently with our intuitive platform.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="<?php echo base_url('forms'); ?>" class="btn btn-hero-primary btn-hero">
                                            <i class="bi bi-box-arrow-in-right"></i> Get Started
                                        </a>
                                        <a href="#features" class="btn btn-hero-outline btn-hero">
                                            <i class="bi bi-info-circle"></i> Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="carousel-background" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');"></div>
                    <div class="carousel-overlay"></div>
                    <div class="hero-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 mx-auto text-center">
                                    <h1 class="hero-title">Fast & Accurate Estimates</h1>
                                    <p class="hero-subtitle">Get Professional Estimates in Minutes</p>
                                    <p class="hero-description">
                                        Our advanced estimation system helps you get precise project estimates 
                                        without the wait. Experience the future of project estimation today.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="<?php echo base_url('forms'); ?>" class="btn btn-hero-primary btn-hero">
                                            <i class="bi bi-rocket-takeoff"></i> Start Now
                                        </a>
                                        <a href="#features" class="btn btn-hero-outline btn-hero">
                                            <i class="bi bi-info-circle"></i> Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="carousel-background" style="background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');"></div>
                    <div class="carousel-overlay"></div>
                    <div class="hero-content">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-8 mx-auto text-center">
                                    <h1 class="hero-title">Trusted by Professionals</h1>
                                    <p class="hero-subtitle">Industry-Leading Estimation Technology</p>
                                    <p class="hero-description">
                                        Join thousands of professionals who trust our virtual estimation system 
                                        for accurate, reliable project estimates every time.
                                    </p>
                                    <div class="hero-buttons">
                                        <a href="<?php echo base_url('forms'); ?>" class="btn btn-hero-primary btn-hero">
                                            <i class="bi bi-check-circle"></i> Get Your Estimate
                                        </a>
                                        <a href="#features" class="btn btn-hero-outline btn-hero">
                                            <i class="bi bi-info-circle"></i> Learn More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose Our System?</h2>
            <p class="section-subtitle">Powerful features designed to make estimation easy and accurate</p>
            
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                        <h3 class="feature-title">Fast & Efficient</h3>
                        <p class="feature-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Accurate Estimates</h3>
                        <p class="feature-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <h3 class="feature-title">Real-time Analytics</h3>
                        <p class="feature-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="feature-title">Team Collaboration</h3>
                        <p class="feature-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-cloud-check"></i>
                        </div>
                        <h3 class="feature-title">Cloud-Based</h3>
                        <p class="feature-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-mobile"></i>
                        </div>
                        <h3 class="feature-title">Mobile Friendly</h3>
                        <p class="feature-description">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Company Highlight Section -->
    <section id="company" class="company-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center company-content">
                    <span class="company-badge">
                        <i class="bi bi-star-fill"></i> Trusted Company
                    </span>
                    <h2 class="company-name">Your Company Name</h2>
                    <p class="company-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure 
                        dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        <br><br>
                        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt 
                        mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit 
                        voluptatem accusantium doloremque laudantium.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title text-center mb-5">About Virtual Estimator</h2>
                    <div class="about-content">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor 
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud 
                            exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                        <p>
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu 
                            fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in 
                            culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                        <p>
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium 
                            doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore 
                            veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="cta-card">
                        <h2 class="cta-title">Ready to Get Started?</h2>
                        <p class="cta-description">
                            Join thousands of users who trust our virtual estimation system for their business needs.
                        </p>
                        <a href="<?php echo base_url('forms'); ?>" class="btn btn-light btn-lg btn-hero-primary">
                            <i class="bi bi-rocket-takeoff"></i> Start Estimating Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <h4 class="mb-3">Virtual Estimate Form</h4>
                <div class="footer-links">
                    <a href="#features">Features</a>
                    <a href="#company">Company</a>
                    <a href="#about">About</a>
                    <a href="<?php echo base_url('admin'); ?>">Login</a>
                </div>
                <div class="footer-copyright">
                    <p>&copy; <?php echo date('Y'); ?> Your Company Name. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            });

            // Navbar background on scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').css('background', 'var(--secondary-color)');
                } else {
                    $('.navbar').css('background', 'var(--secondary-color)');
                }
            });

            // Animate on scroll
            $(window).scroll(function() {
                $('.feature-card').each(function() {
                    var elementTop = $(this).offset().top;
                    var elementBottom = elementTop + $(this).outerHeight();
                    var viewportTop = $(window).scrollTop();
                    var viewportBottom = viewportTop + $(window).height();

                    if (elementBottom > viewportTop && elementTop < viewportBottom) {
                        $(this).addClass('animate');
                    }
                });
            });
        });
    </script>
</body>
</html>

