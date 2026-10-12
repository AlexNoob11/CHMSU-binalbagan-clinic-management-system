<?php
session_start();
error_reporting(0);
include('include/config.php');

// Ensure the admin is logged in
if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit();
}

// Handle search and AJAX request
$searchQuery = "";
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($con, $_POST['search']);
    $searchQuery = " WHERE fullname LIKE '%$searchTerm%' OR course_year LIKE '%$searchTerm%' OR contact_number LIKE '%$searchTerm%'";
}

$query = "SELECT * FROM appointments" . $searchQuery;
$result = mysqli_query($con, $query);

// If this is an AJAX request, return ONLY the table rows and exit immediately
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $doctor_id = $row['doctorId'];
            $doctor_query = "SELECT * FROM doctors WHERE id = '$doctor_id'";
            $doctor_result = mysqli_query($con, $doctor_query);
            $doctor = mysqli_fetch_array($doctor_result);
            
            echo '<tr>';
            echo '<td class="fw-medium text-dark">' . htmlspecialchars($row['fullname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['course_year']) . '</td>';
            echo '<td>' . htmlspecialchars($row['age']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sex']) . '</td>';
            echo '<td>' . htmlspecialchars($doctor['name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['check_up_date']) . '</td>';
            echo '<td>' . htmlspecialchars($row['check_up_time']) . '</td>';
            echo '<td><span class="badge bg-light text-dark border">' . htmlspecialchars($row['status']) . '</span></td>';
            echo '<td class="text-center"><a href="view-patient.php?id=' . $row['id'] . '" class="btn btn-custom btn-sm">PROCEED</a></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="9" class="text-center text-muted py-4">No appointments found.</td></tr>';
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Manage Appointments</title>
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
        .mainTitle {
            font-weight: 700;
            color: #1e293b;
        }
        .card-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding: 24px;
            margin-top: 20px;
            border: 1px solid #e2e8f0;
        }
        .search-wrapper {
            position: relative;
            margin-bottom: 25px;
            max-width: 400px;
        }
        .search-wrapper i {
            position: absolute;
            top: 14px;
            left: 16px;
            color: #94a3b8;
        }
        #search {
            width: 100%; 
            height: 45px;
            padding-left: 45px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        #search:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.15);
            outline: none;
        }
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-top: 10px;
        }
        .custom-table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
            border-top: none;
        }
        .custom-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 13px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }
        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }
        /* Custom Button Theme Color: #1e3a8a */
        .btn-custom {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: 600;
            font-size: 12px;
            letter-spacing: 0.5px;
            padding: 8px 18px;
            border-radius: 6px;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        .btn-custom:hover, .btn-custom:focus {
            background-color: #172554;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
            text-decoration: none;
        }
        .fw-medium { font-weight: 500; }
    </style>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Live Search Implementation
            $("#search").on("input", function() {
                var search = $(this).val();
                $.ajax({
                    url: '', 
                    method: 'POST',
                    data: {search: search},
                    success: function(response) {
                        $("#appointment-table").html(response);
                    }
                });
            });
        });
    </script>
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
                                <h1 class="mainTitle">Admin | Manage Appointments</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Manage Appointments</span></li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="card-container">
                                    <h5 class="over-title margin-bottom-15 fw-medium" style="color: #334155;">All Registered Appointments</h5>
                                    
                                    <div class="search-wrapper">
                                        <i class="fa fa-search"></i>
                                        <input type="text" id="search" class="form-control" placeholder="Search by name, course, or contact..." />
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table custom-table">
                                            <thead>
                                                <tr>
                                                    <th>Full Name</th>
                                                    <th>Course/Year</th>
                                                    <th>Age</th>
                                                    <th>Sex</th>
                                                    <th>Doctor Name</th>
                                                    <th>Check-up Date</th>
                                                    <th>Check-up Time</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="appointment-table">
                                                <?php
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $doctor_id = $row['doctorId'];
                                                        $doctor_query = "SELECT * FROM doctors WHERE id = '$doctor_id'";
                                                        $doctor_result = mysqli_query($con, $doctor_query);
                                                        $doctor = mysqli_fetch_array($doctor_result);
                                                        
                                                        echo '<tr>';
                                                        echo '<td class="fw-medium text-dark">' . htmlspecialchars($row['fullname']) . '</td>';
                                                        echo '<td>' . htmlspecialchars($row['course_year']) . '</td>';
                                                        echo '<td>' . htmlspecialchars($row['age']) . '</td>';
                                                        echo '<td>' . htmlspecialchars($row['sex']) . '</td>';
                                                        echo '<td>' . htmlspecialchars($doctor['name']) . '</td>';
                                                        echo '<td>' . htmlspecialchars($row['check_up_date']) . '</td>';
                                                        echo '<td>' . htmlspecialchars($row['check_up_time']) . '</td>';
                                                        echo '<td><span class="badge bg-light text-dark border">' . htmlspecialchars($row['status']) . '</span></td>';
                                                        echo '<td class="text-center"><a href="view-patient.php?id=' . $row['id'] . '" class="btn btn-custom btn-sm">PROCEED</a></td>';
                                                        echo '</tr>';
                                                    }
                                                } else {
                                                    echo '<tr><td colspan="9" class="text-center text-muted py-4">No appointments found.</td></tr>';
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

        <?php include('include/footer.php'); ?>
    </div>

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