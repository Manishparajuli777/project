<?php
session_start();
include('includes/config.php');

$error = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT EmailId FROM tblusers WHERE EmailId = :email AND Password = :password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();

    if ($query->rowCount() > 0) {
        $_SESSION['login'] = $email;
        header("location:index.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .auth-container {
            background: var(--bg-primary);
            max-width: 450px;
            width: 100%;
            padding: 48px 40px;
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .auth-logo {
            font-family: 'Poppins', sans-serif;
            font-size: 42px;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }
        
        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 15px;
        }
        
        .error-alert {
            background: linear-gradient(135deg, #FEF2F2, #FEE2E2);
            color: #991B1B;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #FCA5A5;
        }
        
        .auth-links {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }
        
        .auth-links a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-links a:hover {
            color: var(--primary-dark);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="fas fa-globe-americas"></i> <?php echo SITE_NAME; ?>
            </div>
            <p class="auth-subtitle">Sign in to manage your bookings</p>
        </div>

        <?php if ($error) { ?>
            <div class="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="post">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-envelope"></i> Email Address
                </label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="your@email.com" 
                       required 
                       autocomplete="email">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-lock"></i> Password
                </label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="Enter your password" 
                       required 
                       autocomplete="current-password">
            </div>

            <button type="submit" name="login" class="btn btn-primary" style="width: 100%; margin-top: 8px;">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="auth-links">
            <p style="color: var(--text-secondary); margin-bottom: 12px;">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </p>
            <a href="index.php">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>
