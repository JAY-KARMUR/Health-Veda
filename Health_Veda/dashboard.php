<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';
include 'includes/header.php';

// Redirect to login if not logged in
if (!IS_LOGGED_IN) {
    header('Location: login.php');
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user = getUserById($user_id);

// Get user's latest dosha result
$latest_results = getUserQuizResults($user_id);
$latest_result = !empty($latest_results) ? $latest_results[0] : null;

// Get today's Ayurvedic tip
$today_tip = getTodaysAyurvedicTip();
?>

<div class="container">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo htmlspecialchars($user['first_name'] ? $user['first_name'] : $user['username']); ?>!</h2>
        </div>

        <div class="dashboard-content">
            <?php
                // Define dosha symbols, colors, and elements
                $dosha_symbols = [
                    'vata' => '💨', // Wind/Air symbol
                    'pitta' => '🔥', // Fire symbol
                    'kapha' => '💧', // Water symbol
                ];

                $dosha_colors = [
                    'vata' => 'var(--vata-color)',  // Light blue
                    'pitta' => 'var(--pitta-color)', // Terracotta
                    'kapha' => 'var(--kapha-color)'  // Green
                ];

                $dosha_elements = [
                    'vata' => 'Air & Ether',
                    'pitta' => 'Fire & Water',
                    'kapha' => 'Earth & Water'
                ];

                // Get primary dosha info if available
                $primary_dosha = '';
                $dosha_info = null;

                if ($latest_result) {
                    $primary_dosha = $latest_result['primary_dosha'];
                    $dosha_info = getDoshaInfo($primary_dosha);
                }
            ?>

            <!-- Main Dashboard Layout -->
            <div class="dashboard-grid">
                <!-- Left Column - Dosha Profile -->
                <div class="dashboard-column main-column">
                    <div class="dashboard-section dosha-section">
                        <h3>Your Dosha Profile</h3>
                        <?php if ($latest_result): ?>
                            <div class="dosha-info">
                                <div class="dosha-header">
                                    <div class="dosha-symbol" style="background-color: <?php echo $dosha_colors[$primary_dosha]; ?>">
                                        <?php echo $dosha_symbols[$primary_dosha]; ?>
                                    </div>
                                    <div class="dosha-title">
                                        <h4><?php echo ucfirst($primary_dosha); ?> Dominant</h4>
                                        <p class="dosha-element"><?php echo $dosha_elements[$primary_dosha]; ?></p>
                                    </div>
                                </div>

                                <div class="dosha-description">
                                    <p><?php echo isset($dosha_info['short_desc']) ? $dosha_info['short_desc'] : substr($dosha_info['description'], 0, 150) . '...'; ?></p>
                                </div>

                                <div class="dosha-chart">
                                    <div class="chart-title">Your Dosha Composition</div>
                                    <div class="dosha-percentages">
                                        <?php
                                            // Sort doshas by percentage (highest first)
                                            $doshas = [
                                                'vata' => $latest_result['vata_percentage'],
                                                'pitta' => $latest_result['pitta_percentage'],
                                                'kapha' => $latest_result['kapha_percentage']
                                            ];
                                            arsort($doshas);

                                            foreach ($doshas as $dosha => $percentage):
                                        ?>
                                        <div class="dosha-bar">
                                            <div class="dosha-bar-header">
                                                <span class="dosha-label"><?php echo ucfirst($dosha); ?></span>
                                                <span class="percentage"><?php echo $percentage; ?>%</span>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress <?php echo $dosha; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="dosha-actions">
                                    <a href="results.php" class="btn btn-small">View Detailed Results</a>
                                    <a href="quiz.php" class="btn btn-small btn-outline">Retake Quiz</a>
                                </div>

                                <p class="result-date">Last quiz taken: <?php echo date('F j, Y', strtotime($latest_result['created_at'])); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="no-results">
                                <div class="no-results-icon">❓</div>
                                <h4>Discover Your Dosha</h4>
                                <p>You haven't taken the dosha quiz yet. Take the quiz to discover your unique Ayurvedic constitution.</p>
                                <a href="quiz.php" class="btn">Take the Quiz Now</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column - Tips and Quick Links -->
                <div class="dashboard-column side-column">
                    <!-- Today's Ayurvedic Tip Section -->
                    <div class="dashboard-section tip-section">
                        <h3>Today's Ayurvedic Tip</h3>
                        <div class="tip-content">
                            <p><?php echo $today_tip; ?></p>
                        </div>
                    </div>

                    <!-- Quick Links Section -->
                    <div class="dashboard-section quick-links">
                        <h3>Quick Links</h3>
                        <div class="links-grid">
                            <a href="quiz.php" class="quick-link">
                                <div class="link-icon">📋</div>
                                <div class="link-text">Retake Quiz</div>
                            </a>
                            <a href="ayurveda.php" class="quick-link">
                                <div class="link-icon">🌿</div>
                                <div class="link-text">Ayurveda</div>
                            </a>
                            <a href="about.php" class="quick-link">
                                <div class="link-icon">📚</div>
                                <div class="link-text">Doshas</div>
                            </a>
                            <a href="profile.php" class="quick-link">
                                <div class="link-icon">👤</div>
                                <div class="link-text">My Profile</div>
                            </a>
                            <a href="logout.php" class="quick-link">
                                <div class="link-icon">🚪</div>
                                <div class="link-text">Logout</div>
                            </a>
                        </div>
                    </div>

                    <?php if ($latest_result): ?>
                    <!-- Dosha Recommendations -->
                    <div class="dashboard-section recommendations-section">
                        <h3>Recommendations for You</h3>
                        <div class="recommendations-content">
                            <p class="recommendations-intro">Based on your <?php echo ucfirst($primary_dosha); ?> dominance:</p>
                            <ul class="recommendations-list">
                                <?php
                                    // Create an array of recommendations based on dosha type
                                    $recommendations = [];

                                    if ($primary_dosha == 'vata') {
                                        $recommendations = [
                                            'Maintain regular daily routines',
                                            'Stay warm and avoid cold, dry environments',
                                            'Practice calming, grounding activities',
                                            'Eat warm, nourishing foods regularly',
                                            'Get adequate rest and avoid overexertion'
                                        ];
                                    } elseif ($primary_dosha == 'pitta') {
                                        $recommendations = [
                                            'Avoid excessive heat and direct sunlight',
                                            'Eat cooling, refreshing foods',
                                            'Practice moderation in all activities',
                                            'Manage stress through meditation',
                                            'Avoid skipping meals and stay hydrated'
                                        ];
                                    } elseif ($primary_dosha == 'kapha') {
                                        $recommendations = [
                                            'Maintain regular physical activity',
                                            'Avoid excessive sleep and daytime naps',
                                            'Eat warm, light, and spicy foods',
                                            'Incorporate variety and new experiences',
                                            'Practice energizing breathing exercises'
                                        ];
                                    }

                                    // Display recommendations
                                    foreach ($recommendations as $recommendation):
                                ?>
                                <li><?php echo $recommendation; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
