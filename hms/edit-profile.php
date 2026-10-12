<?php
// Start the session
session_start();

// Include the database configuration
include('include/config.php');

// Initialize $msg and error flags to avoid undefined variable notice
$msg = "";
$error = false;

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login-user.php");
    exit();
}

if(isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $patient_type = mysqli_real_escape_string($con, $_POST['patient_type']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Update the user's profile
    $sql = mysqli_query($con, "UPDATE users SET username='$username', patient_type='$patient_type', email='$email' WHERE id='" . $_SESSION['user_id'] . "'");
    if($sql) {
        $msg = "Your profile has been updated successfully.";
    } else {
        $msg = "There was an error updating your profile. Please try again.";
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Edit Profile</title>
    
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    
    <style>
        body { font-family: 'Raleway', sans-serif; background-color: #f8fafc; }
        .mainTitle { font-weight: 700; color: #1e293b; }
        
        /* Modern Profile Wrapper Styling */
        .profile-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 30px;
            border: 1px solid #e2e8f0;
            margin-top: 15px;
        }
        .profile-meta-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-top: 0;
            margin-bottom: 5px;
        }
        .profile-meta-date {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 20px;
        }
        
        /* Form Inputs Controls styling overrides */
        .form-group label {
            font-weight: 600;
            color: #475569;
            font-size: 13px;
            margin-bottom: 6px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            height: 40px;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.15);
        }
        .email-link {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            color: #1e3a8a;
            margin-top: 6px;
            transition: color 0.2s ease;
        }
        .email-link:hover {
            color: #172554;
            text-decoration: underline;
        }
        
        /* Navy Primary Button Styling Theme override (#1e3a8a) */
        .btn-custom-save {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 26px;
            border-radius: 6px;
            border: none;
            transition: all 0.2s ease-in-out;
            margin-top: 10px;
        }
        .btn-custom-save:hover {
            background-color: #172554 !important;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
        }
    </style>
</head>
<body>
    <div id="app">        
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <!-- start: PAGE TITLE -->
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">User | Edit Profile</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>User </span></li>
                                <li class="active"><span>Edit Profile</span></li>
                            </ol>
                        </div>
                    </section>
                    
                    <div class="container-fluid container-fullw p-0">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                
                                <!-- Diagnostic Notifications Wrapper Box -->
                                <?php if(!empty($msg)) { ?>
                                    <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?> alert-dismissible" role="alert" style="border-radius: 8px;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <i class="fa <?php echo $error ? 'fa-exclamation-circle' : 'fa-check-circle'; ?>"></i> <?php echo htmlentities($msg); ?>
                                    </div>
                                <?php } ?>

                                <div class="profile-card">
                                    <?php 
                                    // Fetch the user details from the database using the session user_id
                                    $sql = mysqli_query($con, "SELECT * FROM users WHERE id='" . $_SESSION['user_id'] . "'");
                                    while($data = mysqli_fetch_array($sql)) {
                                    ?>
                                    <h4 class="profile-meta-title"><?php echo htmlentities($data['username']); ?>'s Profile Account</h4>
                                    <div class="profile-meta-date"><i class="fa fa-calendar-o"></i> <b>Registration Date: </b><?php echo htmlentities($data['created_at']); ?></div>
                                    <hr style="border-top: 1px solid #f1f5f9; margin-bottom: 25px;" />
                                    
                                    <form role="form" name="edit" method="post">
                                        <div class="form-group">
                                            <label for="username">User Name</label>
                                            <input type="text" name="username" class="form-control" value="<?php echo htmlentities($data['username']); ?>" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="patient_type">Patient Type</label>
                                            <select name="patient_type" class="form-control" required="required">
                                                <option value="<?php echo htmlentities($data['patient_type']); ?>"><?php echo htmlentities($data['patient_type']); ?></option>
                                                <option value="staff">Staff</option>
                                                <option value="faculty">Faculty</option>
                                                <option value="student">Student</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">User Email Address</label>
                                            <input type="email" name="email" class="form-control" readonly="readonly" style="background-color: #f8fafc; cursor: not-allowed;" value="<?php echo htmlentities($data['email']); ?>">
                                            <a href="change-emaild.php" class="email-link"><i class="fa fa-pencil"></i> Update your email configuration</a>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" name="submit" class="btn btn-custom-save">Save Profile Updates</button>
                                        </div>
                                    </form>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
        });
    </script>
</body>
</html>