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
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Users - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="table-container">
    <div class="page-header">
        <h2><i class="fas fa-users"></i> Manage Users</h2>
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i></th>
                <th><i class="fas fa-user"></i> Full Name</th>
                <th><i class="fas fa-envelope"></i> Email</th>
                <th><i class="fas fa-phone"></i> Mobile Number</th>
                <th><i class="fas fa-calendar-plus"></i> Registered</th>
                <th><i class="fas fa-clock"></i> Last Updated</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT * FROM tblusers ORDER BY id DESC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $cnt = 1;
        
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {
        ?>
            <tr>
                <td><strong><?php echo htmlentities($cnt); ?></strong></td>
                <td><i class="fas fa-user-circle" style="color: #8b5cf6; margin-right: 6px;"></i><strong><?php echo htmlentities($result->FullName); ?></strong></td>
                <td><i class="fas fa-at" style="color: #3b82f6; margin-right: 6px;"></i><?php echo htmlentities($result->EmailId); ?></td>
                <td><i class="fas fa-mobile-alt" style="color: #10b981; margin-right: 6px;"></i><?php echo htmlentities($result->MobileNumber); ?></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo date('M d, Y', strtotime($result->RegDate)); ?></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo $result->UpdationDate ? date('M d, Y', strtotime($result->UpdationDate)) : '-'; ?></td>
            </tr>
        <?php 
                $cnt = $cnt + 1;
            }
        }
        else
        {
            echo "<tr><td colspan='6' style='text-align: center; padding: 40px; color: #94a3b8;'><i class='fas fa-user-slash' style='font-size: 48px; margin-bottom: 12px; display: block;'></i><strong>No users found</strong><br><small>Registered users will appear here</small></td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<script>
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});

document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.cssText = `position:absolute;width:${size}px;height:${size}px;left:${x}px;top:${y}px;border-radius:50%;background:rgba(255,255,255,0.6);transform:scale(0);animation:ripple 0.6s ease-out;pointer-events:none;`;
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
