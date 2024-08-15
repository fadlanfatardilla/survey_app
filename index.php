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
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            font-family: 'Arial', sans-serif;
        }

        .container {
            text-align: center;
            margin-top: 150px;
        }

        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
        }

        .btn-primary:hover {
            background-color: #ff6347;
            border-color: #ff6347;
        }

        .btn-secondary {
            background-color: #20b2aa;
            border-color: #20b2aa;
        }

        .btn-secondary:hover {
            background-color: #3cb371;
            border-color: #3cb371;
        }

        .hero-image {
            background-image: url('https://source.unsplash.com/1600x900/?survey,forms');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-text {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 50px;
            border-radius: 10px;
        }

        h1 {
            font-size: 4rem;
            font-weight: bold;
        }

        p {
            font-size: 1.25rem;
        }
    </style>
</head>

<body>
    <div class="hero-image">
        <div class="hero-text">
            <h1>Welcome to Survey App</h1>
            <p>Create, Share, and Analyze Your Surveys Easily</p>
            <p><a href="auth/login.php" class="btn btn-primary btn-lg">Login</a> or <a href="auth/register.php"
                    class="btn btn-secondary btn-lg">Register</a></p>
        </div>
    </div>
</body>

</html>