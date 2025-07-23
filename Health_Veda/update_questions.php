<?php
/**
 * Update Questions Script
 *
 * This script updates the questions in the database
 */

// Display header
echo "===========================================\n";
echo "Health Veda Questions Update\n";
echo "===========================================\n\n";

// Database credentials
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'health_veda_db';

// Connect to MySQL server
echo "Connecting to MySQL server...\n";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "Connected successfully.\n\n";

// Truncate questions table
echo "Clearing existing questions...\n";
$sql = "TRUNCATE TABLE questions";
if ($conn->query($sql) === TRUE) {
    echo "Questions table cleared successfully.\n";
} else {
    echo "Error clearing questions table: " . $conn->error . "\n";
    die();
}

// Insert new questions
echo "\nInserting new questions...\n";
$sql = "INSERT INTO questions (question_text, vata_option, pitta_option, kapha_option) VALUES
('How would you describe your body build?', 'I am slim and have difficulty gaining weight', 'I have an average build and maintain my weight easily', 'I have a sturdy build and tend to gain weight easily'),
('How does your skin usually feel?', 'My skin is usually dry and sometimes flaky', 'My skin is warm and sometimes gets red or irritated', 'My skin is smooth, thick and tends to be oily'),
('What is your hair like?', 'My hair tends to be dry, frizzy or brittle', 'My hair is fine, straight, or I noticed early graying', 'My hair is thick, wavy, and tends to be oily'),
('How would you describe your eating habits?', 'I sometimes forget to eat and have no regular meal schedule', 'I get hungry on time and feel irritable if I miss a meal', 'I can easily skip meals and still feel fine'),
('How does your digestion work?', 'I often get bloated or gassy after eating', 'I digest food quickly but sometimes get heartburn', 'I digest slowly but rarely have stomach issues'),
('What type of weather bothers you most?', 'I dislike cold and windy weather the most', 'I dislike hot and humid weather the most', 'I dislike cold and damp weather the most'),
('How do you usually sleep?', 'I often wake up during the night or have light sleep', 'I usually sleep 6-8 hours and wake up refreshed', 'I sleep deeply and for long hours'),
('How do you speak?', 'I talk fast and sometimes jump from topic to topic', 'I speak clearly and directly to the point', 'I speak slowly and think carefully before talking'),
('How do you handle stress?', 'I tend to feel anxious, worried or overwhelmed', 'I tend to get irritated, frustrated or angry', 'I usually stay calm but might become quiet or withdrawn'),
('How do you learn new things?', 'I learn quickly but might forget things easily', 'I have good memory and learn at a steady pace', 'I learn slowly but remember things for a long time'),
('How do you handle your finances?', 'I tend to spend spontaneously and don\'t save much', 'I buy quality items and plan my spending carefully', 'I save regularly and avoid unnecessary purchases'),
('What kind of physical activity do you prefer?', 'I enjoy light activities like walking, dancing or stretching', 'I enjoy challenging activities like running or competitive sports', 'I enjoy steady activities like swimming or gentle yoga'),
('How is your energy throughout the day?', 'My energy comes and goes in bursts', 'I have steady energy but can get burnt out if I push too hard', 'My energy is consistent and rarely changes much'),
('How do you make decisions?', 'I often change my mind and find it hard to decide', 'I make decisions quickly and confidently', 'I take my time to decide and stick with my choice'),
('How do you handle new situations?', 'I adapt quickly and often enjoy trying new things', 'I adapt when necessary but prefer to be in control', 'I prefer familiar routines and find change challenging')";

if ($conn->query($sql) === TRUE) {
    echo "New questions inserted successfully.\n";
} else {
    echo "Error inserting new questions: " . $conn->error . "\n";
}

// Close connection
$conn->close();

echo "\n===========================================\n";
echo "Questions update completed successfully!\n";
echo "===========================================\n";
echo "\nYou can now take the updated quiz with 15 questions.\n";
echo "Visit http://localhost/Health_Veda/quiz.php to get started.\n";
?>
