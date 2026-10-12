<?php
session_start();
include('include/config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

/**
 * ENHANCEMENT: Performance optimization using SQL LEFT JOIN.
 * This fetches doctor information instantly without executing 
 * individual queries inside the while loop.
 */
$queryAppointments = "SELECT a.*, d.doctorName 
                      FROM appointments a 
                      LEFT JOIN doctors d ON a.doctorId = d.id 
                      WHERE a.userId = '$userId' 
                      ORDER BY a.created_at DESC";
$resultAppointments = mysqli_query($con, $queryAppointments);

if (!$resultAppointments) {
    die("Appointments query failed: " . mysqli_error($con));
}

// Fetch medical history data for the logged-in user
$queryMedicalHistory = "SELECT * FROM medicalhistory WHERE userId = '$userId' LIMIT 1";
$resultMedicalHistory = mysqli_query($con, $queryMedicalHistory);

if (!$resultMedicalHistory) {
    die("Medical history query failed: " . mysqli_error($con));
}

$medicalHistory = mysqli_fetch_assoc($resultMedicalHistory);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Medical Assessment History</title>
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
        body { font-family: 'Raleway', sans-serif; background-color: #f8f9fa; }
        .mainTitle { font-weight: 600; color: #2c3e50; }
        
        /* Layout Blocks */
        .history-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #edf2f9;
            margin-bottom: 30px;
        }

        .section-header-custom {
            font-size: 18px;
            font-weight: 600;
            color: #343a40;
            margin-top: 0;
            margin-bottom: 20px;
        }

        /* Responsive Appointment Row Elements */
        .appointment-item {
            background: #fbfcfd;
            border: 1px solid #eef2f5;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.2s ease;
        }
        .appointment-item:hover {
            border-color: #1e3a8a;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        /* Status Label Badges */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background-color: rgba(255, 193, 7, 0.15); color: #d39e00; }
        .status-completed { background-color: rgba(40, 167, 69, 0.15); color: #28a745; }
        .status-canceled { background-color: rgba(220, 53, 69, 0.15); color: #dc3545; }
        .status-rescheduled { background-color: rgba(23, 162, 184, 0.15); color: #17a2b8; }

        /* Elegant Key-Value Lists */
        .meta-label { font-size: 11px; text-transform: uppercase; color: #95a5a6; font-weight: 600; display: block; margin-bottom: 2px; }
        .meta-value { font-size: 14px; color: #34495e; font-weight: 500; }
        
        /* Medical Vitals Grid System */
        .vitals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 15px;
        }
        .vital-box {
            background: #f8f9fa;
            border-left: 4px solid #1e3a8a;
            padding: 12px 15px;
            border-radius: 0 8px 8px 0;
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
                <section id="page-title" style="padding: 25px 0; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Medical Records Overview</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>User</span></li>
                            <li class="active"><span>History & Assessment</span></li>
                        </ol>
                    </div>
                </section>

                <div class="container-fluid container-fullw bg-white" style="border-radius: 8px; padding: 30px 15px;">
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="history-card">
                                <h2 class="section-header-custom"><i class="fa fa-calendar-check-o" style="margin-right: 8px;"></i> Assessment History Log</h2>
                                
                                <?php if (mysqli_num_rows($resultAppointments) == 0): ?>
                                    <div class="text-center" style="padding: 40px 0; color: #7f8c8d;">
                                        <i class="fa fa-folder-open-o fa-3x" style="margin-bottom: 10px;"></i>
                                        <p>No logged medical appointment entries found.</p>
                                    </div>
                                <?php else: ?>
                                    <?php 
                                    while ($row = mysqli_fetch_assoc($resultAppointments)) {
                                        $doctorName = $row['doctorName'] ? $row['doctorName'] : 'Assigned Practitioner';
                                        
                                        // Dynamic Status Setup
                                        $statusClass = 'status-pending';
                                        if($row['status'] == 'Completed') $statusClass = 'status-completed';
                                        if($row['status'] == 'Canceled') $statusClass = 'status-canceled';
                                        if($row['status'] == 'Rescheduled') $statusClass = 'status-rescheduled';
                                    ?>
                                        <div class="appointment-item">
                                            <div class="row" style="margin-bottom: 15px; display: flex; align-items: center; flex-wrap: wrap;">
                                                <div class="col-sm-4">
                                                    <span class="meta-label">Consulting Doctor</span>
                                                    <span class="meta-value" style="color: #1e3a8a; font-weight: 600;"><i class="fa fa-user-md"></i> Dr. <?php echo htmlspecialchars($doctorName); ?></span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="meta-label">Schedule Date & Time</span>
                                                    <span class="meta-value"><i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($row['check_up_date'] . ' @ ' . $row['check_up_time']); ?></span>
                                                </div>
                                                <div class="col-sm-4 text-right">
                                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                                </div>
                                            </div>
                                            
                                            <hr style="margin: 10px 0; border-color: #f1f1f1;">
                                            
                                            <div class="row">
                                                <div class="col-sm-3 col-xs-6" style="margin-bottom: 10px;">
                                                    <span class="meta-label">Patient Name</span>
                                                    <span class="meta-value"><?php echo htmlspecialchars($row['fullname']); ?></span>
                                                </div>
                                                <div class="col-sm-3 col-xs-6" style="margin-bottom: 10px;">
                                                    <span class="meta-label">Course / Year</span>
                                                    <span class="meta-value"><?php echo htmlspecialchars($row['course_year']); ?></span>
                                                </div>
                                                <div class="col-sm-2 col-xs-4" style="margin-bottom: 10px;">
                                                    <span class="meta-label">Age / Sex</span>
                                                    <span class="meta-value"><?php echo htmlspecialchars($row['age'] . ' yrs / ' . $row['sex']); ?></span>
                                                </div>
                                                <div class="col-sm-2 col-xs-4" style="margin-bottom: 10px;">
                                                    <span class="meta-label">Weight</span>
                                                    <span class="meta-value"><?php echo htmlspecialchars($row['weight']); ?> kg</span>
                                                </div>
                                                <div class="col-sm-2 col-xs-4" style="margin-bottom: 10px;">
                                                    <span class="meta-label">Blood Type</span>
                                                    <span class="meta-value" style="color: #c0392b; font-weight: 600;"><i class="fa fa-tint"></i> <?php echo htmlspecialchars($row['bloodtype']); ?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="row" style="margin-top: 5px;">
                                                <div class="col-sm-4">
                                                    <span class="meta-label">Contact No. & Address</span>
                                                    <span class="meta-value" style="font-size: 12px;"><?php echo htmlspecialchars($row['contact_number'] . ' | ' . $row['address']); ?></span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="meta-label">Parents (Father / Mother)</span>
                                                    <span class="meta-value" style="font-size: 12px;"><?php echo htmlspecialchars($row['father_name'] . ' / ' . $row['mother_name']); ?></span>
                                                </div>
                                                <div class="col-sm-4">
                                                    <span class="meta-label">Emergency Contact</span>
                                                    <span class="meta-value" style="font-size: 12px;"><i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($row['emergency_contact_name'] . ' (' . $row['emergency_contact_relation'] . ')'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php endif; ?>
                            </div>

                            <div class="history-card" style="margin-bottom: 0;">
                                <h2 class="section-header-custom"><i class="fa fa-heartbeat" style="margin-right: 8px;"></i> Diagnostic & Vitals History</h2>
                                
                                <?php if (!$medicalHistory): ?>
                                    <div class="text-center" style="padding: 20px 0; color: #95a5a6;">
                                        <p>No diagnostic vitals are recorded on file yet.</p>
                                    </div>
                                <?php else: ?>
                                    <div class="vitals-grid">
                                        <div class="vital-box">
                                            <span class="meta-label">Blood Pressure (BP)</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['BP'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Pulse Rate (PR)</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['PR'] ?: '--'); ?> bpm</span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Respiratory Rate (RR)</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['RR'] ?: '--'); ?> cpm</span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Temperature</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Temperature'] ?: '--'); ?> °C</span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">General Assessment</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['General'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Skin Assessment</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Skin'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">EENT Evaluation</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['EENT'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Chest Evaluation</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Chest'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Abdomen Structure</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Abdomen'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Extremities Condition</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Extremities'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Chest X-Ray Findings</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['ChestXray'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">HBsAg Variant Status</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['HBsAg'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Complete Blood Count (CBC)</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['CBC'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Urinalysis Findings</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Urinalysis'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box">
                                            <span class="meta-label">Stool Examination</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['StoolExam'] ?: '--'); ?></span>
                                        </div>
                                        <div class="vital-box" style="grid-column: 1 / -1; border-left-color: #2c3e50;">
                                            <span class="meta-label">Other Clinical Remarks</span>
                                            <span class="meta-value"><?php echo htmlspecialchars($medicalHistory['Others'] ?: 'None noted'); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php include('include/footer.php'); ?>
        <?php include('include/setting.php'); ?>
    </div>
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
    });
</script>
</body>
</html>