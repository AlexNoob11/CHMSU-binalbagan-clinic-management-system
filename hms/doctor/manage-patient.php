<?php
session_start();
error_reporting(0);
include('include/config.php');

// Ensure the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header('location:logout.php');
    exit();
}

// Fetch all appointments for the logged-in doctor
$doctor_id = $_SESSION['doctor_id']; // Get the logged-in doctor's ID
$query = "SELECT * FROM appointments WHERE doctorId = '$doctor_id'";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Manage Patients</title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
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
        body { font-family: 'Raleway', sans-serif; background-color: #f4f6f9; }
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
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Doctor | Manage Patients</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li class="active"><span>Manage Patients</span></li>
                            </ol>
                        </div>
                    </section>

                    <!-- Table to display appointments -->
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">All Appointments</h5>

                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    echo '<table class="table table-bordered table-hover">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>Full Name</th>';
                                    echo '<th>Course/Year</th>';
                                    echo '<th>Age</th>';
                                    echo '<th>Sex</th>';
                                    echo '<th>Check-up Date</th>';
                                    echo '<th>Check-up Time</th>';
                                    echo '<th>Status</th>';
                                    echo '<th>Action</th>'; // Add an action column for the "Add Medical History" button
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                    
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<tr>';
                                        echo '<td>' . $row['fullname'] . '</td>';
                                        echo '<td>' . $row['course_year'] . '</td>';
                                        echo '<td>' . $row['age'] . '</td>';
                                        echo '<td>' . $row['sex'] . '</td>';
                                        echo '<td>' . $row['check_up_date'] . '</td>';
                                        echo '<td>' . $row['check_up_time'] . '</td>';
                                        echo '<td>' . $row['status'] . '</td>';

                                        // Add the button to view patient details
                                        echo '<td><a href="view-patient.php?id=' . $row['id'] . '" class="btn btn-primary">View</a></td>';
                                        echo '</tr>';
                                    }

                                    echo '</tbody>';
                                    echo '</table>';
                                } else {
                                    echo '<p>No appointments found.</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include('include/footer.php'); ?>
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
