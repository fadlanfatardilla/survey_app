<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin();

if (!isClient()) {
    header('Location: /auth/login.php');
    exit();
}

header('Content-Type: application/json');

// Mendapatkan ID survei dari URL
$survey_id = $_GET['id'];

// Mendapatkan detail survei berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM surveys WHERE id = ?");
$stmt->execute([$survey_id]);
$survey = $stmt->fetch();

if (!$survey) {
    echo json_encode(['status' => 'error']);
    exit();
}

// Mendapatkan jawaban admin untuk survei ini
$stmt = $pdo->prepare("SELECT answer FROM answers WHERE survey_id = ? AND answered_by IN (SELECT id FROM users WHERE role = 'admin')");
$stmt->execute([$survey_id]);
$answers = $stmt->fetchAll();

// Mengirimkan data dalam format JSON
echo json_encode([
    'status' => 'success',
    'survey' => $survey,
    'answers' => $answers
]);
