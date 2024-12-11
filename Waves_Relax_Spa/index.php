<?php
session_start(); // Start a session

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    header("Location: user_dashboard.php"); // Redirect to user dashboard if logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waves Relax Spa</title>

    <!-- Adding CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/MediaQuery.css">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/7a6c6b42a6.js" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <a href="#" class="logo">Waves Relax Spa</a>
        <div class="menuToggle"></div>
        <nav>
            <ul>
                <li><a href="login.php">Log in</a></li>
            </ul>
        </nav>
    </header>

    <section class="sectionFirst">
        <div class="frontPage">
            <div class="tagline">Find Your Oasis of Calm</div>
            <h2 class="heading">Waves Relax Spa</h2>
            <p class="para">Welcome to Waves Relax Spa, where tranquility meets luxury.<br> Immerse yourself in a serene oasis designed to rejuvenate<br> your mind, body, and soul!</p>
            <div class="btn">
                <a href="booking.php" id="book-now-main">Book Now</a>
                <a href="./services.php">View Services</a>
            </div>
        </div>

        <!-- Transparent Img -->
        <section class="transform-img">
            <img src="./img/background180.svg" alt="">
        </section>
    </section>

    <!-- Section Second -->
    <section class="sectionSecond">
        <div class="services-overview">
            <h2>Our Popular Services</h2>
            <p>Book your next appointment today and experience the difference.</p>
            <div class="carousel"></div>
            <button class="carousel-btn prev">❮</button>
            <button class="carousel-btn next">❯</button>
        </div>
    </section>

    <!-- Reviews -->
    <div class="testimonial-section">
        <h2>What Our Customers Say</h2>
        <div class="slider-container">
            <div class="testimonial-slider">
                <div class="testimonial-card">
                    <img src="./img/customer1.jpg" alt="Customer 1" class="customer-photo">
                    <div class="rating">
                        <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                    </div>
                    <p class="comment">"Absolutely fantastic service! Highly recommended."</p>
                </div>
                <div class="testimonial-card">
                    <img src="./img/customer2.jpg" alt="Customer 2" class="customer-photo">
                    <div class="rating">
                        <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                    </div>
                    <p class="comment">"Great quality and amazing attention to detail."</p>
                </div>
                <div class="testimonial-card">
                    <img src="./img/customer3.jpg" alt="Customer 3" class="customer-photo">
                    <div class="rating">
                        <span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span><span>⭐</span>
                    </div>
                    <p class="comment">"Very professional team! Will definitely come back."</p>
                </div>
            </div>
            <button class="prev-btn">❮</button>
            <button class="next-btn">❯</button>
        </div>
    </div>

    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Relax and Rejuvenate?</h2>
            <p>Create an account today or schedule your first session to experience ultimate relaxation!</p>
            <div class="cta-buttons">
                <a href="signup.php" class="cta-button">Create an Account</a>
                <a href="booking.php" class="cta-button">Schedule</a>
            </div>
        </div>
    </section>

    <!-- JS -->
    <script src="./js/script.js"></script>
</body>
</html>