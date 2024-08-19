<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin();
if (!isAdmin()) {
    header('Location: /auth/login.php');
    exit();
}

$stmt = $pdo->query("SELECT * FROM surveys");
$surveys = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            font-family: 'Poppins', sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            max-width: 1200px;
        }

        .card {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            background: #ffcc00;
            color: #333;
            font-weight: 600;
            border-radius: 8px 8px 0 0;
            padding: 10px 15px;
        }

        .card-body {
            padding: 15px;
        }

        .btn-custom {
            border-radius: 6px;
            padding: 8px 12px;
        }

        .btn-custom:hover {
            opacity: 0.8;
        }

        .table {
            color: #fff;
        }

        .table thead {
            background: rgba(0, 0, 0, 0.6);
        }

        .table th {
            color: #fff;
        }

        .table td {
            color: #fff;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.4);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .table tbody a {
            color: #fff;
        }

        .table tbody a:hover {
            text-decoration: underline;
        }

        .modal-content {
            background: #1e3c72;
            color: #fff;
            border-radius: 12px;
        }

        .modal-header {
            border-bottom: 1px solid #fff;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #fff;
        }

        .modal-title {
            color: #ffcc00;
            /* Title color */
        }

        .btn-secondary {
            background: #2a5298;
            border-color: #2a5298;
        }

        .btn-secondary:hover {
            background: #1e3c72;
            border-color: #1e3c72;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Admin Dashboard
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surveys as $index => $survey): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($survey['title']) ?></td>
                                <td>
                                    <button class="btn btn-primary btn-custom btn-view"
                                        data-id="<?= $survey['id'] ?>">View</button>
                                    <a href="answer_survey.php?id=<?= $survey['id'] ?>"
                                        class="btn btn-success btn-custom">Answer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="surveyModal" tabindex="-1" aria-labelledby="surveyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="surveyModalLabel">Survey Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Content will be loaded here via AJAX -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-view').on('click', function() {
                var surveyId = $(this).data('id');

                $.ajax({
                    url: 'view_survey.php',
                    type: 'GET',
                    data: {
                        id: surveyId
                    },
                    success: function(response) {
                        $('#modalBody').html(response);
                        var surveyModal = new bootstrap.Modal(document.getElementById(
                            'surveyModal'));
                        surveyModal.show();
                    }
                });
            });
        });
    </script>
</body>

</html>