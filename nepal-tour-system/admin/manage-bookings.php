<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(strlen($_SESSION['alogin']) == 0)
{
    header('location:index.php');
}
else
{
    // Handle booking confirmation/cancellation
    if(isset($_GET['confirm']))
    {
        $bid = intval($_GET['confirm']);
        $sql = "UPDATE tblbooking SET status = 1 WHERE BookingId = :bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Booking confirmed successfully!";
    }
    
    if(isset($_GET['cancel']))
    {
        $bid = intval($_GET['cancel']);
        $sql = "UPDATE tblbooking SET status = 2, CancelledBy = 'admin' WHERE BookingId = :bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Booking cancelled successfully!";
    }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Bookings - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="table-container">
    <div class="page-header">
        <h2><i class="fas fa-calendar-check"></i> Manage Bookings</h2>
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    
    <?php if($msg) { echo "<div class='success-msg'><i class='fas fa-check-circle'></i> $msg</div>"; } ?>
    
    <table class="table">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i></th>
                <th><i class="fas fa-ticket"></i> Booking ID</th>
                <th><i class="fas fa-user"></i> Customer</th>
                <th><i class="fas fa-map-marked-alt"></i> Package</th>
                <th><i class="fas fa-calendar-plus"></i> From</th>
                <th><i class="fas fa-calendar-minus"></i> To</th>
                <th><i class="fas fa-info-circle"></i> Status</th>
                <th><i class="fas fa-cog"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT tb.BookingId, tb.PackageId, tb.UserEmail, tb.FromDate, tb.ToDate, tb.status, 
                        tu.FullName, tp.PackageName 
                FROM tblbooking tb 
                JOIN tblusers tu ON tb.UserEmail = tu.EmailId 
                JOIN tbltourpackages tp ON tb.PackageId = tp.PackageId 
                ORDER BY tb.BookingId DESC";
        
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {
                if($result->status == 0) {
                    $status = '<span class="status-pending"><i class="fas fa-clock"></i> Pending</span>';
                } elseif($result->status == 1) {
                    $status = '<span class="status-confirmed"><i class="fas fa-check-circle"></i> Confirmed</span>';
                } else {
                    $status = '<span class="status-cancelled"><i class="fas fa-times-circle"></i> Cancelled</span>';
                }
        ?>
            <tr>
                <td><strong><?php echo htmlentities($cnt); ?></strong></td>
                <td><strong style="color: #3b82f6;">#BK<?php echo str_pad($result->BookingId, 4, '0', STR_PAD_LEFT); ?></strong></td>
                <td><i class="fas fa-user-circle" style="color: #8b5cf6; margin-right: 6px;"></i><?php echo htmlentities($result->FullName); ?></td>
                <td><strong><?php echo htmlentities($result->PackageName); ?></strong></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo date('M d, Y', strtotime($result->FromDate)); ?></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo date('M d, Y', strtotime($result->ToDate)); ?></td>
                <td><?php echo $status; ?></td>
                <td>
                    <?php if($result->status != 2) { ?>
                        <a href="manage-bookings.php?confirm=<?php echo $result->BookingId; ?>" class="btn btn-success btn-sm" title="Confirm Booking"><i class="fas fa-check"></i> Confirm</a>
                        <a href="manage-bookings.php?cancel=<?php echo $result->BookingId; ?>" class="btn btn-danger btn-sm" onclick="return confirm('⚠️ Are you sure you want to cancel this booking?');" title="Cancel Booking"><i class="fas fa-times"></i> Cancel</a>
                    <?php } else { ?>
                        <span style="color: #94a3b8; font-style: italic;">No actions</span>
                    <?php } ?>
                </td>
            </tr>
        <?php 
                $cnt = $cnt + 1;
            }
        }
        else
        {
            echo "<tr><td colspan='8' style='text-align: center; padding: 40px; color: #94a3b8;'><i class='fas fa-calendar-times' style='font-size: 48px; margin-bottom: 12px; display: block;'></i><strong>No bookings found</strong><br><small>Bookings will appear here once customers make reservations</small></td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script>
// Page load animation
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});

// Add ripple effect to buttons
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s ease-out;
            pointer-events: none;
        `;
        
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});
</script>

</body>
</html>
<?php 
}
?>
