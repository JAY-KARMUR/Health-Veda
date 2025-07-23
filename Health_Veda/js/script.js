document.addEventListener('DOMContentLoaded', function() {
    // Quiz functionality
    const quizForm = document.getElementById('quiz-form');
    if (quizForm) {
        const questions = document.querySelectorAll('.question');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');

        let currentQuestion = 0;

        // Show only the first question initially
        showQuestion(currentQuestion);

        // Function to go to next question
        function goToNextQuestion() {
            // Check if an option is selected for the current question
            const isSelected = questions[currentQuestion].querySelector('input[type="radio"]:checked');

            if (!isSelected) {
                alert('Please select an option before proceeding.');
                return;
            }

            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                showQuestion(currentQuestion);
            } else if (currentQuestion === questions.length - 1 && submitBtn) {
                // If it's the last question, focus on the submit button
                submitBtn.focus();
            }
        }

        // Event listeners for navigation buttons
        if (prevBtn) {
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                if (currentQuestion > 0) {
                    currentQuestion--;
                    showQuestion(currentQuestion);
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                goToNextQuestion();
            });
        }

        // Add event listener for Enter key
        document.addEventListener('keydown', function(e) {
            // Check if quiz form is present in the DOM (we're on the quiz page)
            if (quizForm && e.key === 'Enter') {
                // Prevent default action (form submission)
                e.preventDefault();

                // If we're on the last question and submit button is visible, submit the form
                if (currentQuestion === questions.length - 1) {
                    submitBtn.click();
                } else {
                    // Otherwise go to next question
                    goToNextQuestion();
                }
            }
        });

        // Form validation before submission
        if (quizForm) {
            quizForm.addEventListener('submit', function(e) {
                // Check if all questions are answered
                let unansweredQuestion = -1;

                for (let i = 0; i < questions.length; i++) {
                    const options = questions[i].querySelectorAll('input[type="radio"]:checked');
                    if (options.length === 0) {
                        unansweredQuestion = i;
                        break;
                    }
                }

                if (unansweredQuestion !== -1) {
                    e.preventDefault();
                    alert('Please answer all questions before submitting.');
                    currentQuestion = unansweredQuestion;
                    showQuestion(currentQuestion);
                }
            });
        }

        // Function to show the current question and update navigation buttons
        function showQuestion(index) {
            questions.forEach((question, i) => {
                if (i === index) {
                    question.style.display = 'block';
                } else {
                    question.style.display = 'none';
                }
            });

            // Update navigation buttons
            if (prevBtn) {
                prevBtn.style.display = index === 0 ? 'none' : 'block';
            }

            if (nextBtn && submitBtn) {
                if (index === questions.length - 1) {
                    nextBtn.style.display = 'none';
                    submitBtn.style.display = 'block';
                } else {
                    nextBtn.style.display = 'block';
                    submitBtn.style.display = 'none';
                }
            }

            // Update progress indicator if it exists
            const progressText = document.getElementById('progress-text');

            if (progressText) {
                progressText.textContent = `Question ${index + 1} of ${questions.length}`;
            }
        }
    }

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });
});
