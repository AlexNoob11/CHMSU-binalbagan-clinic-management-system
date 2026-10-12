<?php
session_start();
error_reporting(0);
include('include/config.php');

// 1. NORMALIZE ID SCOPE & RECOVER SEPARATOR KEYS (Must happen BEFORE check_login)
if (isset($_SESSION['doctor_id']) && !empty($_SESSION['doctor_id'])) {
    $doctor_id = $_SESSION['doctor_id'];
    $_SESSION['id'] = $doctor_id; // Sync back to general key
} else if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $doctor_id = $_SESSION['id'];
    $_SESSION['doctor_id'] = $doctor_id; // Sync back to explicit key
} else if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
    $doctor_id = $_SESSION['login'];
    $_SESSION['id'] = $doctor_id;
    $_SESSION['doctor_id'] = $doctor_id;
} else {
    // If absolutely zero session markers exist, kick to login cleanly
    header('Location: login.php');
    exit();
}

// 2. NOW EXECUTE SYSTEM GUARD
include('include/checklogin.php');
check_login(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Appointment History</title>
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
        body { font-family: 'Raleway', sans-serif; background-color: #f8fafc; }
        .mainTitle { font-weight: 700; color: #1e293b; }
        
        .history-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            padding: 24px;
            border: 1px solid #e2e8f0;
            margin-top: 15px;
        }
        .history-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }
        .custom-history-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .custom-history-table th {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 12px;
            border-bottom: 2px solid #e2e8f0;
        }
        .custom-history-table td {
            padding: 12px;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Status Pill Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 600;
            border-radius: 50px;
            text-align: center;
        }
        .badge-pending { background-color: #fffbeb; color: #d97706; }
        .badge-completed { background-color: #f0fdf4; color: #16a34a; }
        .badge-canceled { background-color: #fef2f2; color: #dc2626; }
        .badge-rescheduled { background-color: #fdf2f8; color: #db2777; }

        /* Action Link Overrides */
        .btn-custom-action {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 6px;
            border: none;
            transition: all 0.2s ease-in-out;
        }
        .btn-custom-action:hover {
            background-color: #172554 !important;
            box-shadow: 0 4px 10px rgba(30, 58, 138, 0.2);
            text-decoration: none;
            color: #ffffff !important;
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
                                <h1 class="mainTitle">Doctor | Appointment History</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li class="active"><span>Appointment History</span></li>
                            </ol>
                        </div>
                    </section>
                    
                    <div class="container-fluid container-fullw p-0">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="history-card">
                                    <h5 class="history-title">Assigned Patient Logs</h5>
                                    
                                    <div class="table-responsive">
                                        <table id="datatable" class="table custom-history-table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 5%;">#</th>
                                                    <th>Patient Name</th>
                                                    <th>Course/Year</th>
                                                    <th class="text-center">Age</th>
                                                    <th class="text-center">Sex</th>
                                                    <th>Contact Number</th>
                                                    <th class="text-center">Status</th>
                                                    <th>Booking Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $clean_doctor_id = mysqli_real_escape_string($con, $doctor_id);
                                                
                                                $query = "SELECT id, fullname, course_year, age, sex, contact_number, status, created_at 
                                                          FROM appointments 
                                                          WHERE doctorId = '$clean_doctor_id' 
                                                          ORDER BY created_at DESC";
                                                
                                                $result = mysqli_query($con, $query);
                                                $cnt = 1;
                                                
                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $current_status = $row['status'] ? $row['status'] : 'Pending';
                                                        
                                                        $status_class = "badge-pending";
                                                        if($current_status == 'Completed') $status_class = "badge-completed";
                                                        if($current_status == 'Canceled')  $status_class = "badge-canceled";
                                                        if($current_status == 'Rescheduled') $status_class = "badge-rescheduled";
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $cnt; ?></td>
                                                    <td style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($row['fullname']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['course_year']); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row['age']); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row['sex']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                                                    <td class="text-center">
                                                        <span class="status-badge <?php echo $status_class; ?>">
                                                            <?php echo htmlspecialchars($current_status); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                                    <td class="text-center">
                                                        <a href="view-patient.php?id=<?php echo $row['id']; ?>" class="btn btn-custom-action">
                                                            <i class="fa fa-eye"></i> View History
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                        $cnt++;
                                                    }
                                                } else {
                                                ?>
                                                    <tr>
                                                        <td colspan="9" class="text-center text-muted py-4">No patients currently allocated inside your appointment lookup.</td>
                                                    </tr>
                                                <?php } ?>
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