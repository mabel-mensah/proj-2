<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$exam_id = $_POST['exam_id'];
$answers = $_POST['answers'];
$score = 0;

$pdo->beginTransaction();
try {
    foreach ($answers as $question_id => $answer) {
        $stmt = $pdo->prepare("SELECT correct_answer FROM questions WHERE question_id = :question_id");
        $stmt->execute(['question_id' => $question_id]);
        $correct_answer = $stmt->fetchColumn();

        if ($correct_answer == $answer) {
            $score += 1; // Increment score for each correct answer
        }
    }

    $stmt = $pdo->prepare("INSERT INTO user_exams (user_id, exam_id, score) VALUES (:user_id, :exam_id, :score)");
    $stmt->execute(['user_id' => $user_id, 'exam_id' => $exam_id, 'score' => $score]);

    $pdo->commit();
    echo "Exam submitted successfully! Your score is: $score";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed to submit exam: " . $e->getMessage();
}
?>
