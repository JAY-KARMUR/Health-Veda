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
$success = '';
$username = '';
$email = '';
$first_name = '';
$last_name = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');

    // Validate password match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Register user
        $result = registerUser($username, $email, $password, $first_name, $last_name);

        if ($result['success']) {
            // Redirect to dashboard since user is now logged in
            header('Location: dashboard.php');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}

include 'includes/header.php';
?>

<div class="container">
    <div class="auth-container">
        <div class="auth-header">
            <h2>Create an Account</h2>
            <p>Join Health Veda to save your Dosha quiz results and track your Ayurvedic profile over time.</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <p>You can now <a href="login.php">login to your account</a>.</p>
            </div>
        <?php else: ?>
            <form method="post" action="register.php" class="auth-form">
                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-full">Register</button>
                </div>

                <div class="auth-links">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
