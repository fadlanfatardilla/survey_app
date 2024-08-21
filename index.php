<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background: #1c1c1c;
            color: #e0e0e0;
        }

        .navbar {
            background-color: #343a40;
            /* Mengganti warna navbar menjadi abu-abu gelap */
            padding: 1rem 2rem;
        }

        .navbar-brand {
            color: #f8f9fa;
            /* Warna putih pada teks navbar */
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: #f8f9fa;
            font-size: 1.1rem;
        }

        .hero-section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #333333, #000000);
            color: #e0e0e0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            background-image: url('https://source.unsplash.com/1600x900/?survey,forms');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .hero-content {
            z-index: 1;
            max-width: 800px;
            padding: 2rem;
        }

        .hero-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .hero-content p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
        }

        .hero-content .btn {
            padding: 0.8rem 2rem;
            font-size: 1.2rem;
            border-radius: 50px;
        }

        .btn-login {
            background-color: #ff7f50;
            border-color: #ff7f50;
        }

        .btn-login:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }

        .btn-register {
            background-color: #20b2aa;
            border-color: #20b2aa;
        }

        .btn-register:hover {
            background-color: #3cb371;
            border-color: #3cb371;
        }

        .features-section {
            padding: 4rem 2rem;
            background-color: #1f1f1f;
            text-align: center;
        }

        .features-section h2 {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            color: #e0e0e0;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .feature-item {
            flex: 1;
            min-width: 250px;
            margin: 1rem;
            padding: 2rem;
            background-color: #2c2c2c;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .feature-item img {
            width: 60px;
            margin-bottom: 1.5rem;
        }

        .feature-item h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #e0e0e0;
        }

        .feature-item p {
            font-size: 1rem;
            color: #c0c0c0;
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .features {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Survey App</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="auth/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="auth/register.php">Register</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Create, Share & Analyze Surveys</h1>
            <p>Design custom surveys effortlessly, share them across platforms, and get valuable insights.</p>
            <a href="auth/login.php" class="btn btn-login me-3">Login</a>
            <a href="auth/register.php" class="btn btn-register">Register</a>
        </div>
    </section>

    <section class="features-section">
        <h2>Why Choose Survey App?</h2>
        <div class="features">
            <div class="feature-item">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828640.png" alt="Feature 1">
                <h3>User-Friendly Interface</h3>
                <p>Easily create surveys with our intuitive and simple-to-use interface.</p>
            </div>
            <div class="feature-item">
                <img src="https://cdn-icons-png.flaticon.com/512/3579/3579510.png" alt="Feature 2">
                <h3>Advanced Analytics</h3>
                <p>Get deep insights and detailed reports to make informed decisions.</p>
            </div>
            <div class="feature-item">
                <img src="https://cdn-icons-png.flaticon.com/512/1370/1370907.png" alt="Feature 3">
                <h3>Secure & Reliable</h3>
                <p>We prioritize your data's security with industry-leading encryption.</p>
            </div>
        </div>
    </section>

</body>

</html>