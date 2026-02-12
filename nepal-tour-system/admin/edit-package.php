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
    $pid = intval($_GET['pid']);
    
    if(isset($_POST['submit']))
    {
        $pname = $_POST['packagename'];
        $ptype = $_POST['packagetype'];
        $plocation = $_POST['packagelocation'];
        $pprice = $_POST['packageprice'];
        $pfeatures = $_POST['packagefeatures'];
        $pdetails = $_POST['packagedetails'];
        
        $sql = "UPDATE tbltourpackages SET PackageName=:pname, PackageType=:ptype, 
                PackageLocation=:plocation, PackagePrice=:pprice, PackageFeatures=:pfeatures, 
                PackageDetails=:pdetails WHERE PackageId=:pid";
        
        $query = $dbh->prepare($sql);
        $query->bindParam(':pname', $pname, PDO::PARAM_STR);
        $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
        $query->bindParam(':plocation', $plocation, PDO::PARAM_STR);
        $query->bindParam(':pprice', $pprice, PDO::PARAM_STR);
        $query->bindParam(':pfeatures', $pfeatures, PDO::PARAM_STR);
        $query->bindParam(':pdetails', $pdetails, PDO::PARAM_STR);
        $query->bindParam(':pid', $pid, PDO::PARAM_INT);
        $query->execute();
        
        $msg = "Package updated successfully!";
    }
    
    // Fetch package details
    $sql = "SELECT * FROM tbltourpackages WHERE PackageId=:pid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':pid', $pid, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Package - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="form-container" style="max-width: 800px; margin: 40px auto; padding: 40px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <i class="fas fa-edit" style="font-size: 56px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 16px;"></i>
        <h2><i class="fas fa-box"></i> Edit Tour Package</h2>
        <p style="color: #64748b; margin-top: 8px;">Update package information</p>
    </div>
    
    <?php if($msg) { echo "<div class='success-msg'><i class='fas fa-check-circle'></i> $msg</div>"; } ?>
    
    <form method="post">
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-tag"></i> Package Name:</label>
                <input type="text" name="packagename" class="form-control" value="<?php echo htmlentities($result->PackageName); ?>" required>
            </div>
            
            <div class="col-md-6 mb-4">
                <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-list"></i> Package Type:</label>
                <input type="text" name="packagetype" class="form-control" value="<?php echo htmlentities($result->PackageType); ?>" required>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-map-marker-alt"></i> Location:</label>
                <input type="text" name="packagelocation" class="form-control" value="<?php echo htmlentities($result->PackageLocation); ?>" required>
            </div>
            
            <div class="col-md-6 mb-4">
                <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-dollar-sign"></i> Price (<?php echo CURRENCY_SYMBOL; ?>):</label>
                <input type="number" name="packageprice" class="form-control" value="<?php echo htmlentities($result->PackagePrice); ?>" required>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-star"></i> Package Features:</label>
            <textarea name="packagefeatures" class="form-control" rows="4" required><?php echo htmlentities($result->PackageFeatures); ?></textarea>
            <small style="color: #64748b; display: block; margin-top: 6px;">Separate features with commas or new lines</small>
        </div>
        
        <div class="mb-4">
            <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-info-circle"></i> Package Details:</label>
            <textarea name="packagedetails" class="form-control" rows="6" required><?php echo htmlentities($result->PackageDetails); ?></textarea>
            <small style="color: #64748b; display: block; margin-top: 6px;">Provide detailed description of the package</small>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" name="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-save"></i> Update Package</button>
            <a href="manage-packages.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>

<script>
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease';
        document.body.style.opacity = '1';
    }, 100);
});

document.querySelectorAll('.form-group').forEach((group, index) => {
    group.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
});

document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', function(e) {
        this.style.animation = 'pulse 0.5s ease';
        setTimeout(() => this.style.animation = '', 500);
    });
});
</script>

</body>
</html>
<?php 
}
?>
