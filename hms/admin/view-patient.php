<?php
session_start();
error_reporting(0);
include('include/config.php');

// Ensure the admin is logged in
if (!isset($_SESSION['login'])) {
    header('location:index.php');
    exit();
}

if (isset($_POST['submit'])) {
    $appointment_id = mysqli_real_escape_string($con, $_GET['id']);
    
    // Fetch userId from the appointments table based on the appointment ID
    $query = "SELECT userId FROM appointments WHERE id = '$appointment_id'";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_array($result)) {
        // Get the userId from the appointment record
        $userId = $row['userId'];
    } else {
        echo '<script>alert("Appointment not found.")</script>';
        exit();
    }
    
    // Sanitize inputs to prevent SQL injection
    $bp = mysqli_real_escape_string($con, $_POST['bp']);
    $pr = mysqli_real_escape_string($con, $_POST['pr']);
    $rr = mysqli_real_escape_string($con, $_POST['rr']);
    $temp = mysqli_real_escape_string($con, $_POST['temp']);
    $general = mysqli_real_escape_string($con, $_POST['general']);
    $skin = mysqli_real_escape_string($con, $_POST['skin']);
    $eent = mysqli_real_escape_string($con, $_POST['eent']);
    $chest = mysqli_real_escape_string($con, $_POST['chest']);
    $abdomen = mysqli_real_escape_string($con, $_POST['abdomen']);
    $extremities = mysqli_real_escape_string($con, $_POST['extremities']);
    $chest_xray = mysqli_real_escape_string($con, $_POST['chest_xray']);
    $hbsag = mysqli_real_escape_string($con, $_POST['hbsag']);
    $cbc = mysqli_real_escape_string($con, $_POST['cbc']);
    $urinalysis = mysqli_real_escape_string($con, $_POST['urinalysis']);
    $stool_exam = mysqli_real_escape_string($con, $_POST['stool_exam']);
    $others = mysqli_real_escape_string($con, $_POST['others']);

    // Insert into medicalhistory table
    $query = "INSERT INTO medicalhistory(appointmentId, userId, BP, PR, RR, Temperature, General, Skin, EENT, Chest, Abdomen, Extremities, ChestXray, HBsAg, CBC, Urinalysis, StoolExam, Others) 
              VALUES ('$appointment_id', '$userId', '$bp', '$pr', '$rr', '$temp', '$general', '$skin', '$eent', '$chest', '$abdomen', '$extremities', '$chest_xray', '$hbsag', '$cbc', '$urinalysis', '$stool_exam', '$others')";
    
    $result = mysqli_query($con, $query);
    if ($result) {
        echo '<script>alert("Medical history has been added successfully.")</script>';
        echo "<script>window.location.href ='manage-patient.php'</script>";
    } else {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }
}

