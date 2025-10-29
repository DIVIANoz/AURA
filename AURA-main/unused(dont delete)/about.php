<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - AURA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="../assets/img/Logo-W.png" alt="AURA Logo" class="logo-img" id="siteLogo">
            </div>
            <nav>
                <ul class="center-nav">
                    <li><a href="cart.php">CART</a></li>
                    <li><a href="../index.php">HOME</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                </ul>

                <ul class="right-actions">
                    <li><a href="login.php">LOG IN</a></li>
                    <li><a href="signup.php" class="signup-btn">SIGN UP</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <main>
            <section class="about-section">
                <h1>About AURA</h1>
                <p>Welcome to AURA, where we believe that every scent tells a unique story. Our passion for perfumery combines artisanal craftsmanship with modern sophistication to create fragrances that capture moments, memories, and emotions.</p>
                
                <div class="about-content">
                    <h2>Our Story</h2>
                    <p>Founded with a vision to create personal and timeless fragrances, AURA has been dedicated to the art of perfumery. We carefully select the finest ingredients and combine them to create scents that resonate with individuality and elegance.</p>
                    
                    <h2>Our Philosophy</h2>
                    <p>At AURA, we believe that perfume is more than just a fragrance – it's a form of self-expression. Each of our creations is designed to enhance your personal story, adding subtle sophistication to your everyday moments.</p>
                </div>
            </section>
        </main>
    </div>
    
    <footer>
        <div class="footer-content">
            <div class="social-links">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="copyright">© <?php echo date('Y'); ?> AURA. All rights reserved.</div>
            <div style="width: 100px;"></div>
        </div>
    </footer>
</body>
</html>