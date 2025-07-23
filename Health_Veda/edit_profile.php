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
    // Get form data
    $email = trim($_POST['email'] ?? '');
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate email
    if (empty($email)) {
        $error = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } 
    // Validate password if being changed
    elseif (!empty($new_password) && $new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match.';
    } else {
        // Update user data
        $data = [
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name
        ];
        
        $result = updateUser($_SESSION['user_id'], $data, $current_password, $new_password);
        
        if ($result['success']) {
            $success = $result['message'];
            // Refresh user data
            $user = getUserById($_SESSION['user_id']);
        } else {
            $error = $result['message'];
        }
    }
}

include 'includes/header.php';
?>

<div class="container">
    <div class="edit-profile-container">
        <div class="edit-profile-header">
            <h2>Edit Your Profile</h2>
            <p>Update your personal information below.</p>
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
        
        <form method="post" action="edit_profile.php" class="edit-profile-form">
            <div class="form-section">
                <h3>Personal Information</h3>
                
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    <small>Changing your email requires password verification.</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>">
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Change Password</h3>
                <p class="section-info">Leave these fields blank if you don't want to change your password.</p>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password">
                    <small>Must be at least 8 characters long.</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                </div>
            </div>
            
            <div class="form-section">
                <h3>Password Verification</h3>
                <p class="section-info">Enter your current password to confirm changes to email or password.</p>
                
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password">
                    <small>Required only when changing email or password.</small>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
