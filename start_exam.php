<?php
session_start();
include 'db.php';

$exam_id = $_GET['exam_id'];
$user_id = $_SESSION['user_id'];

// Check if the user has already taken the exam
$stmt = $pdo->prepare("SELECT * FROM user_exams WHERE user_id = :user_id AND exam_id = :exam_id");
$stmt->execute(['user_id' => $user_id, 'exam_id' => $exam_id]);
if ($stmt->fetch()) {
    echo "You have already taken this exam.";
    exit;
}

// Fetch questions for the exam
$stmt = $pdo->prepare("SELECT * FROM questions WHERE exam_id = :exam_id");
$stmt->execute(['exam_id' => $exam_id]);
$questions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Exam</title></head>
<body>
    <h2>Exam</h2>
    <form action="submit_exam.php" method="POST">
        <?php foreach ($questions as $question): ?>
            <p><?php echo $question['question_text']; ?></p>
            <input type="radio" name="answers[<?php echo $question['question_id']; ?>]" value="A"> <?php echo $question['option_a']; ?><br>
            <input type="radio" name="answers[<?php echo $question['question_id']; ?>]" value="B"> <?php echo $question['option_b']; ?><br>
            <input type="radio" name="answers[<?php echo $question['question_id']; ?>]" value="C"> <?php echo $question['option_c']; ?><br>
            <input type="radio" name="answers[<?php echo $question['question_id']; ?>]" value="D"> <?php echo $question['option_d']; ?><br>
        <?php endforeach; ?>
        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
        <button type="submit">Submit Exam</button>
    </form>
</body>
</html>
