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
    if(isset($_GET['read']))
    {
        $eid = intval($_GET['read']);
        $sql = "UPDATE tblenquiry SET Status = 1 WHERE id = :eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Enquiry marked as read!";
    }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Enquiries - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="table-container">
    <div class="page-header">
        <h2><i class="fas fa-envelope"></i> Manage Enquiries</h2>
        <div class="action-buttons">
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    
    <?php if($msg) { echo "<div class='success-msg'><i class='fas fa-check-circle'></i> $msg</div>"; } ?>
    
    <table class="table">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i> ID</th>
                <th><i class="fas fa-user"></i> Name</th>
                <th><i class="fas fa-at"></i> Email</th>
                <th><i class="fas fa-tag"></i> Subject</th>
                <th><i class="fas fa-comment"></i> Message</th>
                <th><i class="fas fa-calendar"></i> Date</th>
                <th><i class="fas fa-info-circle"></i> Status</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT * FROM tblenquiry ORDER BY id DESC";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        
        if($query->rowCount() > 0)
        {
            foreach($results as $result)
            {
        ?>
            <tr style="<?php echo $result->Status == 0 ? 'background: #fffbeb;' : ''; ?>">
                <td><strong style="color: #3b82f6;">#ENQ<?php echo str_pad($result->id, 3, '0', STR_PAD_LEFT); ?></strong></td>
                <td><i class="fas fa-user-circle" style="color: #8b5cf6; margin-right: 6px;"></i><strong><?php echo htmlentities($result->FullName); ?></strong></td>
                <td><i class="fas fa-envelope" style="color: #3b82f6; margin-right: 6px;"></i><?php echo htmlentities($result->EmailId); ?></td>
                <td><strong><?php echo htmlentities($result->Subject); ?></strong></td>
                <td style="max-width: 300px; color: #64748b;"><?php echo htmlspecialchars(substr($result->Description, 0, 60)) . (strlen($result->Description) > 60 ? "..." : ""); ?></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo date('M d, Y', strtotime($result->PostingDate)); ?></td>
                <td>
                    <?php if($result->Status == 0) { ?>
                        <a href="manage-enquiries.php?read=<?php echo $result->id; ?>" class="btn btn-warning btn-sm" title="Mark as Read"><i class="fas fa-eye"></i> Mark Read</a>
                    <?php } else { ?>
                        <span style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block;"><i class="fas fa-check-double"></i> Read</span>
                    <?php } ?>
                </td>
            </tr>
        <?php 
            }
        }
        else
        {
            echo "<tr><td colspan='7' style='text-align: center; padding: 40px; color: #94a3b8;'><i class='fas fa-inbox' style='font-size: 48px; margin-bottom: 12px; display: block;'></i><strong>No enquiries found</strong><br><small>Customer enquiries will appear here</small></td></tr>";
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
