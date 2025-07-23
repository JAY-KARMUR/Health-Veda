<?php
// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session start
session_start();

// Include database connection
require_once 'db_connect.php';

// Define constants
define('SITE_NAME', 'Health Veda');
define('SITE_URL', 'http://localhost/Health_Veda/');

// User authentication status
define('IS_LOGGED_IN', isset($_SESSION['user_id']));

// Dosha types
$dosha_types = [
    'vata' => [
        'name' => 'Vata',
        'description' => 'Vata dosha is associated with air and space elements. Vata individuals are typically creative, energetic, and quick-thinking. When in balance, Vata types are lively and enthusiastic. When out of balance, they may experience anxiety, dry skin, and digestive issues.',
        'short_desc' => 'Creative, energetic, and quick-thinking. You have a natural gift for adaptability and are often full of innovative ideas.',
        'characteristics' => 'Light, thin body frame, prominent joints, dry skin, cold hands and feet, quick to learn but quick to forget, creative, enthusiastic, energetic when in balance.',
        'recommendations' => 'Maintain regular routines, stay warm, practice grounding activities, eat warm and nourishing foods, get adequate rest, and avoid excessive stimulation.'
    ],
    'pitta' => [
        'name' => 'Pitta',
        'description' => 'Pitta dosha is associated with fire and water elements. Pitta individuals are typically intelligent, focused, and ambitious. When in balance, Pitta types are warm, friendly, and productive. When out of balance, they may experience irritability, inflammation, and digestive issues.',
        'short_desc' => 'Focused, intelligent, and determined. You have natural leadership qualities and excel at accomplishing your goals.',
        'characteristics' => 'Medium build, strong digestion, sharp intellect, good concentration, leadership qualities, warm body temperature, precise and organized, passionate and determined.',
        'recommendations' => 'Avoid excessive heat and sun exposure, eat cooling foods, practice moderation, manage stress and anger, avoid skipping meals, and engage in moderate exercise.'
    ],
    'kapha' => [
        'name' => 'Kapha',
        'description' => 'Kapha dosha is associated with earth and water elements. Kapha individuals are typically calm, strong, and stable. When in balance, Kapha types are loving, loyal, and supportive. When out of balance, they may experience weight gain, congestion, and lethargy.',
        'short_desc' => 'Calm, strong, and nurturing. You have natural stability and are often the reliable, supportive presence in others\' lives.',
        'characteristics' => 'Solid, strong build, smooth and oily skin, thick hair, steady energy, calm demeanor, slow to learn but excellent long-term memory, compassionate, loyal, and patient.',
        'recommendations' => 'Stay active with regular exercise, avoid excessive sleep, eat warm and light foods, incorporate variety and stimulation into routines, and practice energizing activities.'
    ]
];
?>
