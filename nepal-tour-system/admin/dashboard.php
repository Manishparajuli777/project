<?php
session_start();
include('../includes/config.php');

if(strlen($_SESSION['alogin']) == 0)
{
    header('location:index.php');
}
else
{
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="dashboard-header">
        <h1><i class="fas fa-globe-americas"></i> <?php echo SITE_NAME; ?> Admin</h1>
        <p>Manage your travel platform and bookings</p>
    </div>
    
    <div class="navbar">
        <a href="manage-packages.php"><i class="fas fa-box"></i> Packages</a>
        <a href="manage-users.php"><i class="fas fa-users"></i> Users</a>
        <a href="manage-bookings.php"><i class="fas fa-calendar-check"></i> Bookings</a>
        <a href="manage-enquiries.php"><i class="fas fa-envelope"></i> Enquiries</a>
        <a href="manage-issues.php"><i class="fas fa-exclamation-triangle"></i> Issues</a>
        <a href="change-password.php"><i class="fas fa-key"></i> Password</a>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    
    <div class="stats-container">
        <div class="stat-card">
            <i class="fas fa-users"></i>
            <h3>
                <?php 
                $sql = "SELECT COUNT(*) as cnt FROM tblusers";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo htmlentities($result->cnt);
                ?>
            </h3>
            <p>Total Users</p>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-calendar-check"></i>
            <h3>
                <?php 
                $sql = "SELECT COUNT(*) as cnt FROM tblbooking";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo htmlentities($result->cnt);
                ?>
            </h3>
            <p>Total Bookings</p>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-envelope"></i>
            <h3>
                <?php 
                $sql = "SELECT COUNT(*) as cnt FROM tblenquiry";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo htmlentities($result->cnt);
                ?>
            </h3>
            <p>Enquiries</p>
        </div>
        
        <div class="stat-card">
            <i class="fas fa-box"></i>
            <h3>
                <?php 
                $sql = "SELECT COUNT(*) as cnt FROM tbltourpackages";
                $query = $dbh->prepare($sql);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_OBJ);
                echo htmlentities($result->cnt);
                ?>
            </h3>
            <p>Total Packages</p>
        </div>
    </div>
    
    <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%); padding: 48px; border-radius: 20px; text-align: center; box-shadow: var(--shadow-lg); border: 1px solid var(--border); animation: scaleIn 1s ease-out 0.8s both;">
        <i class="fas fa-user-shield" style="font-size: 64px; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 20px; display: block; animation: float 3s ease-in-out infinite;"></i>
        <h2 style="margin-bottom: 16px; font-family: 'Poppins', sans-serif; font-size: 32px; background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Welcome to Yatra Admin!</h2>
        <p style="font-size: 16px; color: var(--text-secondary); max-width: 600px; margin: 0 auto;">Manage your travel platform efficiently. Use the navigation above to handle packages, users, bookings, and customer enquiries.<br><strong style="color: var(--primary);">Your dashboard is ready!</strong></p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-" crossorigin="anonymous"></script>
<script>
// Animate stats on load
window.addEventListener('load', function() {
    const statNumbers = document.querySelectorAll('.stat-card h3');
    statNumbers.forEach(stat => {
        const finalNumber = parseInt(stat.textContent);
        let currentNumber = 0;
        const increment = Math.ceil(finalNumber / 50);
        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= finalNumber) {
                stat.textContent = finalNumber;
                clearInterval(timer);
            } else {
                stat.textContent = currentNumber;
            }
        }, 30);
    });
});

// Add hover glow effect to stat cards
document.querySelectorAll('.stat-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.boxShadow = '0 25px 50px rgba(15, 118, 110, 0.28)';
    });
    card.addEventListener('mouseleave', function() {
        this.style.boxShadow = '';
    });
});

// Navbar link animation
document.querySelectorAll('.navbar a').forEach(link => {
    link.addEventListener('click', function(e) {
        this.style.animation = 'pulse 0.5s ease';
        setTimeout(() => {
            this.style.animation = '';
        }, 500);
    });
});

// Add ripple effect to buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple-effect');
        
        this.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    });
});

// Page load animation
document.body.style.opacity = '0';
setTimeout(() => {
    document.body.style.transition = 'opacity 0.5s ease';
    document.body.style.opacity = '1';
}, 100);

// Add floating animation to icons
setInterval(() => {
    document.querySelectorAll('.stat-card i').forEach(icon => {
        icon.style.animation = 'float 3s ease-in-out infinite';
    });
}, 3000);
</script>

<style>
.ripple-effect {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple 0.6s ease-out;
    pointer-events: none;
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
</style>

</body>
</html>
<?php 
}
?>
