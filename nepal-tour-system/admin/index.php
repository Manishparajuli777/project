<?php
session_start();
include('../includes/config.php');

if(isset($_POST['login']))
{
    $uname = $_POST['username'];
    $password = md5($_POST['password']);
    
    $sql = "SELECT UserName, Password FROM admin WHERE UserName=:uname AND Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    if($query->rowCount() > 0)
    {
        $_SESSION['alogin'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } 
    else
    {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login - Yatra</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="login-container">
    <div style="text-align: center; margin-bottom: 32px;">
        <i class="fas fa-globe-americas" style="font-size: 72px; background: linear-gradient(135deg, #FF6B35, #004E89); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 20px; display: block; animation: float 3s ease-in-out infinite;"></i>
        <h2 style="margin-bottom: 12px; font-size: 42px; font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #FF6B35, #004E89); -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: fadeInDown 0.8s ease-out;">Yatra</h2>
        <p style="color: #64748b; font-size: 16px; font-weight: 600; animation: fadeInUp 0.8s ease-out 0.2s both;">Admin Portal</p>
        <div style="width: 60px; height: 4px; background: linear-gradient(90deg, #FF6B35, #004E89); margin: 16px auto; border-radius: 2px; animation: scaleIn 0.8s ease-out 0.4s both;"></div>
    </div>
    
    <form method="post" style="animation: fadeInUp 0.8s ease-out 0.6s both;">
        <div class="form-group">
            <label class="form-label"><i class="fas fa-user"></i> Username</label>
            <input type="text" name="username" class="form-control" placeholder="Enter your username" required autocomplete="username">
        </div>
        
        <div class="form-group">
            <label class="form-label"><i class="fas fa-lock"></i> Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required autocomplete="current-password">
        </div>
        
        <button type="submit" name="login" class="btn btn-primary" style="width: 100%; padding: 16px; font-size: 16px; margin-top: 12px;"><i class="fas fa-sign-in-alt"></i> Sign In to Dashboard</button>
    </form>
    
    <div style="text-align: center; margin-top: 28px; padding-top: 28px; border-top: 2px solid #e2e8f0; animation: fadeIn 0.8s ease-out 0.8s both;">
        <a href="../user/index.php" style="color: #FF6B35; text-decoration: none; font-weight: 600; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-arrow-left"></i> Back to Website
        </a>
    </div>
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

// Add focus animation to inputs
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.02)';
        this.parentElement.style.transition = 'transform 0.3s ease';
    });
    input.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });
});

// Button click animation
document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
    this.style.animation = 'pulse 0.5s ease';
    setTimeout(() => {
        this.style.animation = '';
    }, 500);
});
</script>
</body>
</html>
