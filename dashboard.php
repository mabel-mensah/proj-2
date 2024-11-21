<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}
include 'db.php';

$stmt = $pdo->query("SELECT * FROM exams");
$exams = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Exam Dashboard</title></head>
<body>
    <h2>Available Exams</h2>
    <?php foreach ($exams as $exam): ?>
        <div>
            <h3><?php echo $exam['title']; ?></h3>
            <p>Duration: <?php echo $exam['duration']; ?> minutes</p>
            <a href="start_exam.php?exam_id=<?php echo $exam['exam_id']; ?>">Start Exam</a>
        </div>
    <?php endforeach; ?>
</body>
</html>
