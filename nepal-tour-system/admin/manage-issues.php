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
<title>Manage Issues - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="table-container">
    <div class="page-header">
        <h2><i class="fas fa-exclamation-triangle"></i> Manage Issues & Tickets</h2>
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th><i class="fas fa-ticket-alt"></i> Ticket ID</th>
                <th><i class="fas fa-user"></i> User Email</th>
                <th><i class="fas fa-exclamation-circle"></i> Issue</th>
                <th><i class="fas fa-comment-dots"></i> Description</th>
                <th><i class="fas fa-calendar"></i> Posted Date</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT * FROM tblissues ORDER BY id DESC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {
        ?>
            <tr>
                <td><strong style="color: #ef4444;">#TKT-<?php echo str_pad($result->id, 4, '0', STR_PAD_LEFT); ?></strong></td>
                <td><i class="fas fa-envelope" style="color: #3b82f6; margin-right: 6px;"></i><?php echo htmlentities($result->UserEmail); ?></td>
                <td><span style="background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block;"><i class="fas fa-bug"></i> <?php echo htmlentities($result->Issue); ?></span></td>
                <td style="max-width: 350px; color: #64748b;"><?php echo htmlspecialchars(substr($result->Description, 0, 60)) . (strlen($result->Description) > 60 ? "..." : ""); ?></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo date('M d, Y', strtotime($result->PostingDate)); ?></td>
            </tr>
        <?php 
            }
        }
        else
        {
            echo "<tr><td colspan='5' style='text-align: center; padding: 40px; color: #94a3b8;'><i class='fas fa-check-circle' style='font-size: 48px; margin-bottom: 12px; display: block; color: #10b981;'></i><strong>No issues reported</strong><br><small>Great! No customer issues at the moment</small></td></tr>";
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
