<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin();
if (!isAdmin()) {
    header('Location: /auth/login.php');
    exit();
}

$survey_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah survei sudah terjawab
$stmt = $pdo->prepare("SELECT COUNT(*) FROM answers WHERE survey_id = ?");
$stmt->execute([$survey_id]);
$is_answered = $stmt->fetchColumn() > 0;

if ($is_answered) {
    // Jika sudah terjawab, tampilkan alert dengan SweetAlert2
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Survey Already Answered</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css' rel='stylesheet'>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f8f9fa;
            }
        </style>
    </head>
    <body>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Survey Already Answered',
                text: 'This survey has already been answered. You cannot submit an answer again.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>
    </body>
    </html>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $answer = $_POST['answer'];
    $answered_by = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO answers (survey_id, answer, answered_by) VALUES (?, ?, ?)");
    if ($stmt->execute([$survey_id, $answer, $answered_by])) {
        $success = "Answer submitted successfully!";
    } else {
        $error = "Failed to submit answer.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM surveys WHERE id = ?");
$stmt->execute([$survey_id]);
$survey = $stmt->fetch();

if (!$survey) {
    echo "Survey not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Survey</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background: #2c2f33;
            font-family: 'Poppins', sans-serif;
            color: #dcdde1;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 40px;
            max-width: 800px;
        }

        .card {
            background-color: #23272a;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            color: #dcdde1;
        }

        .card-header {
            background: #7289da;
            color: #fff;
            border-radius: 12px 12px 0 0;
            font-weight: 600;
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .alert {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #7289da;
            border-color: #7289da;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #5b6eae;
            border-color: #4b5990;
        }

        .btn-secondary {
            background-color: #99aab5;
            border-color: #99aab5;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
            border-color: #70787a;
        }

        textarea {
            background-color: #2c2f33;
            color: #dcdde1;
            border: 1px solid #99aab5;
            border-radius: 8px;
            padding: 10px;
        }

        textarea:focus {
            box-shadow: 0 0 0 0.2rem rgba(114, 137, 218, 0.25);
            border-color: #7289da;
        }

        .btn-back {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Answer Survey: <?= htmlspecialchars($survey['title']) ?></h2>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="answer" class="form-label">Your Answer</label>
                        <textarea class="form-control" id="answer" name="answer" rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Answer</button>
                </form>
            </div>
        </div>
        <a href="index.php" class="btn btn-secondary btn-back">Back to Dashboard</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>