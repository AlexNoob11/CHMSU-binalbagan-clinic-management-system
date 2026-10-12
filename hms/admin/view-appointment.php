<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login(); // Ensure the admin is logged in

// Get the appointment ID from the URL and sanitize
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
    $created_at = $row['created_at'];
    $status = $row['status'];
} else {
    echo "No appointment found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>View Appointment | ADMIN</title>
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
            .profile-card {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                padding: 24px;
                border: 1px solid #e2e8f0;
                margin-bottom: 25px;
            }
            .section-heading {
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #1e3a8a;
                font-weight: 700;
                border-bottom: 2px solid #f1f5f9;
                padding-bottom: 6px;
                margin-top: 20px;
                margin-bottom: 15px;
            }
            .info-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px 30px;
            }
            @media(max-width: 767px) { .info-grid { grid-template-columns: 1fr; } }
            .info-item {
                display: flex;
                border-bottom: 1px solid #f8fafc;
                padding-bottom: 8px;
            }
            .info-label {
                width: 40%;
                font-weight: 600;
                color: #475569;
                font-size: 13px;
            }
            .info-value {
                width: 60%;
                color: #1e293b;
                font-size: 13px;
            }
            .status-badge {
                display: inline-block;
                padding: 4px 12px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 12px;
                background-color: #e0f2fe;
                color: #0369a1;
            }
            /* Theme Color: #1e3a8a mapping */
            .btn-custom-primary {
                background-color: #1e3a8a !important;
                color: #ffffff !important;
                font-weight: 600;
                border-radius: 6px;
                padding: 10px 20px;
                border: none;
                transition: all 0.2s ease-in-out;
            }
            .btn-custom-primary:hover {
                background-color: #172554 !important;
                box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
                text-decoration: none;
            }
            .btn-custom-secondary {
                background-color: #f1f5f9 !important;
                color: #475569 !important;
                font-weight: 600;
                border-radius: 6px;
                padding: 10px 20px;
                border: 1px solid #cbd5e1 !important;
                transition: all 0.2s ease-in-out;
            }
            .btn-custom-secondary:hover {
                background-color: #e2e8f0 !important;
                color: #334155 !important;
                text-decoration: none;
            }
            .action-button-group {
                display: flex;
                gap: 12px;
                justify-content: center;
                margin-top: 30px;
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
                                    <h1 class="mainTitle">View Appointment | ADMIN</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Doctor</span></li>
                                    <li><a href="appointment-history.php">Appointment History</a></li>
                                    <li class="active"><span>View Appointment</span></li>
                                </ol>
                            </div>
                        </section>

                        <div class="container-fluid container-fullw">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="profile-card">
                                        <h4 class="margin-bottom-20" style="color:#1e293b; font-weight: 600;">
                                            Appointment Record for: <span style="color: #1e3a8a;"><?php echo htmlspecialchars($fullname); ?></span>
                                        </h4>
                                        
                                        <div class="section-heading">Primary Patient Info</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Full Name</div><div class="info-value"><?php echo htmlspecialchars($fullname); ?></div></div>
                                            <div class="info-item"><div class="info-label">Course / Year</div><div class="info-value"><?php echo htmlspecialchars($course_year); ?></div></div>
                                            <div class="info-item"><div class="info-label">Birthdate</div><div class="info-value"><?php echo htmlspecialchars($birthdate); ?></div></div>
                                            <div class="info-item"><div class="info-label">Age / Sex</div><div class="info-value"><?php echo htmlspecialchars($age); ?> Yrs / <?php echo htmlspecialchars($sex); ?></div></div>
                                            <div class="info-item"><div class="info-label">Weight</div><div class="info-value"><?php echo htmlspecialchars($weight); ?> kg</div></div>
                                            <div class="info-item"><div class="info-label">Blood Type</div><div class="info-value"><span class="badge badge-inverse"><?php echo htmlspecialchars($bloodtype); ?></span></div></div>
                                            <div class="info-item"><div class="info-label">Civil Status</div><div class="info-value"><?php echo htmlspecialchars($civil_status); ?></div></div>
                                            <div class="info-item"><div class="info-label">Religion</div><div class="info-value"><?php echo htmlspecialchars($religion); ?></div></div>
                                        </div>

                                        <div class="section-heading">Contact & Demographics</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Contact Number</div><div class="info-value"><?php echo htmlspecialchars($contact_number); ?></div></div>
                                            <div class="info-item"><div class="info-label">Address</div><div class="info-value"><?php echo htmlspecialchars($address); ?></div></div>
                                            <div class="info-item"><div class="info-label">Father's Name</div><div class="info-value"><?php echo htmlspecialchars($father_name); ?> (<?php echo htmlspecialchars($father_occupation); ?>)</div></div>
                                            <div class="info-item"><div class="info-label">Mother's Name</div><div class="info-value"><?php echo htmlspecialchars($mother_name); ?> (<?php echo htmlspecialchars($mother_occupation); ?>)</div></div>
                                            <div class="info-item"><div class="info-label">No. of Children</div><div class="info-value"><?php echo htmlspecialchars($num_children); ?></div></div>
                                        </div>

                                        <div class="section-heading">Emergency Records</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Contact Name</div><div class="info-value"><?php echo htmlspecialchars($emergency_contact_name); ?></div></div>
                                            <div class="info-item"><div class="info-label">Relationship</div><div class="info-value"><?php echo htmlspecialchars($emergency_contact_relation); ?></div></div>
                                            <div class="info-item"><div class="info-label">Emergency Phone</div><div class="info-value"><?php echo htmlspecialchars($emergency_contact_number); ?></div></div>
                                        </div>

                                        <div class="section-heading">Log Specifications</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Appointment Date</div><div class="info-value"><?php echo htmlspecialchars($created_at); ?></div></div>
                                            <div class="info-item"><div class="info-label">Status</div><div class="info-value"><span class="status-badge"><?php echo htmlspecialchars($status); ?></span></div></div>
                                        </div>

                                        <div class="action-button-group">
                                            <a href="appointment-history.php" class="btn btn-custom-secondary">
                                                <i class="fa fa-arrow-left"></i> Back to History
                                            </a>
                                            <a href="set-schedule.php?id=<?php echo $appointment_id; ?>" class="btn btn-custom-primary">
                                                <i class="fa fa-calendar-check-o"></i> Set Schedule for Check-up
                                            </a>
                                        </div>
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