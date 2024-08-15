<?php
include('../config/db.php');
include('../includes/session.php');
checkLogin();
if (!isAdmin()) {
    header('Location: /auth/login.php');
    exit();
}

$survey_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$survey_stmt = $pdo->prepare("SELECT * FROM surveys WHERE id = ?");
$survey_stmt->execute([$survey_id]);
$survey = $survey_stmt->fetch(PDO::FETCH_ASSOC);

$answers_stmt = $pdo->prepare("SELECT * FROM answers WHERE survey_id = ?");
$answers_stmt->execute([$survey_id]);
$answers = $answers_stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$survey) {
    echo "<p>Survey not found.</p>";
    exit();
}
?>

<h2><?= htmlspecialchars($survey['title']) ?></h2>
<p class="lead"><?= htmlspecialchars($survey['description']) ?></p>
<h3>Answers</h3>
<ul class="list-group">
    <?php if (count($answers) > 0): ?>
        <?php foreach ($answers as $answer): ?>
            <li class="list-group-item"><?= htmlspecialchars($answer['answer']) ?></li>
        <?php endforeach; ?>
    <?php else: ?>
        <li class="list-group-item">No answers yet.</li>
    <?php endif; ?>
</ul>