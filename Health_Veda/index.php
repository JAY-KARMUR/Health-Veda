<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
include 'includes/header.php';

// Check for delete account success message
$delete_success = '';
if (isset($_SESSION['delete_success'])) {
    $delete_success = $_SESSION['delete_success'];
    unset($_SESSION['delete_success']);
}
?>

<?php if ($delete_success): ?>
<div class="container">
    <div class="alert alert-success">
        <?php echo $delete_success; ?>
    </div>
</div>
<?php endif; ?>

<div class="hero">
    <div class="container">
        <h2>Discover Your Ayurvedic Dosha Type</h2>
        <p>Take our comprehensive quiz to understand your unique mind-body constitution according to <a href="ayurveda.php" style="color: #fff; text-decoration: underline;">Ayurveda</a>, the ancient Indian system of medicine.</p>
        <a href="quiz.php" class="btn">Take the Quiz</a>
    </div>
</div>

<section class="about" id="about">
    <div class="container">
        <div class="section-title">
            <h2>Understanding Doshas</h2>
        </div>
        <p>According to Ayurveda, each person has a unique mix of three doshas - Vata, Pitta, and Kapha - which determines their physical, mental, and emotional characteristics. While everyone has all three doshas, most people have one or two that are more dominant.</p>
        <p>Understanding your dosha composition can help you make lifestyle choices that promote balance and well-being. Our quiz will help you discover your dominant dosha and provide personalized recommendations.</p>

        <div class="dosha-cards">
            <div class="dosha-card vata">
                <div class="dosha-card-header">
                    <h3>Vata</h3>
                </div>
                <div class="dosha-card-body">
                    <p><strong>Elements:</strong> Air and Space</p>
                    <p><strong>Qualities:</strong> Light, cold, dry, rough, subtle, mobile</p>
                    <p>Vata types are creative, quick-thinking, and energetic. They tend to have a light build, dry skin, and variable appetite.</p>
                    <p>When in balance: Enthusiastic, vibrant, and creative</p>
                    <p>When out of balance: Anxious, restless, and fatigued</p>
                </div>
            </div>

            <div class="dosha-card pitta">
                <div class="dosha-card-header">
                    <h3>Pitta</h3>
                </div>
                <div class="dosha-card-body">
                    <p><strong>Elements:</strong> Fire and Water</p>
                    <p><strong>Qualities:</strong> Hot, sharp, light, oily, liquid, spreading</p>
                    <p>Pitta types are intelligent, focused, and ambitious. They tend to have a medium build, warm skin, and strong appetite.</p>
                    <p>When in balance: Focused, confident, and productive</p>
                    <p>When out of balance: Irritable, critical, and inflammatory</p>
                </div>
            </div>

            <div class="dosha-card kapha">
                <div class="dosha-card-header">
                    <h3>Kapha</h3>
                </div>
                <div class="dosha-card-body">
                    <p><strong>Elements:</strong> Earth and Water</p>
                    <p><strong>Qualities:</strong> Heavy, slow, cool, oily, smooth, dense, soft, stable</p>
                    <p>Kapha types are calm, strong, and stable. They tend to have a solid build, smooth skin, and steady appetite.</p>
                    <p>When in balance: Calm, loving, and supportive</p>
                    <p>When out of balance: Lethargic, attached, and resistant to change</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
