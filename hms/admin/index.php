<?php
session_start();
error_reporting(0);
include("include/config.php");

if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Secure database verification with Prepared Statements
    $stmt = $con->prepare("SELECT id FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->fetch_assoc();

    if($num) {
        $extra = "dashboard.php";
        $_SESSION['login'] = $username;
        $_SESSION['id'] = $num['id'];
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
        $extra = "index.php";
        $host  = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | CHMSU Clinic Management System</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">

    <style>
        /* Unified Theme Blueprint variables */
        :root {
            --primary-color: #1e3a8a;       /* Trustworthy Deep Blue */
            --primary-hover: #172554;      /* Darker Blue for interactive hover */
            --accent-color: #0ea5e9;       /* Medical Light Blue Accent */
            --bg-body: #f1f5f9;            /* Light uniform background tint */
            --text-main: #1e293b;          /* Dark Slate text */
            --text-muted: #64748b;         /* Secondary descriptive labels */
            --white: #ffffff;
            --shadow-lg: 0 10px 25px -5px rgba(30, 58, 138, 0.1), 0 8px 10px -6px rgba(30, 58, 138, 0.1);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top right, #cbd5e1, var(--bg-body));
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Modernized Elegant Login Card Container */
        .login-box {
            background: var(--white);
            padding: 50px 45px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            width: 90%;
            max-width: 460px; /* Balanced layout structure for larger typography scaling */
            text-align: center;
            border-top: 5px solid var(--primary-color);
            transition: var(--transition);
        }

        .logo-img {
            max-width: 115px;
            height: auto;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }

        .login-box h2 {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 2.5rem; /* Large Typography alignment rule */
            margin-bottom: 5px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .text-muted {
            color: var(--text-muted) !important;
            font-size: 1.15rem; 
            margin-bottom: 35px;
            font-weight: 500;
        }

        /* Input Controls Refined styling */
        .form-group {
            margin-bottom: 22px;
            text-align: left;
            position: relative;
        }

        .form-control {
            width: 100%;
            border-radius: 8px;
            padding: 12px 18px 12px 48px; /* Space for structural icons */
            font-size: 1.3rem; 
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: var(--text-main);
            transition: var(--transition);
            height: 54px; 
        }

        .form-control:focus {
            border-color: var(--accent-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3.5px rgba(14, 165, 233, 0.15);
            outline: none;
        }

        /* Styled Input Icons to balance high-scale layouts */
        .input-icon {
            position: relative;
            display: block;
            width: 100%;
        }

        .input-icon i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            color: var(--text-muted);
            transition: var(--transition);
            pointer-events: none;
        }

        .form-control:focus + i {
            color: var(--accent-color);
        }

        /* Interactive Action Buttons styling */
        .btn-login {
            border-radius: 8px;
            padding: 14px;
            font-size: 1.45rem; 
            font-weight: 500;
            background: var(--primary-color);
            color: var(--white);
            border: none;
            transition: var(--transition);
            width: 100%;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(30, 58, 138, 0.2);
            color: var(--white);
        }

        .btn-login i {
            font-size: 1.45rem;
        }

        /* Routing Utilities section links */
        .login-link {
            margin-top: 30px;
            font-size: 1.25rem; 
            color: var(--text-muted);
            border-top: 1px solid #f1f5f9;
            padding-top: 25px;
        }

        .login-link a {
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .login-link a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .error-message {
            background-color: #fef2f2;
            color: #dc2626;
            font-size: 1.15rem;
            padding: 12px 15px;
            border-radius: 8px;
            border-left: 4px solid #ef4444;
            margin-bottom: 25px;
            text-align: left;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <img src="include/CHMSUWeb.jpg" alt="CHMSU Logo" class="logo-img">
        <h2>Admin Login</h2>
        <p class="text-muted">Access the Admin Dashboard Platform</p>

        <form method="post" action="" name="login-form">
            <?php 
            if (!empty($_SESSION['errmsg'])) { 
                echo "<div class='error-message'><i class='fa fa-exclamation-circle'></i> ".$_SESSION['errmsg']."</div>"; 
                $_SESSION['errmsg'] = ""; 
            } 
            ?>
            
            <div class="form-group">
                <span class="input-icon">
                    <input type="text" class="form-control" name="username" placeholder="Enter your Username" required autocomplete="username">
                    <i class="fa fa-user"></i>
                </span>
            </div>
            
            <div class="form-group">
                <span class="input-icon">
                    <input type="password" class="form-control" name="password" placeholder="Enter your Password" required autocomplete="current-password">
                    <i class="fa fa-lock"></i>
                </span>
            </div>
            
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-login" name="submit">
                    Login <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </form>

        <div class="login-link">
            <p>Need help? <a href="forgot-password.php">Forgot your password?</a></p>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>