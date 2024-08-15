<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin(); // Pastikan pengguna telah login

if (!isClient()) {
    header('Location: /auth/login.php');
    exit();
}

// Mendapatkan survei yang tersedia
$stmt = $pdo->query("SELECT * FROM surveys");
$surveys = $stmt->fetchAll();
?>

<!-- UI Halaman Dashboard Client -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #343a40;
            color: #e9ecef;
        }

        .container {
            margin-top: 30px;
            max-width: 900px;
        }

        .dashboard-header {
            background-color: #495057;
            color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .dashboard-header h2 {
            margin: 0;
        }

        .dashboard-header p {
            margin: 10px 0 20px;
        }

        .btn-create-survey {
            align-self: flex-end;
        }

        .survey-card {
            border-radius: 10px;
            background-color: #495057;
            color: #e9ecef;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .survey-card:hover {
            transform: scale(1.02);
        }

        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: #e9ecef;
        }

        .btn-primary-custom:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .survey-card-body {
            padding: 20px;
        }

        /* Styling modal */
        .modal-content {
            border-radius: 15px;
            background-color: #212529;
            color: #e9ecef;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background-color: #343a40;
            color: #e9ecef;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }

        .modal-title {
            color: #e9ecef;
        }

        .modal-body {
            padding: 20px;
            color: #e9ecef;
        }

        .modal-footer {
            background-color: #343a40;
            border-top: none;
            border-radius: 0 0 15px 15px;
        }

        .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
            color: #e9ecef;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .list-group-item {
            background-color: #212529;
            color: #e9ecef;
            border: none;
            border-bottom: 1px solid #343a40;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Smooth transition for modal opening */
        .fade.show {
            transition: opacity 0.3s ease-in-out;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="dashboard-header">
            <div>
                <h2>Client Dashboard</h2>
                <p>Welcome to your dashboard. Here you can view and create surveys.</p>
            </div>
            <!-- Tombol Create New Survey -->
            <a href="create_survey.php" class="btn btn-primary-custom btn-create-survey">Create New Survey</a>
        </div>

        <!-- Daftar Survei -->
        <h3 class="mt-4">Available Surveys</h3>
        <div class="row">
            <?php foreach ($surveys as $survey): ?>
                <div class="col-md-4 mb-4">
                    <div class="card survey-card">
                        <div class="card-body survey-card-body">
                            <h5 class="card-title"><?= htmlspecialchars($survey['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($survey['description']) ?></p>
                            <button type="button" class="btn btn-primary-custom btn-view-details"
                                data-id="<?= $survey['id'] ?>">View Details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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
                <div class="modal-body">
                    <!-- Content will be loaded here by JavaScript -->
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-view-details').forEach(button => {
                button.addEventListener('click', function() {
                    const surveyId = this.getAttribute('data-id');
                    fetchSurveyDetails(surveyId);
                });
            });
        });

        function fetchSurveyDetails(id) {
            fetch(`view_survey.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const modalBody = document.querySelector('#surveyModal .modal-body');
                        modalBody.innerHTML = `
                        <h5>${data.survey.title}</h5>
                        <p>${data.survey.description}</p>
                        <h6>Admin Answers:</h6>
                        <ul class="list-group">
                            ${data.answers.length > 0 ? data.answers.map(answer => `
                                <li class="list-group-item">${answer.answer}</li>
                            `).join('') : '<li class="list-group-item">No answers from admin yet.</li>'}
                        </ul>
                    `;
                        const surveyModal = new bootstrap.Modal(document.getElementById('surveyModal'));
                        surveyModal.show();
                    } else {
                        alert('Survey not found or error loading details.');
                    }
                })
                .catch(error => console.error('Error fetching survey details:', error));
        }
    </script>
</body>

</html>