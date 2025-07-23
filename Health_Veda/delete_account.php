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
$error = '';
$success = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = isset($_POST['confirm']) && $_POST['confirm'] === 'yes';
    
    if (!$confirm) {
        $error = 'You must confirm that you want to delete your account by checking the confirmation box.';
    } elseif (empty($password)) {
        $error = 'Please enter your password to confirm account deletion.';
    } else {
        // Delete user account
        $result = deleteUser($_SESSION['user_id'], $password);
        
        if ($result['success']) {
            // Redirect to home page with success message
            $_SESSION['delete_success'] = $result['message'];
            header('Location: index.php');
            exit;
        } else {
            $error = $result['message'];
        }
    }
}

include 'includes/header.php';
?>

<div class="container">
    <div class="delete-account-container">
        <div class="delete-header">
            <h2>Delete Your Account</h2>
            <p>We're sorry to see you go, <?php echo htmlspecialchars($user['first_name'] ? $user['first_name'] : $user['username']); ?>.</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <div class="delete-warning">
            <h3>Warning: This action cannot be undone</h3>
            <p>Deleting your account will:</p>
            <ul>
                <li>Permanently remove your account information</li>
                <li>Delete all your saved quiz results</li>
                <li>Log you out immediately</li>
            </ul>
            <p>Your quiz results will be anonymized but kept in our system for statistical purposes.</p>
        </div>
        
        <form method="post" action="delete_account.php" class="delete-form">
            <div class="form-group">
                <label for="password">Enter your password to confirm <span class="required">*</span></label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group checkbox-group">
                <input type="checkbox" id="confirm" name="confirm" value="yes">
                <label for="confirm">I understand that this action is permanent and cannot be undone</label>
            </div>
            
            <div class="form-actions">
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-danger">Delete My Account</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
