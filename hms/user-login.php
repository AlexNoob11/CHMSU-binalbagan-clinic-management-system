<?php
// Include the database configuration
include_once('include/config.php');
session_start();

if(isset($_POST['submit'])) {
    // Get the form input values
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Retaining MD5 for matching legacy schema safely

    // Fixed SQL Injection vulnerability with Prepared Statements
    $stmt = $con->prepare("SELECT id, username, patient_type, email FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    
    if ($user_data) {
        // Set session variables if the user is found
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['patient_type'] = $user_data['patient_type'];
        $_SESSION['email'] = $user_data['email'];

        // Redirect to the dashboard after successful login
        header('Location: dashboard.php');
        exit();
    } else {
        echo "<script>alert('Invalid email or password. Please try again.');</script>";
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
    <title>User Login | CHMSU Clinic Management</title>

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
            max-width: 460px; /* Expanded slightly to balance text scaling layout perfectly */
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
            font-size: 2.5rem; /* Matched to Registration scale */
            margin-bottom: 5px;
            letter-spacing: -0.5px;
        }

        .text-muted {
            color: var(--text-muted) !important;
            font-size: 1.15rem; /* Increased size */
            margin-bottom: 35px;
        }

        /* Input Controls Refined styling */
        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .form-control {
            width: 100%;
            border-radius: 8px;
            padding: 12px 18px;
            font-size: 1.3rem; /* Increased size */
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
            color: var(--text-main);
            transition: var(--transition);
            height: 54px; /* Balanced operational height configuration */
        }

        .form-control:focus {
            border-color: var(--accent-color);
            background-color: var(--white);
            box-shadow: 0 0 0 3.5px rgba(14, 165, 233, 0.15);
            outline: none;
        }

        /* Interactive Action Buttons styling */
        .btn-login {
            border-radius: 8px;
            padding: 14px;
            font-size: 1.45rem; /* Increased size */
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
        .register-link {
            margin-top: 30px;
            font-size: 1.25rem; /* Increased size */
            color: var(--text-muted);
            border-top: 1px solid #f1f5f9;
            padding-top: 25px;
        }

        .register-link a {
            color: var(--accent-color);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }

        .register-link a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .back-home {
            margin-top: 20px;
            font-size: 1.1rem; /* Increased size */
        }
        
        .back-home a {
            color: var(--text-muted);
            text-decoration: none;
            transition: var(--transition);
        }

        .back-home a:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>

    <div class="login-box">
        <img src="include/CHMSUWeb.jpg" alt="CHMSU Logo" class="logo-img">
        <h2>CHMSU Clinic Portal</h2>
        <p class="text-muted">Please sign in to access your dashboard</p>

        <form method="post" action="" name="login-form">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email Address" required autocomplete="email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="current-password">
            </div>
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-login" id="submit" name="submit">
                    Sign In <i class="fa fa-sign-in"></i>
                </button>
            </div>
        </form>

        <div class="register-link">
            <p>Don't have an account? <a href="registration.php">Register here</a></p>
        </div>
        <div class="back-home">
            <a href="../index.php"><i class="fa fa-arrow-left"></i> Back to Homepage</a>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>