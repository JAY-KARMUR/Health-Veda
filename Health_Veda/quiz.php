<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';
include 'includes/header.php';

// Get quiz questions
$questions = getQuizQuestions();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = [];

    // Collect answers
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            $answers[] = $value;
        }
    }

    // Calculate dosha type
    $result = calculateDoshaType($answers);

    // Store result in session
    $_SESSION['dosha_result'] = $result;

    // Save result to database if user is logged in
    if (IS_LOGGED_IN) {
        $user_id = $_SESSION['user_id'];
        $result_id = saveQuizResult($user_id, $result);

        if ($result_id) {
            $_SESSION['quiz_result_id'] = $result_id;
        }
    }

    // Redirect to results page
    header('Location: results.php');
    exit;
}
?>

<div class="container">
    <div class="quiz-container">
        <div class="quiz-header">
            <h2>Dosha Quiz</h2>
            <p>Answer these 15 questions to discover your dosha type.</p>
            <p>Select the option that best describes you.</p>
            <p id="progress-text">Question 1 of 15</p>
        </div>

        <form id="quiz-form" method="post" action="quiz.php">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question" id="question-<?php echo $index; ?>">
                    <h3><?php echo ($index + 1) . '. ' . $question['question']; ?></h3>
                    <div class="options">
                        <?php foreach ($question['options'] as $type => $option): ?>
                            <div class="option">
                                <input type="radio" id="q<?php echo $index; ?>-<?php echo $type; ?>" name="question_<?php echo $index; ?>" value="<?php echo $type; ?>" class="option-input">
                                <label for="q<?php echo $index; ?>-<?php echo $type; ?>" class="option-label"><?php echo $option; ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="quiz-navigation">
                <button type="button" id="prev-btn" class="btn">Previous</button>
                <button type="button" id="next-btn" class="btn">Next</button>
                <button type="submit" id="submit-btn" class="btn">Submit</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
