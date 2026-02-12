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
    if(isset($_POST['submit']))
    {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];
        
        $sql = "SELECT Password FROM admin WHERE UserName = :username AND Password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        
        if($query->rowCount() > 0)
        {
            $sql = "UPDATE admin SET Password = :newpassword WHERE UserName = :username";
            $query = $dbh->prepare($sql);
            $query->bindParam(':username', $username, PDO::PARAM_STR);
            $query->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $query->execute();
            $msg = "Password changed successfully!";
        }
        else
        {
            $error = "Current password is incorrect!";
        }
    }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Change Password - Yatra Admin</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="form-container" style="max-width: 550px; margin: 60px auto; padding: 40px;">
    <div style="text-align: center; margin-bottom: 30px;">
        <i class="fas fa-key" style="font-size: 56px; background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 16px;"></i>
        <h2><i class="fas fa-lock"></i> Change Password</h2>
        <p style="color: #64748b; margin-top: 8px;">Update your admin account password</p>
    </div>
    
    <?php if($msg) { echo "<div class='success-msg'><i class='fas fa-check-circle'></i> $msg</div>"; } ?>
    <?php if($error) { echo "<div class='error-msg'><i class='fas fa-exclamation-circle'></i> $error</div>"; } ?>
    
    <form method="post">
        <div class="mb-4">
            <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-shield-alt"></i> Current Password:</label>
            <input type="password" name="password" class="form-control" placeholder="Enter current password" required autocomplete="current-password">
        </div>
        
        <div class="mb-4">
            <label class="form-label" style="font-weight: 600; color: #0f172a;"><i class="fas fa-key"></i> New Password:</label>
            <input type="password" name="newpassword" class="form-control" placeholder="Enter new password" required autocomplete="new-password" minlength="6">
            <small style="color: #64748b; display: block; margin-top: 6px;">Password must be at least 6 characters long</small>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" name="submit" class="btn btn-primary" style="flex: 1;"><i class="fas fa-check"></i> Change Password</button>
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
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

document.querySelectorAll('input').forEach((input, index) => {
    input.parentElement.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1}s both`;
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
