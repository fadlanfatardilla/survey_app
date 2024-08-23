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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/index_client.css">

</head>

<body>

    <div class="container">
        <div class="dashboard-header">
            <div>
                <h2>Client Dashboard</h2>
                <p>Welcome to your dashboard. Here you can view and create surveys.</p>
            </div>
            <div class="d-flex align-items-center">
                <i class="fas fa-plus btn-create-survey" id="createSurveyIcon" title="Create New Survey"></i>
                <i class="fas fa-sign-out-alt logout-icon" id="logoutIcon" title="Logout"></i>
            </div>
        </div>

        <h3 class="mt-4">Available Surveys</h3>
        <div class="row">
            <?php foreach ($surveys as $survey): ?>
            <div class="col-md-4 mb-4">
                <div class="card survey-card">
                    <div class="card-body survey-card-body">
                        <h5 class="card-title"><?= htmlspecialchars($survey['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($survey['description']) ?></p>
                        <button type="button" class="btn btn-secondary btn-view-details"
                            data-id="<?= $survey['id'] ?>">View Details</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal fade" id="surveyModal" tabindex="-1" aria-labelledby="surveyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="surveyModalLabel">Survey Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.all.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-view-details').forEach(button => {
            button.addEventListener('click', function() {
                const surveyId = this.getAttribute('data-id');
                fetchSurveyDetails(surveyId);
            });
        });

        document.getElementById('createSurveyIcon').addEventListener('click', function() {
            window.location.href = 'create_survey.php';
        });

        document.getElementById('logoutIcon').addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../auth/logout.php';
                }
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
                    Swal.fire('Error', 'Unable to fetch survey details', 'error');
                }
            });
    }
    </script>
</body>

</html>