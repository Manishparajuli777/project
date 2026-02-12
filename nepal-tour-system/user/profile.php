<?php
session_start();
include('includes/config.php');

if(!isset($_SESSION['login']))
{
    header("location:login.php");
}
else
{
    $email = $_SESSION['login'];
    $sql = "SELECT * FROM tblusers WHERE EmailId = :email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>My Profile - Nepal Tourism</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
.profile-container {
    background: var(--panel);
    padding: 30px;
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.38);
    max-width: 640px;
    margin: 26px auto;
    box-shadow: 0 16px 42px rgba(2, 6, 23, 0.25);
}
</style>
</head>
<body>
<nav class="navbar app-navbar">
    <a href="index.php" class="nav-brand"><i class="fa-solid fa-mountain-sun"></i> Nepal Tourism</a>
    <div class="nav-links">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="packages.php"><i class="fa-solid fa-box-open"></i> Packages</a>
        <a href="my-bookings.php"><i class="fa-solid fa-ticket"></i> My Bookings</a>
        <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</nav>

<div class="profile-container">
    <h2><i class="fa-solid fa-id-card"></i> My Profile</h2>
    
    <div class="form-group">
        <label><strong>Full Name:</strong></label>
        <p><?php echo htmlentities($user->FullName); ?></p>
    </div>
    
    <div class="form-group">
        <label><strong>Email:</strong></label>
        <p><?php echo htmlentities($user->EmailId); ?></p>
    </div>
    
    <div class="form-group">
        <label><strong>Mobile Number:</strong></label>
        <p><?php echo htmlentities($user->MobileNumber); ?></p>
    </div>
    
    <div class="form-group">
        <label><strong>Registration Date:</strong></label>
        <p><?php echo htmlentities($user->RegDate); ?></p>
    </div>
    
    <a href="my-bookings.php" class="btn btn-primary"><i class="fa-solid fa-ticket"></i> My Bookings</a>
    <a href="logout.php" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand"><i class="fa-solid fa-mountain-sun"></i> Nepal Tourism Management System</div>
            <small>Manage your account details and booking access.</small>
        </div>
        <div class="footer-links">
            <a href="index.php">Home</a>
            <a href="my-bookings.php">My Bookings</a>
            <a href="packages.php">Packages</a>
        </div>
    </div>
</footer>
</body>
</html>
<?php
}
?>
