<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Initialize default values
$month = date('m');
$year = date('Y');
$start_date = '';
$end_date = '';
$course_year = '';

// Check if the user has selected filters
if (isset($_POST['month'])) {
    $month = $_POST['month'];
}
if (isset($_POST['year'])) {
    $year = $_POST['year'];
}
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
}
if (isset($_POST['course_year'])) {
    $course_year = $_POST['course_year'];
}

// Prepare the query with a JOIN to fetch doctor names along with appointments
$query = "SELECT appointments.*, doctors.doctorName 
          FROM appointments 
          LEFT JOIN doctors ON appointments.doctorId = doctors.id";

$conditions = [];

// Filter by date range if provided
if (!empty($start_date) && !empty($end_date)) {
    $conditions[] = "appointments.check_up_date BETWEEN '$start_date' AND '$end_date'";
}

// Filter by course year if selected
if (!empty($course_year)) {
    $conditions[] = "appointments.school_year = '$course_year'";
}

// Apply conditions to query
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Clinic Report | Admin</title>
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
        
        /* Modernized Form Styling Dashboard Control */
        .filter-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }
        .filter-card .form-group {
            margin-right: 15px;
            margin-bottom: 10px;
        }
        .filter-card label {
            font-weight: 600;
            color: #475569;
            font-size: 13px;
            margin-right: 8px;
        }
        .filter-card .form-control {
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            height: 38px;
            font-size: 13px;
        }
        
        /* Table enhancements */
        .report-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 24px;
            border: 1px solid #e2e8f0;
        }
        .report-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .total-appointments {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 25px;
            background: #f1f5f9;
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
        }
        .custom-report-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
        }
        .custom-report-table th {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }
        .custom-report-table td {
            padding: 12px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
        }
        
        /* Theme Custom Colors (#1e3a8a) */
        .btn-custom-filter {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 20px;
            border-radius: 6px;
            border: none;
            height: 38px;
            margin-bottom: 10px;
            transition: all 0.2s ease-in-out;
        }
        .btn-custom-filter:hover {
            background-color: #172554 !important;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
        }
        .btn-custom-print {
            background-color: transparent !important;
            color: #1e3a8a !important;
            border: 1px solid #1e3a8a !important;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 18px;
            border-radius: 6px;
            height: 38px;
            margin-bottom: 10px;
            margin-left: 5px;
            transition: all 0.2s ease-in-out;
        }
        .btn-custom-print:hover {
            background-color: #f0f4ff !important;
            text-decoration: none;
        }

        /* Print Override Enhancements */
        @media print {
            body { background: #fff; color: #000; font-family: Arial, sans-serif; }
            .app-content { margin-left: 0 !important; padding: 0 !important; }
            #sidebar, .sidebar, header, #page-title, .filter-card, .btn-custom-print, .btn-custom-filter, footer {
                display: none !important;
            }
            .report-card { border: none; box-shadow: none; padding: 0; }
            .custom-report-table { width: 100%; border-collapse: collapse; }
            .custom-report-table th { background-color: #ddd !important; color: #000 !important; border: 1px solid #000 !important; }
            .custom-report-table td { border: 1px solid #000 !important; padding: 8px; }
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
                            <h1 class="mainTitle">Admin | Clinic Report</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Admin</span></li>
                            <li class="active"><span>Clinic Report</span></li>
                        </ol>
                    </div>
                </section>

                <div class="filter-card">
                    <form method="POST" action="" class="form-inline">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>">
                        </div>
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>">
                        </div>
                        <div class="form-group">
                            <label for="course_year">Course / Year</label>
                            <select name="course_year" id="course_year" class="form-control">
                                <option value="">All</option>
                                <option value="1st Year" <?php if ($course_year == '1st Year') echo 'selected'; ?>>1st Year</option>
                                <option value="2nd Year" <?php if ($course_year == '2nd Year') echo 'selected'; ?>>2nd Year</option>
                                <option value="3rd Year" <?php if ($course_year == '3rd Year') echo 'selected'; ?>>3rd Year</option>
                                <option value="4th Year" <?php if ($course_year == '4th Year') echo 'selected'; ?>>4th Year</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-custom-filter"><i class="fa fa-filter"></i> Filter</button>
                        <button type="button" onclick="printReport()" class="btn btn-custom-print"><i class="fa fa-print"></i> Print Report</button>
                    </form>
                </div>

                <div class="container-fluid container-fullw p-0">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="report-card">
                                <h5 class="report-title">Clinic Appointments Breakdown</h5>
                                <div class="total-appointments">
                                    Total Records Found: <?php echo mysqli_num_rows($result); ?>
                                </div>

                                <div class="table-responsive">
                                    <?php if (mysqli_num_rows($result) > 0) { ?>
                                        <table class="table custom-report-table">
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                                    <tr>
                                                        <td style="font-weight: 500; color: #1e293b;"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['course_year']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['sex']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['doctorName'] ?? 'Unassigned'); ?></td>
                                                        <td><?php echo htmlspecialchars($row['check_up_date']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['check_up_time']); ?></td>
                                                        <td>
                                                            <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['status']); ?></span>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="text-center text-muted py-4">No appointments found matching the selected criteria.</div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <?php include('include/footer.php'); ?>
            </div>
        </div>
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
        
        // Native Print Management Handler
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>