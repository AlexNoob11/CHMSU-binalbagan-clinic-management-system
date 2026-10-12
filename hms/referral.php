<?php
// Start the session
session_start();

// Include the database configuration
include("include/config.php");

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login-user.php");
    exit();
}

$alertMessage = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the logged-in user's ID from the session
    $user_id = $_SESSION['user_id'];
    
    // Get form data and sanitize to prevent SQL Injection
    $patient_name = mysqli_real_escape_string($con, $_POST['patient_name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $sex = mysqli_real_escape_string($con, $_POST['sex']);
    $chief_complaints = mysqli_real_escape_string($con, $_POST['chief_complaints']);
    $history = mysqli_real_escape_string($con, $_POST['history']);
    $evaluation = mysqli_real_escape_string($con, $_POST['evaluation']);

    // Insert data into the referrals table
    $query = "INSERT INTO referrals (UserID, PatientName, Age, Sex, ChiefComplaints, History, Evaluation) 
              VALUES ('$user_id', '$patient_name', '$age', '$sex', '$chief_complaints', '$history', '$evaluation')";
    
    if (mysqli_query($con, $query)) {
        $alertMessage = "<div class='alert alert-success' style='border-radius: 8px;'><i class='fa fa-check-circle'></i> Referral request added successfully!</div>";
    } else {
        $alertMessage = "<div class='alert alert-danger' style='border-radius: 8px;'><i class='fa fa-exclamation-triangle'></i> Error: " . mysqli_error($con) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical Referral Request | User Dashboard</title>

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
        body { font-family: 'Raleway', sans-serif; background-color: #f8f9fa; }
        .mainTitle { font-weight: 600; color: #2c3e50; }

        /* Clean Dashboard Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #edf2f9;
            margin-bottom: 30px;
        }

        .section-header-custom {
            font-size: 20px;
            font-weight: 600;
            color: #34495e;
            margin-top: 0;
            margin-bottom: 25px;
            border-bottom: 2px solid #f1f3f5;
            padding-bottom: 12px;
        }

        .form-group label {
            font-size: 12px;
            text-transform: uppercase;
            color: #7f8c8d;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #dcdde1;
            padding: 10px 14px;
            height: auto;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }

        .btn-submit-custom {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 6px;
            border: none;
            transition: background 0.2s ease;
        }

        .btn-submit-custom:hover {
            background-color: #111827;
            color: #ffffff;
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
                <section id="page-title" style="padding: 25px 0; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Medical Referral Request</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>User</span></li>
                            <li class="active"><span>Request Referral</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-sm-12">
                            
                            <?php if (!empty($alertMessage)) echo $alertMessage; ?>

                            <div class="form-card">
                                <h2 class="section-header-custom"><i class="fa fa-file-text-o" style="margin-right: 8px; color: #1e3a8a;"></i> Referral Request Form</h2>
                                
                                <form method="POST" action="">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patient_name">Patient Name</label>
                                                <input type="text" name="patient_name" id="patient_name" class="form-control" placeholder="Enter patient's full name" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="age">Age</label>
                                                <input type="number" name="age" id="age" class="form-control" placeholder="Age" required />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="sex">Sex</label>
                                                <select name="sex" id="sex" class="form-control" required>
                                                    <option value="">Select Sex</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="chief_complaints">Chief Complaints</label>
                                        <textarea name="chief_complaints" id="chief_complaints" class="form-control" rows="4" placeholder="Describe current clinical signs or complaints..." required></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="history">History</label>
                                        <textarea name="history" id="history" class="form-control" rows="4" placeholder="Detail past medical context or treatments..." required></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="evaluation">For Evaluation</label>
                                        <textarea name="evaluation" id="evaluation" class="form-control" rows="4" placeholder="Specify targeted assessment requirements..." required></textarea>
                                    </div>
                                    
                                    <div class="form-group" style="margin-top: 25px; margin-bottom: 0;">
                                        <button type="submit" class="btn-submit-custom">
                                            Submit Form <i class="fa fa-paper-plane" style="margin-left: 5px; font-size: 11px;"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                </div>
        </div>
        
        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
</body>
</html>