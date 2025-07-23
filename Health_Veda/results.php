<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';
include 'includes/header.php';

// Check if result exists in session
if (!isset($_SESSION['dosha_result'])) {
    // Redirect to quiz if no result
    header('Location: quiz.php');
    exit;
}

$result = $_SESSION['dosha_result'];
$primary_dosha = $result['primary_dosha'];
$dosha_info = getDoshaInfo($primary_dosha);

// Check if result was saved to database
$result_saved = isset($_SESSION['quiz_result_id']);
?>

<div class="container">
    <div class="results-container">
        <div class="results-header">
            <h2>Your Dosha Profile</h2>
            <p>Based on your answers, here's your unique Ayurvedic constitution.</p>
        </div>

        <div class="dosha-result">
            <h3>Your Primary Dosha: <?php echo $dosha_info['name']; ?></h3>

            <div class="dosha-chart">
                <?php foreach ($result['percentages'] as $dosha => $percentage): ?>
                    <div class="chart-bar">
                        <div class="chart-label"><?php echo ucfirst($dosha); ?></div>
                        <div class="chart-outer">
                            <div class="chart-inner <?php echo $dosha; ?>" style="width: <?php echo $percentage; ?>%">
                                <?php echo $percentage; ?>%
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="dosha-description">
                <h4>About <?php echo $dosha_info['name']; ?> Dosha</h4>
                <p><?php echo $dosha_info['description']; ?></p>

                <h4>Key Characteristics</h4>
                <p><?php echo $dosha_info['characteristics']; ?></p>
            </div>

            <div class="dosha-recommendations">
                <h4>Recommendations for <?php echo $dosha_info['name']; ?> Types</h4>
                <p><?php echo $dosha_info['recommendations']; ?></p>
            </div>

            <?php if (!IS_LOGGED_IN): ?>
                <div class="save-results-prompt">
                    <h4>Want to save your results?</h4>
                    <div class="prompt-actions">
                        <a href="register.php" class="btn">Create Account</a>
                        <a href="login.php" class="btn">Login</a>
                    </div>
                </div>
            <?php elseif ($result_saved): ?>
                <div class="results-saved">
                    <p>Results saved to your profile</p>
                    <a href="dashboard.php" class="btn">Go to Dashboard</a>
                </div>
            <?php endif; ?>

            <div style="text-align: center; margin-top: 30px;">
                <a href="quiz.php" class="btn">Retake Quiz</a>
                <a href="index.php" class="btn">Learn More About Doshas</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
