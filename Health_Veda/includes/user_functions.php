<?php
/**
 * User-related functions
 */

/**
 * Delete a user account
 *
 * @param int $user_id User ID
 * @param string $password Password for verification
 * @return array Result of deletion
 */
function deleteUser($user_id, $password) {
    global $conn;

    // Verify user exists
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [
            'success' => false,
            'message' => 'User not found.'
        ];
    }

    // Verify password
    $user = $result->fetch_assoc();
    if (!password_verify($password, $user['password'])) {
        return [
            'success' => false,
            'message' => 'Incorrect password. Please try again.'
        ];
    }

    // Delete user
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Log the user out
        logoutUser();

        return [
            'success' => true,
            'message' => 'Your account has been successfully deleted.'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to delete account. Please try again later.'
        ];
    }
}

/**
 * Register a new user
 *
 * @param string $username Username
 * @param string $email Email
 * @param string $password Password
 * @param string $first_name First name
 * @param string $last_name Last name
 * @return array Result of registration
 */
function registerUser($username, $email, $password, $first_name = '', $last_name = '') {
    global $conn;

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Please fill in all required fields.'
        ];
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return [
            'success' => false,
            'message' => 'Username already exists. Please choose a different username.'
        ];
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return [
            'success' => false,
            'message' => 'Email already exists. Please use a different email or login to your account.'
        ];
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $hashed_password, $first_name, $last_name);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        // Automatically log in the user
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;

        return [
            'success' => true,
            'message' => 'Registration successful! You are now logged in.',
            'user_id' => $user_id
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Registration failed. Please try again later.'
        ];
    }
}

/**
 * Login a user
 *
 * @param string $username Username or email
 * @param string $password Password
 * @return array Result of login
 */
function loginUser($username, $password) {
    global $conn;

    // Validate input
    if (empty($username) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Please fill in all fields.'
        ];
    }

    // Check if username/email exists
    $stmt = $conn->prepare("SELECT id, username, email, password, first_name, last_name FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return [
            'success' => false,
            'message' => 'Invalid username/email or password.'
        ];
    }

    // Verify password
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];

        return [
            'success' => true,
            'message' => 'Login successful!',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name']
            ]
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Invalid username/email or password.'
        ];
    }
}

/**
 * Logout a user
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();
}

/**
 * Get user by ID
 *
 * @param int $user_id User ID
 * @return array|null User data or null if not found
 */
function getUserById($user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, username, email, first_name, last_name, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return null;
    }

    return $result->fetch_assoc();
}

/**
 * Save quiz result to database
 *
 * @param int|null $user_id User ID (null for guest users)
 * @param array $result Quiz result
 * @return int|false Result ID or false on failure
 */
function saveQuizResult($user_id, $result) {
    global $conn;

    $vata_score = $result['scores']['vata'];
    $pitta_score = $result['scores']['pitta'];
    $kapha_score = $result['scores']['kapha'];
    $vata_percentage = $result['percentages']['vata'];
    $pitta_percentage = $result['percentages']['pitta'];
    $kapha_percentage = $result['percentages']['kapha'];
    $primary_dosha = $result['primary_dosha'];

    $stmt = $conn->prepare("INSERT INTO quiz_results (user_id, vata_score, pitta_score, kapha_score, vata_percentage, pitta_percentage, kapha_percentage, primary_dosha) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiidddss", $user_id, $vata_score, $pitta_score, $kapha_score, $vata_percentage, $pitta_percentage, $kapha_percentage, $primary_dosha);

    if ($stmt->execute()) {
        return $conn->insert_id;
    } else {
        return false;
    }
}

/**
 * Get quiz results for a user
 *
 * @param int $user_id User ID
 * @return array Quiz results
 */
function getUserQuizResults($user_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM quiz_results WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    return $results;
}

/**
 * Get quiz result by ID
 *
 * @param int $result_id Result ID
 * @return array|null Quiz result or null if not found
 */
function getQuizResultById($result_id) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM quiz_results WHERE id = ?");
    $stmt->bind_param("i", $result_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return null;
    }

    return $result->fetch_assoc();
}

/**
 * Update user information
 *
 * @param int $user_id User ID
 * @param array $data User data to update (email, first_name, last_name)
 * @param string $current_password Current password for verification (required for email change)
 * @param string $new_password New password (optional)
 * @return array Result of update
 */
function updateUser($user_id, $data, $current_password = '', $new_password = '') {
    global $conn;

    // Get current user data
    $current_user = getUserById($user_id);
    if (!$current_user) {
        return [
            'success' => false,
            'message' => 'User not found.'
        ];
    }

    // Initialize variables
    $email = $data['email'] ?? $current_user['email'];
    $first_name = $data['first_name'] ?? $current_user['first_name'];
    $last_name = $data['last_name'] ?? $current_user['last_name'];
    $password_updated = false;

    // Check if email is being changed
    $email_changed = ($email !== $current_user['email']);

    // If email is being changed or password is being updated, verify current password
    if (($email_changed || !empty($new_password)) && empty($current_password)) {
        return [
            'success' => false,
            'message' => 'Current password is required to change email or password.'
        ];
    }

    // If email is being changed or password is being updated, verify current password
    if (($email_changed || !empty($new_password))) {
        // Verify current password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!password_verify($current_password, $user['password'])) {
            return [
                'success' => false,
                'message' => 'Current password is incorrect.'
            ];
        }
    }

    // If email is being changed, check if it already exists
    if ($email_changed) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return [
                'success' => false,
                'message' => 'Email already exists. Please use a different email.'
            ];
        }
    }

    // Start building the update query
    $query = "UPDATE users SET email = ?, first_name = ?, last_name = ?";
    $types = "sss";
    $params = [$email, $first_name, $last_name];

    // If new password is provided, update it
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query .= ", password = ?";
        $types .= "s";
        $params[] = $hashed_password;
        $password_updated = true;
    }

    // Add WHERE clause
    $query .= " WHERE id = ?";
    $types .= "i";
    $params[] = $user_id;

    // Execute update query
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['email'] = $email;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;

        return [
            'success' => true,
            'message' => 'Your profile has been updated successfully.' .
                        ($password_updated ? ' Your password has been changed.' : ''),
            'email_changed' => $email_changed,
            'password_updated' => $password_updated
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Failed to update profile. Please try again later.'
        ];
    }
}
?>
