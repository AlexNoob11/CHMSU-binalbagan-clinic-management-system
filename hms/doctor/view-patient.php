<?php
session_start();
include('include/config.php'); // Include the database connection

// Check if the doctor is logged in, if not, redirect to login
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php"); // Redirect to doctor login page if not logged in
    exit();
}

// Fetch the doctor's details using the session
$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

// Fetch appointments specific to the logged-in doctor
$query = "SELECT * FROM appointments WHERE doctorId = '$doctor_id'"; // Fetch appointments for this doctor
$resultAppointments = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Medical Assessment History</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet">
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .panel-white {
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .panel-heading {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
        .panel-title {
            font-size: 24px;
        }
        .status-pending {
            background-color: #ffc107;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-completed {
            background-color: #28a745;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-canceled {
            background-color: #dc3545;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-rescheduled {
            background-color: #17a2b8;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div id="app">
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>
        <div class="main-content">
            <div class="wrap-content container">
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Doctor | Medical Assessment History</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Doctor</span></li>
                            <li class="active"><span>Medical Assessment History</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Medical Assessment History</h5>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Patient Name</th>
                                                <th>Course/Year</th>
                                                <th>Birthdate</th>
                                                <th>Age</th>
                                                <th>Sex</th>
                                                <th>Status</th>
                                                <th>Check-up Date</th>
                                                <th>Check-up Time</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            while ($row = mysqli_fetch_assoc($resultAppointments)) {
                                                // Status styling
                                                $statusClass = '';
                                                switch ($row['status']) {
                                                    case 'Completed':
                                                        $statusClass = 'status-completed';
                                                        break;
                                                    case 'Canceled':
                                                        $statusClass = 'status-canceled';
                                                        break;
                                                    case 'Rescheduled':
                                                        $statusClass = 'status-rescheduled';
                                                        break;
                                                    default:
                                                        $statusClass = 'status-pending';
                                                }

                                                echo "<tr>
                                                        <td>{$count}</td>
                                                        <td>" . htmlspecialchars($row['fullname']) . "</td>
                                                        <td>" . htmlspecialchars($row['course_year']) . "</td>
                                                        <td>" . htmlspecialchars($row['birthdate']) . "</td>
                                                        <td>" . htmlspecialchars($row['age']) . "</td>
                                                        <td>" . htmlspecialchars($row['sex']) . "</td>
                                                        <td><span class='status {$statusClass}'>" . htmlspecialchars($row['status']) . "</span></td>
                                                        <td>" . htmlspecialchars($row['check_up_date']) . "</td>
                                                        <td>" . htmlspecialchars($row['check_up_time']) . "</td>
                                                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                                                      </tr>";

                                                // Fetch the medical history for each appointment
                                                $appointmentId = $row['id']; // Get the current appointment's ID
                                                $medicalHistoryQuery = "SELECT * FROM medicalhistory WHERE appointmentId = '$appointmentId'";
                                                $medicalHistoryResult = mysqli_query($con, $medicalHistoryQuery);
                                                $medicalHistory = mysqli_fetch_assoc($medicalHistoryResult);

                                                if ($medicalHistory) {
                                                    echo "<tr><td colspan='10'>
                                                            <strong>Medical History for " . htmlspecialchars($row['fullname']) . ":</strong>
                                                            <table class='table table-bordered'>
                                                                <tr><th>Blood Pressure (BP)</th><td>" . htmlspecialchars($medicalHistory['BP']) . "</td></tr>
                                                                <tr><th>Pulse Rate (PR)</th><td>" . htmlspecialchars($medicalHistory['PR']) . "</td></tr>
                                                                <tr><th>Respiratory Rate (RR)</th><td>" . htmlspecialchars($medicalHistory['RR']) . "</td></tr>
                                                                <tr><th>Temperature</th><td>" . htmlspecialchars($medicalHistory['Temperature']) . "</td></tr>
                                                                <tr><th>General</th><td>" . htmlspecialchars($medicalHistory['General']) . "</td></tr>
                                                                <tr><th>Skin</th><td>" . htmlspecialchars($medicalHistory['Skin']) . "</td></tr>
                                                                <tr><th>EENT</th><td>" . htmlspecialchars($medicalHistory['EENT']) . "</td></tr>
                                                                <tr><th>Chest</th><td>" . htmlspecialchars($medicalHistory['Chest']) . "</td></tr>
                                                                <tr><th>Abdomen</th><td>" . htmlspecialchars($medicalHistory['Abdomen']) . "</td></tr>
                                                                <tr><th>Extremities</th><td>" . htmlspecialchars($medicalHistory['Extremities']) . "</td></tr>
                                                                <tr><th>Chest X-Ray</th><td>" . htmlspecialchars($medicalHistory['ChestXray']) . "</td></tr>
                                                                <tr><th>HBsAg</th><td>" . htmlspecialchars($medicalHistory['HBsAg']) . "</td></tr>
                                                                <tr><th>CBC</th><td>" . htmlspecialchars($medicalHistory['CBC']) . "</td></tr>
                                                                <tr><th>Urinalysis</th><td>" . htmlspecialchars($medicalHistory['Urinalysis']) . "</td></tr>
                                                                <tr><th>Stool Exam</th><td>" . htmlspecialchars($medicalHistory['StoolExam']) . "</td></tr>
                                                            </table>
                                                          </td></tr>";
                                                }

                                                $count++;
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
        </div>
    </div>
</body>
</html>