// Fetch appointment details
$appointment_id = mysqli_real_escape_string($con, $_GET['id']);
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
        <title>Doctor | Manage Patients</title>
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
            .profile-card {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                padding: 24px;
                border: 1px solid #e2e8f0;
                margin-bottom: 25px;
            }
            .section-heading {
                font-size: 14px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #1e3a8a;
                font-weight: 700;
                border-bottom: 2px solid #f1f5f9;
                padding-bottom: 6px;
                margin-top: 20px;
                margin-bottom: 15px;
            }
            .info-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px 30px;
            }
            @media(max-width: 767px) { .info-grid { grid-template-columns: 1fr; } }
            .info-item {
                display: flex;
                border-bottom: 1px solid #f8fafc;
                padding-bottom: 8px;
            }
            .info-label {
                width: 40%;
                font-weight: 600;
                color: #475569;
                font-size: 13px;
            }
            .info-value {
                width: 60%;
                color: #1e293b;
                font-size: 13px;
            }
            .status-badge {
                display: inline-block;
                padding: 4px 12px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 12px;
                background-color: #dcfce7;
                color: #15803d;
            }
            /* Custom Button Color Changes (#1e3a8a) */
            .btn-custom {
                background-color: #1e3a8a !important;
                color: #ffffff !important;
                font-weight: 600;
                border-radius: 6px;
                padding: 10px 24px;
                border: none;
                transition: all 0.2s ease-in-out;
            }
            .btn-custom:hover {
                background-color: #172554 !important;
                box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
            }
            /* Modal Form Cleanups */
            .modal-content { border-radius: 12px; border: none; }
            .modal-header { background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0; }
            .modal-title { color: #1e293b; font-weight: 600; }
            .form-section-title { font-size: 13px; font-weight: 700; color: #475569; background: #f1f5f9; padding: 6px 12px; margin: 15px 0 10px; border-radius: 4px; }
            .vital-group { display: flex; gap: 10px; flex-wrap: wrap; }
            .vital-item { flex: 1; min-width: 110px; }
            .vital-item label { font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 2px; }
        </style>
    </head>
    <body>
        <div id="app">
            <?php include('include/sidebar.php');?>
            <div class="app-content">
                <?php include('include/header.php');?>
                <div class="main-content">
                    <div class="wrap-content container" id="container">
                        <section id="page-title" class="padding-top-15 padding-bottom-15">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1 class="mainTitle">Medical Staff | Manage Patients</h1>
                                </div>
                                <ol class="breadcrumb">
                                    <li><span>Medical Staff</span></li>
                                    <li class="active"><span>Manage Patients</span></li>
                                </ol>
                            </div>
                        </section>
                        
                        <div class="container-fluid container-fullw">
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <div class="profile-card">
                                        <h4 class="margin-bottom-20" style="color:#1e293b; font-weight: 600;">
                                            Appointment File: <span style="color: #1e3a8a;"><?php echo htmlspecialchars($fullname); ?></span>
                                        </h4>
                                        
                                        <div class="section-heading">Primary Medical Information</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Full Name</div><div class="info-value"><?php echo htmlspecialchars($fullname); ?></div></div>
                                            <div class="info-item"><div class="info-label">Course/Year</div><div class="info-value"><?php echo htmlspecialchars($course_year); ?></div></div>
                                            <div class="info-item"><div class="info-label">Birthdate</div><div class="info-value"><?php echo htmlspecialchars($birthdate); ?></div></div>
                                            <div class="info-item"><div class="info-label">Age / Sex</div><div class="info-value"><?php echo htmlspecialchars($age); ?> Yrs / <?php echo htmlspecialchars($sex); ?></div></div>
                                            <div class="info-item"><div class="info-label">Weight</div><div class="info-value"><?php echo htmlspecialchars($weight); ?> kg</div></div>
                                            <div class="info-item"><div class="info-label">Blood Type</div><div class="info-value"><span class="badge badge-inverse"><?php echo htmlspecialchars($bloodtype); ?></span></div></div>
                                            <div class="info-item"><div class="info-label">Civil Status</div><div class="info-value"><?php echo htmlspecialchars($civil_status); ?></div></div>
                                            <div class="info-item"><div class="info-label">Religion</div><div class="info-value"><?php echo htmlspecialchars($religion); ?></div></div>
                                        </div>

                                        <div class="section-heading">Contact & Demographics</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Contact Number</div><div class="info-value"><?php echo htmlspecialchars($contact_number); ?></div></div>
                                            <div class="info-item"><div class="info-label">Address</div><div class="info-value"><?php echo htmlspecialchars($address); ?></div></div>
                                            <div class="info-item"><div class="info-label">Father's Info</div><div class="info-value"><?php echo htmlspecialchars($father_name); ?> (<?php echo htmlspecialchars($father_occupation); ?>)</div></div>
                                            <div class="info-item"><div class="info-label">Mother's Info</div><div class="info-value"><?php echo htmlspecialchars($mother_name); ?> (<?php echo htmlspecialchars($mother_occupation); ?>)</div></div>
                                            <div class="info-item"><div class="info-label">No. of Children</div><div class="info-value"><?php echo htmlspecialchars($num_children); ?></div></div>
                                        </div>

                                        <div class="section-heading">Emergency Records</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Contact Name</div><div class="info-value"><?php echo htmlspecialchars($emergency_contact_name); ?></div></div>
                                            <div class="info-item"><div class="info-label">Relationship</div><div class="info-value"><?php echo htmlspecialchars($emergency_contact_relation); ?></div></div>
                                            <div class="info-item"><div class="info-label">Emergency Phone</div><div class="info-value"><?php echo htmlspecialchars($emergency_contact_number); ?></div></div>
                                        </div>

                                        <div class="section-heading">File Properties</div>
                                        <div class="info-grid">
                                            <div class="info-item"><div class="info-label">Created Date</div><div class="info-value"><?php echo htmlspecialchars($created_at); ?></div></div>
                                            <div class="info-item"><div class="info-label">File Status</div><div class="info-value"><span class="status-badge"><?php echo htmlspecialchars($status); ?></span></div></div>
                                        </div>

                                        <div class="text-center margin-top-30">
                                            <button class="btn btn-custom btn-lg" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-plus-circle"></i> Add Medical History
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-file-text-o" style="color:#1e3a8a;"></i> Record New Medical History</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" name="submit">
                                                    <div class="modal-body">
                                                        
                                                        <div class="form-section-title">Patient Vital Signs</div>
                                                        <div class="vital-group margin-bottom-15">
                                                            <div class="vital-item">
                                                                <label>BP (mmHg)</label>
                                                                <input name="bp" placeholder="e.g. 120/80" class="form-control">
                                                            </div>
                                                            <div class="vital-item">
                                                                <label>PR (bpm)</label>
                                                                <input name="pr" placeholder="e.g. 72" class="form-control">
                                                            </div>
                                                            <div class="vital-item">
                                                                <label>RR (cpm)</label>
                                                                <input name="rr" placeholder="e.g. 16" class="form-control">
                                                            </div>
                                                            <div class="vital-item">
                                                                <label>Temperature (°C)</label>
                                                                <input name="temp" placeholder="e.g. 36.5" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-section-title">Physical Examinations</div>
                                                        <div class="row">
                                                            <div class="col-md-6 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">General</label>
                                                                <textarea name="general" placeholder="General Assessment" rows="2" class="form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">Skin</label>
                                                                <textarea name="skin" placeholder="Skin Assessment" rows="2" class="form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">EENT</label>
                                                                <textarea name="eent" placeholder="Eyes, Ears, Nose, Throat" rows="2" class="form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">Chest</label>
                                                                <textarea name="chest" placeholder="Chest Assessment" rows="2" class="form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">Abdomen</label>
                                                                <textarea name="abdomen" placeholder="Abdomen Assessment" rows="2" class="form-control"></textarea>
                                                            </div>
                                                            <div class="col-md-6 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">Extremities</label>
                                                                <textarea name="extremities" placeholder="Extremities Assessment" rows="2" class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-section-title">Treatment Plan</div>
                                                        <div class="row">
                                                            <div class="col-md-12 margin-bottom-10">
                                                                <label class="text-small text-semibold text-muted">Prescription</label>
                                                                <textarea name="prescription" placeholder="Enter medication and dosage descriptions..." rows="2" class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-section-title">Laboratory Examinations</div>
                                                        <div class="row">
                                                            <div class="col-md-4 margin-bottom-10">
                                                                <label class="text-small text-muted">Chest X-ray</label>
                                                                <input name="chest_xray" placeholder="Findings" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 margin-bottom-10">
                                                                <label class="text-small text-muted">HBsAg</label>
                                                                <input name="hbsag" placeholder="Findings" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 margin-bottom-10">
                                                                <label class="text-small text-muted">CBC</label>
                                                                <input name="cbc" placeholder="Findings" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 margin-bottom-10">
                                                                <label class="text-small text-muted">Urinalysis</label>
                                                                <input name="urinalysis" placeholder="Findings" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 margin-bottom-10">
                                                                <label class="text-small text-muted">Stool Exam</label>
                                                                <input name="stool_exam" placeholder="Findings" class="form-control">
                                                            </div>
                                                            <div class="col-md-4 margin-bottom-10">
                                                                <label class="text-small text-muted">Others</label>
                                                                <input name="others" placeholder="Other Test Details" class="form-control">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-dismiss="modal" style="border: 1px solid #cbd5e1;">Cancel</button>
                                                        <button type="submit" name="submit" class="btn btn-custom">Save Record</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('include/footer.php');?>
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
        </script>
    </body>
</html>