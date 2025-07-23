<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';

// Redirect if not logged in
if (!IS_LOGGED_IN) {
    header('Location: login.php');
    exit;
}

// Get result ID from URL
$result_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get result data
$result = getQuizResultById($result_id);

// Check if result exists and belongs to the current user
if (!$result || $result['user_id'] != $_SESSION['user_id']) {
    header('Location: profile.php');
    exit;
}

// Get dosha information
$primary_dosha = $result['primary_dosha'];
$dosha_info = getDoshaInfo($primary_dosha);

include 'includes/header.php';
?>

<div class="container">
    <div class="results-container">
        <div class="results-header">
            <h2>Your Dosha Profile</h2>
            <p>Result from <?php echo date('F j, Y', strtotime($result['created_at'])); ?></p>
        </div>
        
        <div class="dosha-result">
            <h3>Your Primary Dosha: <?php echo $dosha_info['name']; ?></h3>
            
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
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="profile.php" class="btn">Back to Profile</a>
                <a href="quiz.php" class="btn">Retake Quiz</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
