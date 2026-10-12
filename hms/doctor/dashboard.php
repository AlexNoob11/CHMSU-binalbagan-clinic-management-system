<?php
session_start();
error_reporting(0);
include('include/config.php');

// Check if the user is logged in
if (!isset($_SESSION['id']) && !isset($_SESSION['doctor_id'])) {
    header('Location: login.php'); 
    exit;
}

// Normalize identifier resolution fallback strategy
$doctor_id = !empty($_SESSION['doctor_id']) ? $_SESSION['doctor_id'] : $_SESSION['id'];

// Bind to session globally so header.php can read it safely without guessing
$_SESSION['id'] = $doctor_id; 

// Fetch doctor details from the database safely
$sql = "SELECT doctorName FROM doctors WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $doctor_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $doctorName);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Fetch real-time analytics for this specific doctor
$total_assigned = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments WHERE doctorId = '$doctor_id'"));
$pending_assigned = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments WHERE doctorId = '$doctor_id' AND (status IS NULL OR status = '' OR status = 'Pending')"));
$completed_assigned = mysqli_num_rows(mysqli_query($con, "SELECT id FROM appointments WHERE doctorId = '$doctor_id' AND status = 'Completed'"));

// Ratio metrics
$max_scale = max($total_assigned, 1);
$pending_pct = round(($pending_assigned / $max_scale) * 100);
$completed_pct = round(($completed_assigned / $max_scale) * 100);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Dashboard</title>

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
        .mainTitle { font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .welcome-text { color: #64748b; font-size: 14px; margin-bottom: 20px; font-weight: 500; }
        
        /* Analytics Structure styling cards */
        .analytics-card { 
            background: #ffffff; 
            border-radius: 12px; 
            padding: 24px; 
            margin-bottom: 25px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
            border: 1px solid #e2e8f0; 
            transition: all 0.25s ease-in-out; 
            text-align: left;
        }
        .analytics-card:hover { 
            transform: translateY(-4px); 
            box-shadow: 0 12px 20px -5px rgba(30, 58, 138, 0.15); 
        }
        .card-header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .card-icon-box { 
            width: 46px; 
            height: 46px; 
            background-color: #f0f4ff; 
            color: #1e3a8a; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 20px; 
        }
        .card-icon-pending { background-color: #fffbeb; color: #d97706; }
        .card-icon-completed { background-color: #f0fdf4; color: #16a34a; }

        .analytics-card h3 { 
            font-size: 11px; 
            font-weight: 700; 
            color: #64748b; 
            margin: 0; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
        }
        .metric-number {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 4px 0;
        }
        .metric-trend {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 14px;
        }
        
        /* Analytical Progress track */
        .progress-dim {
            background-color: #f1f5f9;
            height: 6px;
            border-radius: 4px;
            margin-bottom: 14px;
            overflow: hidden;
        }
        .progress-bar-custom { background-color: #1e3a8a; height: 100%; border-radius: 4px; }
        .progress-bar-pending { background-color: #d97706; }
        .progress-bar-completed { background-color: #16a34a; }

        .action-link-btn { 
            font-size: 12px; 
            font-weight: 600; 
            color: #1e3a8a; 
            text-decoration: none; 
            display: inline-block; 
            padding: 6px 14px; 
            background-color: #eff6ff; 
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .action-link-btn:hover {
            background-color: #1e3a8a;
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div id="app">		
        <?php include('include/sidebar.php');?>
        <div class="app-content">
            <?php include('include/header.php');?>

            <div class="main-content">
                <div class="wrap-content container" id="container">
                    
                    <!-- Page Header Context -->
                    <section id="page-title" style="padding: 15px 0;">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Doctor Command Center</h1>
                                <div class="welcome-text">Welcome back, Dr. <?php echo htmlspecialchars($doctorName); ?>! Review your clinical parameters below.</div>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Consultant</span></li>
                                <li class="active"><span>Dashboard</span></li>
                            </ol>
                        </div>
                    </section>

                    <!-- Interactive KPI Analytics Modules Matrix -->
                    <div class="container-fluid container-fullw p-0">
                        <div class="row">
                            
                            <!-- Profile Parameters Card -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Consultant Identity</h3>
                                        <div class="card-icon-box"><i class="fa fa-user-md"></i></div>
                                    </div>
                                    <div class="metric-number">Profile</div>
                                    <div class="metric-trend">Manage biographical credentials and signature keys</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom" style="width: 100%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="edit-profile.php" class="action-link-btn">Update Credentials <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Assigned Pending Queue Card -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Pending Evaluation</h3>
                                        <div class="card-icon-box card-icon-pending"><i class="fa fa-clock-o"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $pending_assigned; ?></div>
                                    <div class="metric-trend">Patients waiting in your active diagnostic cycle</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom progress-bar-pending" style="width: <?php echo $pending_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="appointment-history.php" class="action-link-btn" style="color:#d97706; background-color:#fffbeb;">Assess Queue <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Historical Medical Ledger Card -->
                            <div class="col-sm-4">
                                <div class="analytics-card">
                                    <div class="card-header-flex">
                                        <h3>Admissions History</h3>
                                        <div class="card-icon-box card-icon-completed"><i class="fa fa-history"></i></div>
                                    </div>
                                    <div class="metric-number"><?php echo $total_assigned; ?></div>
                                    <div class="metric-trend">Total clinical consult workflows processed to date</div>
                                    <div class="progress-dim">
                                        <div class="progress-bar-custom progress-bar-completed" style="width: <?php echo $completed_pct; ?>%;"></div>
                                    </div>
                                    <div class="text-right">
                                        <a href="appointment-history.php" class="action-link-btn" style="color:#16a34a; background-color:#f0fdf4;">Open History Ledger <i class="fa fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <?php include('include/footer.php');?>
        <?php include('include/setting.php');?>
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