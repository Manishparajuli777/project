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
    // Get success/error messages from session
    $msg = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    unset($_SESSION['success']);
    unset($_SESSION['error']);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Packages - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="table-container">
    <div class="page-header">
        <h2><i class="fas fa-box"></i> Manage Tour Packages</h2>
        <div class="action-buttons">
            <a href="create-package.php" class="btn btn-success"><i class="fas fa-plus"></i> Add New Package</a>
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
    
    <?php if($msg) { echo "<div class='success-msg'><i class='fas fa-check-circle'></i> $msg</div>"; } ?>
    <?php if($error) { echo "<div class='error-msg'><i class='fas fa-exclamation-circle'></i> $error</div>"; } ?>
    
    <table class="table">
        <thead>
            <tr>
                <th><i class="fas fa-hashtag"></i></th>
                <th><i class="fas fa-box"></i> Package Name</th>
                <th><i class="fas fa-tag"></i> Type</th>
                <th><i class="fas fa-map-marker-alt"></i> Location</th>
                <th><i class="fas fa-dollar-sign"></i> Price</th>
                <th><i class="fas fa-calendar"></i> Created</th>
                <th><i class="fas fa-cog"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $sql = "SELECT * FROM tbltourpackages ORDER BY PackageId DESC";
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
                <td><strong><?php echo htmlentities($result->PackageName); ?></strong></td>
                <td><span style="background: linear-gradient(135deg, #e0f2fe, #bae6fd); padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; color: #0c4a6e;"><?php echo htmlentities($result->PackageType); ?></span></td>
                <td><i class="fas fa-location-dot" style="color: #ef4444; margin-right: 6px;"></i><?php echo htmlentities($result->PackageLocation); ?></td>
                <td><strong style="color: #059669; font-size: 15px;"><?php echo CURRENCY_SYMBOL . number_format($result->PackagePrice, 2); ?></strong></td>
                <td style="color: #64748b; font-size: 13px;"><?php echo date('M d, Y', strtotime($result->Creationdate)); ?></td>
                <td>
                    <a href="edit-package.php?pid=<?php echo htmlentities($result->PackageId); ?>" class="btn btn-info btn-sm" title="Edit Package"><i class="fas fa-edit"></i> Edit</a>
                    <a href="delete-package.php?pid=<?php echo htmlentities($result->PackageId); ?>" class="btn btn-danger btn-sm" onclick="return confirm('⚠️ Are you sure you want to delete this package?\n\nThis action cannot be undone!');" title="Delete Package"><i class="fas fa-trash"></i> Delete</a>
                </td>
            </tr>
        <?php 
                $cnt = $cnt + 1;
            }
        }
        else
        {
            echo "<tr><td colspan='7' style='text-align: center; padding: 40px; color: #94a3b8;'><i class='fas fa-inbox' style='font-size: 48px; margin-bottom: 12px; display: block;'></i><strong>No packages found</strong><br><small>Create your first package to get started!</small></td></tr>";
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
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(255, 255, 255, 0.6)';
        ripple.style.transform = 'scale(0)';
        ripple.style.animation = 'ripple 0.6s ease-out';
        ripple.style.pointerEvents = 'none';
        
        this.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);
    });
});

// Table row hover effect
document.querySelectorAll('.table tbody tr').forEach((row, index) => {
    row.style.animationDelay = (index * 0.05) + 's';
});
</script>

</body>
</html>
<?php 
}
?>
