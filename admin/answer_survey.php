<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin();
if (!isAdmin()) {
    header('Location: /auth/login.php');
    exit();
}

$survey_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM answers WHERE survey_id = ?");
$stmt->execute([$survey_id]);
$is_answered = $stmt->fetchColumn() > 0;

if ($is_answered) {
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
    <link rel="stylesheet" href="../css/answer_survey.css">
</head>

<body>
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="mb-0">Answer Survey: <?= htmlspecialchars($survey['title']) ?></h2>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '<?= htmlspecialchars($success) ?>',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6',
                    backdrop: `
                                rgba(0,0,123,0.4)
                                no-repeat
                            `,
                    timer: 3000,
                    timerProgressBar: true,
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = 'index.php';
                });
                </script>
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