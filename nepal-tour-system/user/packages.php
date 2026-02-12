<?php
session_start();
include('includes/config.php');

// Get search and filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Build SQL query with search and filter
$sql = "SELECT * FROM tbltourpackages WHERE 1=1";
$params = array();

if(!empty($search)) {
    $sql .= " AND (PackageName LIKE :search OR PackageLocation LIKE :search OR PackageFetures LIKE :search OR PackageDetails LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

if(!empty($type)) {
    $sql .= " AND PackageType LIKE :type";
    $params[':type'] = '%' . $type . '%';
}

$sql .= " ORDER BY PackageId DESC";

$query = $dbh->prepare($sql);
foreach($params as $key => $value) {
    $query->bindValue($key, $value);
}
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$count = $query->rowCount();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Explore Packages - <?php echo SITE_NAME; ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="css/style.css" rel="stylesheet" type="text/css">
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
            <?php if(!empty($_SESSION['login'])) { ?>
                <a href="my-bookings.php" class="nav-link">
                    <i class="fas fa-calendar-check"></i> My Trips
                </a>
                <a href="profile.php" class="nav-link">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php } else { ?>
                <a href="login.php" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="signup.php" class="nav-link btn-primary">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            <?php } ?>
        </div>
    </div>
</nav>

<!-- Search Section -->
<section class="hero-section" style="padding: 60px 24px 50px;">
    <div class="hero-content">
        <h1 style="font-size: 42px;">Explore All Destinations</h1>
        <p>Find your perfect adventure from our curated collection of experiences</p>
        
        <!-- Search Bar -->
        <div class="search-container">
            <form action="packages.php" method="GET" class="search-wrapper">
                <input type="text" 
                       name="search" 
                       class="search-input" 
                       placeholder="Search destinations, experiences, or adventures..."
                       value="<?php echo htmlentities($search); ?>">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                    Search
                </button>
            </form>
            
            <div class="search-filters">
                <a href="packages.php" class="filter-chip <?php echo empty($type) ? 'active' : ''; ?>">
                    <i class="fas fa-th"></i> All
                </a>
                <a href="packages.php?type=Adventure" class="filter-chip <?php echo $type == 'Adventure' ? 'active' : ''; ?>">
                    <i class="fas fa-mountain"></i> Adventure
                </a>
                <a href="packages.php?type=Cultural" class="filter-chip <?php echo $type == 'Cultural' ? 'active' : ''; ?>">
                    <i class="fas fa-landmark"></i> Cultural
                </a>
                <a href="packages.php?type=Wildlife" class="filter-chip <?php echo $type == 'Wildlife' ? 'active' : ''; ?>">
                    <i class="fas fa-paw"></i> Wildlife
                </a>
                <a href="packages.php?type=Beach" class="filter-chip <?php echo $type == 'Beach' ? 'active' : ''; ?>">
                    <i class="fas fa-umbrella-beach"></i> Beach
                </a>
                <a href="packages.php?type=Trekking" class="filter-chip <?php echo $type == 'Trekking' ? 'active' : ''; ?>">
                    <i class="fas fa-hiking"></i> Trekking
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Packages Section -->
<div class="container">
    <div class="section-header">
        <?php if(!empty($search) || !empty($type)) { ?>
            <span class="section-tag">Search Results</span>
            <h2 class="section-title">
                <?php 
                if(!empty($search)) {
                    echo 'Results for "' . htmlentities($search) . '"';
                } else {
                    echo htmlentities($type) . ' Packages';
                }
                ?>
            </h2>
            <p class="section-subtitle">Found <?php echo $count; ?> package<?php echo $count != 1 ? 's' : ''; ?> matching your search</p>
        <?php } else { ?>
            <span class="section-tag">All Destinations</span>
            <h2 class="section-title">Browse All Packages</h2>
            <p class="section-subtitle">Discover amazing destinations and experiences worldwide</p>
        <?php } ?>
    </div>
    
    <div class="package-grid">
    <?php
    if($count > 0)
    {
        foreach($results as $result)
        {
            $filename = trim($result->PackageImage);
            $fsPath = __DIR__ . '/../photo/' . $filename;
            $urlPath = '../photo/' . $filename;
            if (empty($filename) || !file_exists($fsPath)) {
                $urlPath = '../photo/1.jpg';
            }
    ?>
        <div class="package-card">
            <div class="package-image-container">
                <img src="<?php echo $urlPath; ?>" alt="<?php echo htmlentities($result->PackageName); ?>" class="package-image">
                <div class="package-badge"><?php echo htmlentities($result->PackageType); ?></div>
            </div>
            <div class="package-content">
                <div class="package-type"><?php echo htmlentities($result->PackageType); ?></div>
                <h3 class="package-title"><?php echo htmlentities($result->PackageName); ?></h3>
                <div class="package-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php echo htmlentities($result->PackageLocation); ?>
                </div>
                <p class="package-description">
                    <?php echo htmlentities(substr($result->PackageFetures, 0, 100)); ?>...
                </p>
                <div class="package-footer">
                    <div class="package-price">
                        <span class="price-amount"><?php echo CURRENCY_SYMBOL . number_format($result->PackagePrice, 2); ?></span>
                        <span class="price-label">per person</span>
                    </div>
                    <a href="package-details.php?id=<?php echo $result->PackageId; ?>" class="package-cta">
                        View Details <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php
        }
    } else {
    ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px;">
            <i class="fas fa-search" style="font-size: 64px; color: var(--text-muted); margin-bottom: 20px; display: block;"></i>
            <h3 style="font-size: 24px; color: var(--text-primary); margin-bottom: 12px;">No packages found</h3>
            <p style="color: var(--text-secondary); margin-bottom: 24px;">
                <?php 
                if(!empty($search)) {
                    echo 'Try different keywords or browse all packages';
                } else {
                    echo 'No packages are available in this category at the moment';
                }
                ?>
            </p>
            <a href="packages.php" class="btn btn-primary">
                <i class="fas fa-th-large"></i> View All Packages
            </a>
        </div>
    <?php
    }
    ?>
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

// Animate package cards on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.package-card').forEach(card => {
    observer.observe(card);
});

// Loading animation
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    setTimeout(function() {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});
</script>

</body>
</html>
