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
    <link rel="stylesheet" href="../css/create_survey.css">


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
        event.preventDefault();

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