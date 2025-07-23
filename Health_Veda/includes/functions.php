<?php
require_once 'config.php';

/**
 * Get all quiz questions
 *
 * @return array Array of quiz questions
 */
function getQuizQuestions() {
    return [
        [
            'question' => 'How would you describe your body build?',
            'options' => [
                'vata' => 'I am slim and have difficulty gaining weight',
                'pitta' => 'I have an average build and maintain my weight easily',
                'kapha' => 'I have a sturdy build and tend to gain weight easily'
            ]
        ],
        [
            'question' => 'How does your skin usually feel?',
            'options' => [
                'vata' => 'My skin is usually dry and sometimes flaky',
                'pitta' => 'My skin is warm and sometimes gets red or irritated',
                'kapha' => 'My skin is smooth, thick and tends to be oily'
            ]
        ],
        [
            'question' => 'What is your hair like?',
            'options' => [
                'vata' => 'My hair tends to be dry, frizzy or brittle',
                'pitta' => 'My hair is fine, straight, or I noticed early graying',
                'kapha' => 'My hair is thick, wavy, and tends to be oily'
            ]
        ],
        [
            'question' => 'How would you describe your eating habits?',
            'options' => [
                'vata' => 'I sometimes forget to eat and have no regular meal schedule',
                'pitta' => 'I get hungry on time and feel irritable if I miss a meal',
                'kapha' => 'I can easily skip meals and still feel fine'
            ]
        ],
        [
            'question' => 'How does your digestion work?',
            'options' => [
                'vata' => 'I often get bloated or gassy after eating',
                'pitta' => 'I digest food quickly but sometimes get heartburn',
                'kapha' => 'I digest slowly but rarely have stomach issues'
            ]
        ],
        [
            'question' => 'What type of weather bothers you most?',
            'options' => [
                'vata' => 'I dislike cold and windy weather the most',
                'pitta' => 'I dislike hot and humid weather the most',
                'kapha' => 'I dislike cold and damp weather the most'
            ]
        ],
        [
            'question' => 'How do you usually sleep?',
            'options' => [
                'vata' => 'I often wake up during the night or have light sleep',
                'pitta' => 'I usually sleep 6-8 hours and wake up refreshed',
                'kapha' => 'I sleep deeply and for long hours'
            ]
        ],
        [
            'question' => 'How do you speak?',
            'options' => [
                'vata' => 'I talk fast and sometimes jump from topic to topic',
                'pitta' => 'I speak clearly and directly to the point',
                'kapha' => 'I speak slowly and think carefully before talking'
            ]
        ],
        [
            'question' => 'How do you handle stress?',
            'options' => [
                'vata' => 'I tend to feel anxious, worried or overwhelmed',
                'pitta' => 'I tend to get irritated, frustrated or angry',
                'kapha' => 'I usually stay calm but might become quiet or withdrawn'
            ]
        ],
        [
            'question' => 'How do you learn new things?',
            'options' => [
                'vata' => 'I learn quickly but might forget things easily',
                'pitta' => 'I have good memory and learn at a steady pace',
                'kapha' => 'I learn slowly but remember things for a long time'
            ]
        ],
        [
            'question' => 'How do you handle your finances?',
            'options' => [
                'vata' => 'I tend to spend spontaneously and don\'t save much',
                'pitta' => 'I buy quality items and plan my spending carefully',
                'kapha' => 'I save regularly and avoid unnecessary purchases'
            ]
        ],
        [
            'question' => 'What kind of physical activity do you prefer?',
            'options' => [
                'vata' => 'I enjoy light activities like walking, dancing or stretching',
                'pitta' => 'I enjoy challenging activities like running or competitive sports',
                'kapha' => 'I enjoy steady activities like swimming or gentle yoga'
            ]
        ],
        [
            'question' => 'How is your energy throughout the day?',
            'options' => [
                'vata' => 'My energy comes and goes in bursts',
                'pitta' => 'I have steady energy but can get burnt out if I push too hard',
                'kapha' => 'My energy is consistent and rarely changes much'
            ]
        ],
        [
            'question' => 'How do you make decisions?',
            'options' => [
                'vata' => 'I often change my mind and find it hard to decide',
                'pitta' => 'I make decisions quickly and confidently',
                'kapha' => 'I take my time to decide and stick with my choice'
            ]
        ],
        [
            'question' => 'How do you handle new situations?',
            'options' => [
                'vata' => 'I adapt quickly and often enjoy trying new things',
                'pitta' => 'I adapt when necessary but prefer to be in control',
                'kapha' => 'I prefer familiar routines and find change challenging'
            ]
        ]
    ];
}

