<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login(); // Ensure the admin is logged in

// Get the appointment ID from the URL
$appointment_id = mysqli_real_escape_string($con, $_GET['id']);
$query = "SELECT * FROM appointments WHERE id = '$appointment_id'";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_array($result)) {
    // Appointment details
    $fullname = $row['fullname'];
    $course_year = $row['course_year'];
    $birthdate = $row['birthdate'];
    $age = $row['age'];
    $sex = $row['sex'];
    $civil_status = $row['civil_status'];
    $weight = $row['weight'];
    $bloodtype = $row['bloodtype'];
    $religion = $row['religion'];
    $address = $row['address'];
    $contact_number = $row['contact_number'];
    $father_name = $row['father_name'];
    $father_occupation = $row['father_occupation'];
    $mother_name = $row['mother_name'];
    $mother_occupation = $row['mother_occupation'];
    $num_children = $row['num_children'];
    $emergency_contact_name = $row['emergency_contact_name'];
    $emergency_contact_relation = $row['emergency_contact_relation'];
    $emergency_contact_number = $row['emergency_contact_number'];
    $status = $row['status'];
} else {
    echo "No appointment found.";
    exit();
}

// Process the form if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the date and time of the check-up
    $check_up_date = mysqli_real_escape_string($con, $_POST['check_up_date']);
    $check_up_time = mysqli_real_escape_string($con, $_POST['check_up_time']);

    // Update the appointment with the scheduled date, time, and status
    $update_query = "UPDATE appointments 
                     SET status = 'Completed', check_up_date = '$check_up_date', check_up_time = '$check_up_time' 
                     WHERE id = '$appointment_id'";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        echo "<script>alert('Check-up schedule has been set successfully.'); window.location='appointment-history.php';</script>";
    } else {
        echo "<script>alert('Error setting check-up schedule.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Set Schedule | ADMIN/NURSE</title>

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
            body { 
                font-family: 'Raleway', sans-serif; 
                background-color: #f8fafc; 
            }
            .mainTitle { font-weight: 700; color: #1e293b; }
            .card-container {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                padding: 30px;
                margin-top: 20px;
                border: 1px solid #e2e8f0;
                max-width: 800px;
            }
            .patient-header {
                border-bottom: 2px solid #f1f5f9;
                padding-bottom: 15px;
                margin-bottom: 25px;
            }
            .patient-header h4 {
                font-weight: 600;
                color: #334155;
                margin: 0 0 5px 0;
            }
            .control-label {
                font-weight: 600;
                color: #475569;
                font-size: 13px;
                text-align: left !important;
            }
            .form-control-static {
                color: #1e293b;
                font-size: 14px;
                font-weight: 500;
                padding-top: 7px;
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
            /* Theme Custom Color Overrides (#1e3a8a) */
            .btn-custom-submit {
                background-color: #1e3a8a !important;
                color: #ffffff !important;
                font-weight: 600;
                font-size: 13px;
                padding: 10px 24px;
                border-radius: 6px;
                border: none;
                transition: all 0.2s ease-in-out;
            }
            .btn-custom-submit:hover {
                background-color: #172554 !important;
                box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
            }
            .btn-custom-back {
                background-color: transparent !important;
                color: #475569 !important;
                border: 1px solid #cbd5e1 !important;
                font-weight: 600;
                font-size: 13px;
                padding: 10px 20px;
                border-radius: 6px;
                margin-left: 8px;
                transition: all 0.2s ease-in-out;
            }
            .btn-custom-back:hover {
                background-color: #f8fafc !important;
                color: #1e293b !important;
                border-color: #94a3b8 !important;
                text-decoration: none;
            }
            .form-actions-wrapper {
                margin-top: 30px;
                border-top: 1px solid #f1f5f9;
                padding-top: 20px;
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
                        <section id="page-title" class="padding-top-15 padding-bottom-15">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Set Check-up Schedule | Admin/Nurse</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Doctor</span></li>
                                    <li><a href="appointment-history.php">Appointment History</a></li>
                                    <li class="active"><span>Set Check-up Schedule</span></li>
                                </ol>
                            </div>
                        </section>

                        <div class="container-fluid container-fullw">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="card-container">
                                        <div class="patient-header">
                                            <h4>Configure Check-up Timing</h4>
                                            <small class="text-muted">Assigning medical validation dates for baseline records</small>
                                        </div>

                                        <form method="post" class="form-horizontal">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Full Name</label>
                                                <div class="col-sm-9">
                                                    <p class="form-control-static"><?php echo htmlspecialchars($fullname); ?></p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Course / Year</label>
                                                <div class="col-sm-9">
                                                    <p class="form-control-static"><?php echo htmlspecialchars($course_year); ?></p>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group margin-top-20">
                                                <label class="col-sm-3 control-label">Check-up Date</label>
                                                <div class="col-sm-6">
                                                    <input type="date" name="check_up_date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Check-up Time</label>
                                                <div class="col-sm-6">
                                                    <input type="time" name="check_up_time" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="form-group form-actions-wrapper">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button type="submit" class="btn btn-custom-submit">Set Schedule</button>
                                                    <a href="appointment-history.php" class="btn btn-custom-back">Back to History</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('include/footer.php'); ?>
        </div>
</div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>