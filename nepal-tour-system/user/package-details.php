<?php
session_start();
include('includes/config.php');

if(!isset($_SESSION['login']))
{
    header("location:login.php");
}
else
{
    if(isset($_POST['book']))
    {
        $pkgid = intval($_POST['pkgid']);
        $fromdate = $_POST['fromdate'];
        $todate = $_POST['todate'];
        $comment = $_POST['comment'];
        $email = $_SESSION['login'];
        
        $sql = "INSERT INTO tblbooking (PackageId, UserEmail, FromDate, ToDate, Comment, status) 
                VALUES (:pkgid, :email, :fromdate, :todate, :comment, :status)";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':pkgid', $pkgid, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':fromdate', $fromdate, PDO::PARAM_STR);
        $query->bindParam(':todate', $todate, PDO::PARAM_STR);
        $query->bindParam(':comment', $comment, PDO::PARAM_STR);
        $query->bindParam(':status', $status = 0, PDO::PARAM_STR);
        $query->execute();
        
        $msg = "Booking request submitted successfully! We'll review it soon.";
    }

    $pkgid = intval($_GET['id']);
    $sql = "SELECT * FROM tbltourpackages WHERE PackageId = :pkgid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pkgid', $pkgid, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlentities($result->PackageName); ?> - <?php echo SITE_NAME; ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style>
.package-detail-section {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 24px;
}

.detail-grid {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
    margin-bottom: 40px;
}

.detail-main {
    background: var(--bg-primary);
    padding: 40px;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
}

.detail-sidebar {
    position: sticky;
    top: 90px;
    align-self: start;
}

.booking-card {
    background: var(--bg-primary);
    padding: 32px;
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
    border: 2px solid var(--primary);
}

.detail-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 32px;
}

.detail-type {
    color: var(--primary);
    font-size: 14px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 12px;
}

.detail-title {
    font-family: 'Poppins', sans-serif;
    font-size: 38px;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 20px;
    line-height: 1.2;
}

.detail-location {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    color: var(--text-secondary);
    margin-bottom: 32px;
}

.detail-location i {
    color: var(--primary);
    font-size: 20px;
}

.detail-section {
    margin-bottom: 32px;
}

.detail-section h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 24px;
    color: var(--text-primary);
    margin-bottom: 16px;
}

.detail-section p {
    color: var(--text-secondary);
    font-size: 16px;
    line-height: 1.8;
}

.features-list {
    list-style: none;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 16px;
}

.features-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px;
    background: var(--bg-secondary);
    border-radius: 10px;
    font-size: 15px;
}

.features-list li i {
    color: var(--primary);
    font-size: 18px;
}

