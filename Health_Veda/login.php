<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/user_functions.php';

// Redirect if already logged in
if (IS_LOGGED_IN) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$username = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Login user
    $result = loginUser($username, $password);

    if ($result['success']) {
        // Redirect to dashboard page
        header('Location: dashboard.php');
        exit;
    } else {
        $error = $result['message'];
    }
}

include 'includes/header.php';
?>

<div class="container">
    <div class="auth-container">
        <div class="auth-header">
            <h2>Login to Your Account</h2>
            <p>Access your Health Veda profile and view your Dosha quiz results.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="login.php" class="auth-form">
            <div class="form-group">
                <label for="username">Username or Email <span class="required">*</span></label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-full">Login</button>
            </div>

            <div class="auth-links">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
