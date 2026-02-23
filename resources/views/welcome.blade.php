<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foodie Express</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap"
        rel="stylesheet">

            <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            color: #355aff;
            /* Warm Blue */
            font-size: 2.0rem;
            font-weight: 800;
            text-shadow: 1px 1px 2px rgba(91, 135, 255, 0.1);
            transition: color 0.3s ease;
            letter-spacing: -0.5px;
        }

        .navbar-brand:hover {
            color: #698eff;
            /* Slightly darker warm blue on hover */
            text-decoration: none;
        }

        .hero-section {
            background: linear-gradient(135deg, #355aff 0%, #4f7cff 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        .hero-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 15s infinite linear;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            animation: float 20s infinite linear reverse;
        }

        @keyframes float {
            0% {
                transform: rotate(0deg) translate(0, 0);
            }

            50% {
                transform: rotate(180deg) translate(50px, 50px);
            }

            100% {
                transform: rotate(360deg) translate(0, 0);
            }
        }

        .hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: white;
            text-shadow: 2px 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeInDown 1s ease-out;
            font-family: 'Montserrat', sans-serif;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 1.6rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
            animation: fadeInUp 1s ease-out 0.5s backwards;
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        .btn-order {
            background: white;
            color: #355aff;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-out 1s backwards;
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.3px;
        }

        .btn-order:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #f8f9ff;
        }

        /* Features Section */
        .features-section {
            background: #f8f9ff;
            padding: 6rem 0;
            position: relative;
        }

        .features-section::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom right, transparent 49%, #f8f9ff 50%);
        }

        .why-choose {
            font-size: 3rem;
            color: #2d3748;
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
            display: inline-block;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .why-choose::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, #355aff, #4f7cff);
            margin: 1rem auto 0;
            border-radius: 2px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .feature-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        .feature-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            letter-spacing: 0.2px;
        }
            </style>
    </head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">

                Foodie Express
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                        @if (Route::has('login'))
                                @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                            </li>
                                @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button"
                                    data-bs-toggle="dropdown">
                                    Login
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('login.customer') }}">Customer Login</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('login.admin') }}">Admin Login</a></li>
                                </ul>
                            </li>
                                    @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                                    @endif
                                @endauth
                        @endif
                </ul>
                                        </div>
                                    </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section d-flex align-items-center">
        <div class="container text-center">
            <h1 class="display-4 mb-4">Welcome to Foodie Express</h1>
            <p class="lead mb-4">Your favorite meals, delivered right to your doorstep</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Order Now</a>
                                </div>
    </header>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Why Choose Foodie Express?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-clock feature-icon"></i>
                            <h3 class="h4 mb-3">Fast Delivery</h3>
                            <p class="text-muted">Get your food delivered within 30 minutes</p>
                                </div>
                                </div>
                                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-utensils feature-icon"></i>
                            <h3 class="h4 mb-3">Wide Selection</h3>
                            <p class="text-muted">Choose from hundreds of restaurants</p>
                                </div>
                                </div>
                            </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-star feature-icon"></i>
                            <h3 class="h4 mb-3">Best Quality</h3>
                            <p class="text-muted">Only the finest restaurants and food quality</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <h4 class="mb-4">Contact Us</h4>
                    <p><i class="fas fa-phone me-2"></i> +60 195968186</p>
                    <p><i class="fas fa-envelope me-2"></i> foodieexpress@gmail.com</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Food Street, Bandar Baru Bangi</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h4 class="mb-4">Follow Us</h4>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Foodie Express. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
