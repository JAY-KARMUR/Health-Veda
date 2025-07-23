<?php
require_once 'includes/config.php';
require_once 'includes/user_functions.php';

// Logout user
logoutUser();

// Redirect to home page
header('Location: index.php');
exit;
?>