/**
 * Calculate dosha type based on quiz answers
 *
 * @param array $answers Array of answers with dosha types
 * @return array Dosha scores and primary dosha
 */
function calculateDoshaType($answers) {
    $scores = [
        'vata' => 0,
        'pitta' => 0,
        'kapha' => 0
    ];

    // Count the number of each dosha type selected
    foreach ($answers as $answer) {
        if (isset($scores[$answer])) {
            $scores[$answer]++;
        }
    }

    // Determine the primary dosha (highest score)
    $primary_dosha = array_keys($scores, max($scores))[0];

    // Calculate percentages
    $total = array_sum($scores);
    $percentages = [
        'vata' => round(($scores['vata'] / $total) * 100),
        'pitta' => round(($scores['pitta'] / $total) * 100),
        'kapha' => round(($scores['kapha'] / $total) * 100)
    ];

    return [
        'scores' => $scores,
        'percentages' => $percentages,
        'primary_dosha' => $primary_dosha
    ];
}

/**
 * Get dosha information by type
 *
 * @param string $type Dosha type (vata, pitta, kapha)
 * @return array Dosha information
 */
function getDoshaInfo($type) {
    global $dosha_types;

    if (isset($dosha_types[$type])) {
        return $dosha_types[$type];
    }

    return null;
}

/**
 * Get today's Ayurvedic tip
 *
 * @return string Random Ayurvedic tip for the day
 */
function getTodaysAyurvedicTip() {
    // Array of Ayurvedic tips
    $tips = [
        "Start your day with a glass of warm water and lemon to stimulate digestion.",
        "Try oil pulling with coconut or sesame oil for 5-10 minutes each morning for oral health.",
        "Incorporate turmeric into your meals for its anti-inflammatory properties.",
        "Practice deep breathing for 5 minutes daily to balance your doshas.",
        "Massage your feet with warm oil before bed for better sleep quality.",
        "Eat your largest meal at lunch when digestive fire (agni) is strongest.",
        "Sip warm ginger tea throughout the day to improve digestion.",
        "Practice self-massage (abhyanga) with warm oil once a week.",
        "Include all six tastes (sweet, sour, salty, pungent, bitter, astringent) in your meals.",
        "Avoid ice-cold drinks as they dampen your digestive fire.",
        "Try to eat mindfully, without distractions like TV or phones.",
        "Favor cooked foods over raw foods, especially in cold weather.",
        "Consider your mental state while eating - eat in a calm, relaxed environment.",
        "Drink warm water throughout the day instead of cold water.",
        "Practice gentle yoga or stretching daily to maintain flexibility and balance doshas.",
        "Use warming spices like ginger, cinnamon, and cardamom in fall and winter.",
        "Try to maintain regular meal times to support healthy digestion.",
        "Consider a short walk after meals to aid digestion.",
        "Favor seasonal and local foods for better nutritional value.",
        "Practice meditation daily to balance the mind and reduce stress."
    ];

    // Use the date to select a tip (ensures the same tip is shown all day)
    $day_of_year = date('z'); // 0-365
    $tip_index = $day_of_year % count($tips);

    return $tips[$tip_index];
}
?>
