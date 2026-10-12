<?php
session_start();
error_reporting(0);
include('include/config.php');

// Check if the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit();
}

// Get appointment ID from the URL query string
$appointment_id = $_GET['id'];

// Fetch the appointment details from the database
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
    $check_up_date = $_POST['check_up_date'];
    $check_up_time = $_POST['check_up_time'];

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
        <title>Set Schedule | Doctor</title>

        <!-- Include CSS files -->
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
    </head>
    <body>
        <div id="app">
            <?php include('include/sidebar.php'); ?>
            <div class="app-content">
                <?php include('include/header.php'); ?>
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <!-- Page Title -->
                        <section id="page-title">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Set Check-up Schedule | Doctor</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Doctor</span></li>
                                    <li><a href="appointment-history.php">Appointment History</a></li>
                                    <li class="active"><span>Set Check-up Schedule</span></li>
                                </ol>
                            </div>
                        </section>

                        <!-- Appointment Details and Schedule Form -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="over-title margin-bottom-15">Set Schedule for Check UP of <span class="text-bold"><?php echo $fullname; ?></span></h5>

                                    <form method="post" class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Full Name</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $fullname; ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Course/Year</label>
                                            <div class="col-sm-9">
                                                <p class="form-control-static"><?php echo $course_year; ?></p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Check-up Date</label>
                                            <div class="col-sm-9">
                                                <input type="date" name="check_up_date" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Check-up Time</label>
                                            <div class="col-sm-9">
                                                <input type="time" name="check_up_time" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button type="submit" class="btn btn-success">Set Schedule</button>
                                                <a href="appointment-history.php" class="btn btn-primary">Back to Appointment History</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <?php include('include/footer.php'); ?>
        </div>

        <!-- JavaScript and jQuery libraries -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>
