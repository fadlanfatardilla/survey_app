<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin();
if (!isClient()) {
    header('Location: /auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $created_by = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO surveys (title, description, created_by) VALUES (?, ?, ?)");
    if ($stmt->execute([$title, $description, $created_by])) {
        $success = "Survey created successfully!";
        $redirect = true;
    } else {
        $error = "Failed to create survey.";
        $redirect = false;
    }
}

?>

<!-- UI Halaman Create Survey untuk Client -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
    body {
        background: linear-gradient(to right, #1e3c72, #2a5298);
        font-family: 'Poppins', sans-serif;
        color: #fff;
    }

    .container {
        margin-top: 50px;
        max-width: 600px;
        background: rgba(0, 0, 0, 0.8);
        padding: 40px;
        border-radius: 12px;
    }

    .container h2 {
        margin-bottom: 30px;
        font-weight: 600;
        color: #ffcc00;
    }

    .form-control,
    .form-control:focus {
        background-color: #333;
        border-color: #444;
        color: #fff;
        border-radius: 6px;
    }

    .form-label {
        color: #ffcc00;
    }

    .btn-primary {
        background-color: #ffcc00;
        border-color: #ffcc00;
        color: black;
        border-radius: 6px;
        font-weight: 600;
        padding: 12px 24px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #e6b800;
        border-color: #e6b800;
    }

    .btn-secondary {
        background-color: #444;
        border-color: #555;
        color: #fff;
        border-radius: 6px;
        font-weight: 600;
        padding: 8px 16px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-secondary:hover {
        background-color: #333;
        border-color: #444;
    }

    .alert {
        border-radius: 6px;
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Create New Survey</h2>
        <form id="surveyForm" action="" method="post">
            <div class="mb-4">
                <label for="title" class="form-label">Survey Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter survey title"
                    required>
            </div>
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"
                    placeholder="Enter survey description"></textarea>
            </div>
            <div class="btn-container">
                <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
                <button type="submit" class="btn btn-primary">Create Survey</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('surveyForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(responseText => {
                if (responseText.includes('Survey created successfully!')) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Survey has been created successfully!',
                        icon: 'success',
                        confirmButtonColor: '#ffcc00',
                        background: '#333',
                        color: '#fff',
                        customClass: {
                            title: 'swal-title',
                            content: 'swal-content'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to index.php after showing the success message
                            window.location.href = 'index.php';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to create survey. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#ffcc00',
                        background: '#333',
                        color: '#fff',
                        customClass: {
                            title: 'swal-title',
                            content: 'swal-content'
                        }
                    });
                }
            });
    });
    </script>
</body>

</html>