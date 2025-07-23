<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';

// Redirect if not logged in
if (!IS_LOGGED_IN) {
    header('Location: login.php');
    exit;
}

// Get user data
$user = getUserById($_SESSION['user_id']);

// Get user quiz results
$quiz_results = getUserQuizResults($_SESSION['user_id']);

include 'includes/header.php';
?>

<div class="container">
    <div class="profile-container">
        <div class="profile-header">
            <h2>Your Profile</h2>
            <p>Welcome, <?php echo htmlspecialchars($user['first_name'] ? $user['first_name'] : $user['username']); ?>!</p>
        </div>

        <div class="profile-info">
            <div class="profile-info-header">
                <h3>Account Information</h3>
                <a href="edit_profile.php" class="btn btn-small btn-outline">Edit Profile</a>
            </div>

            <div class="info-group">
                <label>Username:</label>
                <span><?php echo htmlspecialchars($user['username']); ?></span>
            </div>

            <div class="info-group">
                <label>Email:</label>
                <span><?php echo htmlspecialchars($user['email']); ?></span>
            </div>

            <?php if ($user['first_name'] || $user['last_name']): ?>
                <div class="info-group">
                    <label>Name:</label>
                    <span><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                </div>
            <?php endif; ?>

            <div class="info-group">
                <label>Member Since:</label>
                <span><?php echo date('F j, Y', strtotime($user['created_at'])); ?></span>
            </div>
        </div>

        <div class="profile-results">
            <h3>Your Dosha Quiz Results</h3>

            <?php if (empty($quiz_results)): ?>
                <p>You haven't taken the Dosha quiz yet. <a href="quiz.php">Take the quiz now</a> to discover your Ayurvedic constitution.</p>
            <?php else: ?>
                <div class="results-list">
                    <?php foreach ($quiz_results as $index => $result): ?>
                        <div class="result-card">
                            <div class="result-header">
                                <h4>Quiz Result #<?php echo $index + 1; ?></h4>
                                <span class="result-date"><?php echo date('F j, Y', strtotime($result['created_at'])); ?></span>
                            </div>

                            <div class="result-body">
                                <div class="primary-dosha">
                                    <span class="label">Primary Dosha:</span>
                                    <span class="value <?php echo $result['primary_dosha']; ?>"><?php echo ucfirst($result['primary_dosha']); ?></span>
                                </div>

                                <div class="dosha-chart">
                                    <div class="chart-bar">
                                        <div class="chart-label">Vata</div>
                                        <div class="chart-outer">
                                            <div class="chart-inner vata" style="width: <?php echo $result['vata_percentage']; ?>%">
                                                <?php echo $result['vata_percentage']; ?>%
                                            </div>
                                        </div>
                                    </div>

                                    <div class="chart-bar">
                                        <div class="chart-label">Pitta</div>
                                        <div class="chart-outer">
                                            <div class="chart-inner pitta" style="width: <?php echo $result['pitta_percentage']; ?>%">
                                                <?php echo $result['pitta_percentage']; ?>%
                                            </div>
                                        </div>
                                    </div>

                                    <div class="chart-bar">
                                        <div class="chart-label">Kapha</div>
                                        <div class="chart-outer">
                                            <div class="chart-inner kapha" style="width: <?php echo $result['kapha_percentage']; ?>%">
                                                <?php echo $result['kapha_percentage']; ?>%
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="result-actions">
                                    <a href="result_details.php?id=<?php echo $result['id']; ?>" class="btn btn-small">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="take-quiz-again">
                    <p>Want to take the quiz again? <a href="quiz.php">Take the Dosha Quiz</a></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-danger-zone">
            <h3>Account Management</h3>
            <div class="danger-zone-content">
                <div class="warning-box">
                    <h4>Delete Account</h4>
                    <p>Warning: Deleting your account is permanent and cannot be undone. All your data, including quiz results, will be lost.</p>
                    <a href="delete_account.php" class="btn btn-danger">Delete My Account</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
