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
    $sql = "SELECT tb.BookingId, tb.FromDate, tb.ToDate, tb.status, tp.PackageName, tp.PackagePrice 
            FROM tblbooking tb 
            JOIN tbltourpackages tp ON tb.PackageId = tp.PackageId 
            WHERE tb.UserEmail = :email 
            ORDER BY tb.BookingId DESC";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>My Bookings - Nepal Tourism</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
.bookings-container {
    max-width: 900px;
    margin: 26px auto;
    padding: 0 16px;
}
.booking-card {
    background: var(--panel);
    border: 1px solid rgba(255, 255, 255, 0.38);
    padding: 20px;
    border-radius: 14px;
    margin-bottom: 15px;
    box-shadow: 0 16px 42px rgba(2, 6, 23, 0.25);
}
.status-pending,
.status-confirmed,
.status-cancelled {
    padding: 5px 10px;
    border-radius: 999px;
    display: inline-block;
    font-size: 0.9rem;
    font-weight: 700;
}
.status-pending { background: #fff3cd; color: #8a6d3b; }
.status-confirmed { background: #d4edda; color: #155724; }
.status-cancelled { background: #f8d7da; color: #8b1d1d; }
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

<div class="bookings-container">
    <h2>My Tour Bookings</h2>
    
    <?php
    if($query->rowCount() > 0)
    {
        foreach($results as $result)
        {
            if($result->status == 0) {
                $status = '<span class="status-pending">Pending</span>';
            } elseif($result->status == 1) {
                $status = '<span class="status-confirmed">Confirmed</span>';
            } else {
                $status = '<span class="status-cancelled">Cancelled</span>';
            }
    ?>
        <div class="booking-card">
            <h3><i class="fa-solid fa-receipt"></i> #BK<?php echo htmlentities($result->BookingId); ?></h3>
            <p><strong>Package:</strong> <?php echo htmlentities($result->PackageName); ?></p>
            <p><strong>Price:</strong> <?php echo CURRENCY_SYMBOL . htmlentities($result->PackagePrice); ?></p>
            <p><strong>Travel Period:</strong> <?php echo htmlentities($result->FromDate); ?> to <?php echo htmlentities($result->ToDate); ?></p>
            <p><strong>Status:</strong> <?php echo $status; ?></p>
        </div>
    <?php
        }
    }
    else
    {
        echo "<p>You have no bookings yet. <a href='packages.php'>Browse packages</a></p>";
    }
    ?>
</div>

<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand"><i class="fa-solid fa-mountain-sun"></i> Nepal Tourism Management System</div>
            <small>Track booking confirmations and travel dates in one place.</small>
        </div>
        <div class="footer-links">
            <a href="index.php">Home</a>
            <a href="packages.php">Packages</a>
            <a href="profile.php">Profile</a>
        </div>
    </div>
</footer>
</body>
</html>
<?php
}
?>
