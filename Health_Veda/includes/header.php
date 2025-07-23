<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Veda - Discover Your Ayurvedic Dosha</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h1><a href="index.php">Health Veda</a></h1>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="quiz.php">Take Quiz</a></li>
                    <li><a href="ayurveda.php">Ayurveda</a></li>
                    <li><a href="about.php">About Doshas</a></li>
                    <?php if (IS_LOGGED_IN): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