.price-display {
    background: linear-gradient(135deg, #FFF7ED, #FFEDD5);
    padding: 24px;
    border-radius: 16px;
    text-align: center;
    margin-bottom: 24px;
    border: 2px solid var(--primary-light);
}

.price-label {
    font-size: 14px;
    color: var(--text-secondary);
    margin-bottom: 8px;
}

.price-value {
    font-family: 'Poppins', sans-serif;
    font-size: 48px;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
}

.price-per {
    font-size: 16px;
    color: var(--text-secondary);
    margin-top: 8px;
}

@media (max-width: 968px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-sidebar {
        position: static;
    }
}
</style>
</head>
<body>

<!-- Navigation -->
<nav class="main-nav">
    <div class="nav-container">
        <a href="index.php" class="nav-brand">
            <i class="fas fa-globe-americas"></i>
            <?php echo SITE_NAME; ?>
        </a>
        
        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>
        
        <div class="nav-links" id="navLinks">
            <a href="index.php" class="nav-link">
                <i class="fas fa-home"></i> Home
            </a>
            <a href="packages.php" class="nav-link">
                <i class="fas fa-suitcase-rolling"></i> Explore
            </a>
            <a href="my-bookings.php" class="nav-link">
                <i class="fas fa-calendar-check"></i> My Trips
            </a>
            <a href="profile.php" class="nav-link">
                <i class="fas fa-user-circle"></i> Profile
            </a>
            <a href="logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</nav>

<!-- Package Details -->
<div class="package-detail-section">
    <?php if(!empty($msg)) { ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $msg; ?>
        </div>
    <?php } ?>
    
    <div class="detail-grid">
        <div class="detail-main">
            <?php
                $filename = trim($result->PackageImage);
                $fsPath = __DIR__ . '/../photo/' . $filename;
                $urlPath = '../photo/' . $filename;
                if (empty($filename) || !file_exists($fsPath)) {
                    $urlPath = '../photo/1.jpg';
                }
            ?>
            <img src="<?php echo $urlPath; ?>" alt="<?php echo htmlentities($result->PackageName); ?>" class="detail-image">
            
            <div class="detail-type"><?php echo htmlentities($result->PackageType); ?></div>
            <h1 class="detail-title"><?php echo htmlentities($result->PackageName); ?></h1>
            <div class="detail-location">
                <i class="fas fa-map-marker-alt"></i>
                <?php echo htmlentities($result->PackageLocation); ?>
            </div>
            
            <div class="detail-section">
                <h3>About This Experience</h3>
                <p><?php echo nl2br(htmlentities($result->PackageDetails)); ?></p>
            </div>
            
            <div class="detail-section">
                <h3>What's Included</h3>
                <ul class="features-list">
                    <?php 
                    $features = explode(',', $result->PackageFetures);
                    foreach($features as $feature) {
                        if(trim($feature)) {
                    ?>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            <?php echo htmlentities(trim($feature)); ?>
                        </li>
                    <?php 
                        }
                    } 
                    ?>
                </ul>
            </div>
        </div>
        
        <div class="detail-sidebar">
            <div class="booking-card">
                <div class="price-display">
                    <div class="price-label">Starting from</div>
                    <div class="price-value"><?php echo CURRENCY_SYMBOL . number_format($result->PackagePrice, 2); ?></div>
                    <div class="price-per">per person</div>
                </div>
                
                <h3 style="margin-bottom: 20px; font-size: 20px;">Book This Package</h3>
                
                <form method="post">
                    <input type="hidden" name="pkgid" value="<?php echo $pkgid; ?>">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i> Start Date
                        </label>
                        <input type="date" name="fromdate" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-check"></i> End Date
                        </label>
                        <input type="date" name="todate" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-comment"></i> Special Requests
                        </label>
                        <textarea name="comment" class="form-control" rows="4" placeholder="Any special requirements or preferences?"></textarea>
                    </div>
                    
                    <button type="submit" name="book" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 16px; justify-content: center;">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="site-footer">
    <div class="footer-content">
        <div class="footer-grid">
            <div class="footer-section">
                <div class="footer-brand"><?php echo SITE_NAME; ?></div>
                <p class="footer-description">
                    <?php echo SITE_DESCRIPTION; ?>. Start your journey with us today.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="packages.php">All Packages</a></li>
                    <li><a href="packages.php?type=Adventure">Adventures</a></li>
                    <li><a href="packages.php?type=Cultural">Cultural Tours</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Support</h3>
                <ul class="footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-envelope"></i> info@yatra.com</li>
                    <li><i class="fas fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Travel Street, City</li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. | Crafted with <i class="fas fa-heart" style="color: var(--primary);"></i> for travelers</p>
        </div>
    </div>
</footer>

<script>
// Navbar scroll effect
window.addEventListener('scroll', function() {
    const nav = document.querySelector('.main-nav');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});

// Mobile menu toggle
function toggleMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.toggle('active');
}

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const nav = document.querySelector('.main-nav');
    const toggle = document.querySelector('.mobile-menu-toggle');
    const navLinks = document.getElementById('navLinks');
    
    if (!nav.contains(event.target) && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
    }
});

// Image zoom effect
const detailImage = document.querySelector('.detail-image');
if (detailImage) {
    detailImage.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
        this.style.transition = 'transform 0.5s ease';
    });
    detailImage.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });
}

// Animate booking card on scroll
const bookingCard = document.querySelector('.booking-card');
if (bookingCard) {
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.8s ease-out';
            }
        });
    }, { threshold: 0.1 });
    
    observer.observe(bookingCard);
}

// Loading animation
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    setTimeout(function() {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});

// Smooth scroll to booking form
const bookNowBtn = document.querySelector('button[name="book"]');
if (bookNowBtn) {
    bookNowBtn.addEventListener('click', function() {
        this.style.animation = 'pulse 0.5s ease';
        setTimeout(() => {
            this.style.animation = '';
        }, 500);
    });
}
</script>

</body>
</html>
<?php
}
?>
