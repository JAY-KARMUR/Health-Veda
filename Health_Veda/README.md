# Health Veda - Ayurvedic Dosha Quiz

Health Veda is a web application that helps users discover their Ayurvedic Dosha type (Prakruti) through an interactive quiz. The application is built using HTML, CSS, JavaScript, and PHP with MySQL database integration.

## Features

- Interactive Dosha quiz with 10 questions
- Detailed results showing Dosha percentages and primary Dosha
- User registration and login system
- Ability to save quiz results to user profiles
- Responsive design for all device sizes

## Requirements

- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web server (Apache, Nginx, etc.)
- XAMPP, WAMP, MAMP, or similar local development environment

## Installation

1. Clone or download the repository to your web server's document root (e.g., `htdocs` for XAMPP)
2. Make sure your web server and MySQL server are running
3. Set up the database by either:
   - Importing the `database/health_veda_db.sql` file into your MySQL server, or
   - Running the `setup_database.php` script in your browser (http://localhost/Health_Veda/setup_database.php)
4. Access the website at http://localhost/Health_Veda/

## Database Configuration

If you need to modify the database connection settings, edit the `includes/db_connect.php` file:

```php
// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'health_veda_db');
```

## File Structure

```
Health_Veda/
├── css/
│   └── style.css
├── database/
│   └── health_veda_db.sql
├── images/
├── includes/
│   ├── config.php
│   ├── db_connect.php
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   └── user_functions.php
├── js/
│   └── script.js
├── index.php
├── login.php
├── logout.php
├── profile.php
├── quiz.php
├── register.php
├── result_details.php
├── results.php
├── setup_database.php
└── README.md
```

## Usage

1. Visit the home page to learn about the three Dosha types in Ayurveda
2. Click the "Take the Quiz" button to start the assessment
3. Answer all 10 questions about your physical and mental characteristics
4. Submit your answers to see your personalized Dosha profile
5. Create an account to save your results and track changes over time

## Credits

- Developed by [Your Name]
- Based on Ayurvedic principles and teachings

## License

This project is licensed under the MIT License - see the LICENSE file for details.
