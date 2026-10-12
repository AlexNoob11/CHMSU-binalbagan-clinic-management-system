<?php
session_start();
error_reporting(0);
include('include/config.php');

// Check if the user is logged in as a doctor
if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit;
}

// Fetch doctor details from the database
$doctor_id = $_SESSION['doctor_id'];
$sql = "SELECT doctorName FROM doctors WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $doctor_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $doctorName);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch feedback data from the database
$feedback_sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$feedback_result = mysqli_query($con, $feedback_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Feedback</title>
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
        .feedback-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .feedback-table th, .feedback-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .feedback-table th {
            background-color: #f4f7fc;
        }
        .feedback-table td {
            background-color: #ffffff;
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
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Doctor | Patient Feedback</h1>
                                <p>Welcome, <?php echo htmlspecialchars($doctorName); ?>!</p>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li class="active"><span>Feedback</span></li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Patient Feedback</h2>
                                <table class="feedback-table">
                                    <thead>
                                        <tr>
                                            <th>Feedback ID</th>
                                            <th>User ID</th>
                                            <th>Rating</th>
                                            <th>Comments</th>
                                            <th>Overall Experience</th>
                                            <th>Ease of Use</th>
                                            <th>Service Quality</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($feedback_result) > 0) {
                                            while ($row = mysqli_fetch_assoc($feedback_result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['feedback_id']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['userId']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['rating']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['comments']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['overall_experience']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['ease_of_use']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['service_quality']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No feedback available</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
            FormElements.init();
        });
    </script>
</body>
</html>
