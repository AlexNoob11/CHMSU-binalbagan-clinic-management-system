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
        <title>View Appointment | Doctor</title>

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
                                    <h1 class="mainTitle">View Appointment | Doctor</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Doctor</span></li>
                                    <li><a href="appointment-history.php">Appointment History</a></li>
                                    <li class="active"><span>View Appointment</span></li>
                                </ol>
                            </div>
                        </section>

                        <!-- Appointment Details -->
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="over-title margin-bottom-15">Appointment Details for <span class="text-bold"><?php echo $fullname; ?></span></h5>

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Full Name</th>
                                            <td><?php echo $fullname; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Course/Year</th>
                                            <td><?php echo $course_year; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Birthdate</th>
                                            <td><?php echo $birthdate; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td><?php echo $age; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Sex</th>
                                            <td><?php echo $sex; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Civil Status</th>
                                            <td><?php echo $civil_status; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Weight</th>
                                            <td><?php echo $weight; ?> kg</td>
                                        </tr>
                                        <tr>
                                            <th>Blood Type</th>
                                            <td><?php echo $bloodtype; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Religion</th>
                                            <td><?php echo $religion; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td><?php echo $address; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Contact Number</th>
                                            <td><?php echo $contact_number; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Father's Name</th>
                                            <td><?php echo $father_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Father's Occupation</th>
                                            <td><?php echo $father_occupation; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mother's Name</th>
                                            <td><?php echo $mother_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mother's Occupation</th>
                                            <td><?php echo $mother_occupation; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Number of Children</th>
                                            <td><?php echo $num_children; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Emergency Contact Name</th>
                                            <td><?php echo $emergency_contact_name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Emergency Contact Relation</th>
                                            <td><?php echo $emergency_contact_relation; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Emergency Contact Number</th>
                                            <td><?php echo $emergency_contact_number; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Appointment Date</th>
                                            <td><?php echo $created_at; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><?php echo $status; ?></td>
                                        </tr>
                                    </table>

                                    <a href="appointment-history.php" class="btn btn-primary">Back to Appointment History</a>
                                    <a href="set-schedule.php?id=<?php echo $appointment_id; ?>" class="btn btn-success">Set a Schedule for Check-up</a>
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
