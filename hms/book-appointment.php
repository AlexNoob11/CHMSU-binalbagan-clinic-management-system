<?php
session_start();
include('include/config.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Function to validate input
function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$userId = $_SESSION['user_id']; 

// Check if the user has already filled up the form using Prepared Statements
$queryCheck = "SELECT form_submitted FROM appointments WHERE userId = ? LIMIT 1";
$stmtCheck = mysqli_prepare($con, $queryCheck);
mysqli_stmt_bind_param($stmtCheck, "i", $userId);
mysqli_stmt_execute($stmtCheck);
$resultCheck = mysqli_stmt_get_result($stmtCheck);
$formSubmitted = false;

if ($row = mysqli_fetch_assoc($resultCheck)) {
    if ($row['form_submitted'] == 1) {
        $formSubmitted = true;  
    }
}
mysqli_stmt_close($stmtCheck);

// Fetch doctors from the doctors table
$queryDoctors = "SELECT id, doctorName FROM doctors";
$resultDoctors = mysqli_query($con, $queryDoctors);
$doctors = [];
while ($doctor = mysqli_fetch_assoc($resultDoctors)) {
    $doctors[] = $doctor;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$formSubmitted) {
    // Collect and validate POST data
    $doctorId = validateInput($_POST['doctor']);
    $fullname = validateInput($_POST['fullname']);
    $course_year = validateInput($_POST['course_year']);
    
    // Only capture school year if designation is Student
    $school_year = ($course_year === 'Student') ? validateInput($_POST['school_year']) : '';
    
    $birthdate = validateInput($_POST['birthdate']);
    $age = validateInput($_POST['age']);
    $sex = validateInput($_POST['sex']);
    $civil_status = validateInput($_POST['civil_status']);
    $weight = validateInput($_POST['weight']);
    $bloodtype = validateInput($_POST['bloodtype']);
    $religion = validateInput($_POST['religion']);
    $address = validateInput($_POST['address']);
    $contact_number = validateInput($_POST['contact_number']);
    $father_name = validateInput($_POST['father_name']);
    $father_occupation = validateInput($_POST['father_occupation']);
    $mother_name = validateInput($_POST['mother_name']);
    $mother_occupation = validateInput($_POST['mother_occupation']);
    $num_children = validateInput($_POST['num_children']);
    $emergency_contact_name = validateInput($_POST['emergency_contact_name']);
    $emergency_contact_relation = validateInput($_POST['emergency_contact_relation']);
    $emergency_contact_number = validateInput($_POST['emergency_contact_number']);
    $form_submitted_val = 1;

    // Prepared Statement for SQL Injection prevention
    $query = "INSERT INTO appointments (doctorId, userId, fullname, course_year, school_year, birthdate, age, sex, civil_status, weight, bloodtype, religion, address, contact_number, father_name, father_occupation, mother_name, mother_occupation, num_children, emergency_contact_name, emergency_contact_relation, emergency_contact_number, form_submitted) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              
    $stmt = mysqli_prepare($con, $query);
    
    mysqli_stmt_bind_param(
        $stmt, 
        "iisssssssssssssssissssi", 
        $doctorId, $userId, $fullname, $course_year, $school_year, $birthdate, $age, $sex, 
        $civil_status, $weight, $bloodtype, $religion, $address, $contact_number, $father_name, 
        $father_occupation, $mother_name, $mother_occupation, $num_children, $emergency_contact_name, 
        $emergency_contact_relation, $emergency_contact_number, $form_submitted_val
    );

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        echo "<script>alert('Appointment successfully booked.'); window.location.href = 'book-appointment.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User | Medical Assessment Form</title>
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
        
        /* Modal & Form Upgrades */
        .modal-dialog-large { width: 45%; min-width: 680px; }
        @media (max-width: 768px) { .modal-dialog-large { width: 95%; min-width: auto; } }
        
        .modal-content { border-radius: 12px; border: none; box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .modal-header { background: #fafafa; border-bottom: 1px solid #eee; border-top-left-radius: 12px; border-top-right-radius: 12px; padding: 20px; }
        .modal-title { font-weight: 600; color: #333; }
        
        /* Modernized Form Fields */
        .form-group label { font-weight: 500; color: #555; font-size: 13px; margin-bottom: 6px; }
        .form-control { border-radius: 6px; border: 1px solid #dcdfe6; padding: 8px 12px; height: auto; box-shadow: none; transition: border-color 0.2s; }
        .form-control:focus { border-color: #1e3a8a; box-shadow: none; }
        .form-control[readonly] { background-color: #f5f7fa; color: #909399; }
        
        /* Custom Tab/Step Styling */
        .wizard-tabs { border-bottom: 2px solid #f0f2f5; margin-bottom: 25px; display: flex; justify-content: space-between; }
        .wizard-tabs li { width: 33.33%; text-align: center; list-style: none; }
        .wizard-tabs li a { display: block; padding: 12px 5px; font-weight: 600; color: #909399; border-bottom: 2px solid transparent; margin-bottom: -2px; text-decoration: none; font-size: 13px; }
        .wizard-tabs li.active a { color: #1e3a8a; border-bottom-color: #1e3a8a; }
        
        .action-box { background: #ffffff; border-radius: 8px; border: 1px solid #e6ebf5; padding: 40px; box-shadow: 0 2px 12px 0 rgba(0,0,0,0.01); }
        
        /* Unified Color Button Fixes */
        .btn-custom-navy { background-color: #1e3a8a !important; border-color: #1e3a8a !important; color: #ffffff !important; }
        .btn-custom-navy:hover, .btn-custom-navy:focus { background-color: #11255a !important; border-color: #11255a !important; color: #ffffff !important; }
    </style>
</head>
<body>
<div id="app">
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>
        <div class="main-content">
            <div class="wrap-content container">
                <section id="page-title" style="padding: 25px 0; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Medical Registration</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>User</span></li>
                            <li class="active"><span>Assessment Form</span></li>
                        </ol>
                    </div>
                </section>
                
                <div class="container-fluid container-fullw bg-white" style="border-radius: 8px; padding: 30px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="action-box text-center">
                                <?php if (!$formSubmitted): ?>
                                <div style="font-size: 48px; color: #1e3a8a; margin-bottom: 15px;"><i class="fa fa-file-text-o"></i></div>
                                <h3 style="margin-bottom: 10px; font-weight: 600;">Pending Assessment Form</h3>
                                <p style="color: #777; max-width: 500px; margin: 0 auto 25px;">Please complete the medical background declaration form below to unlock and secure a doctor's meeting time slot.</p>
                                <button type="button" class="btn btn-custom-navy btn-lg" style="border-radius: 6px; padding: 10px 30px; font-weight: 600;" data-toggle="modal" data-target="#medicalAssessmentModal">
                                    Fill Up Medical Form
                                </button>
                                <?php else: ?>
                                <div style="font-size: 48px; color: #28a745; margin-bottom: 15px;"><i class="fa fa-check-circle-o"></i></div>
                                <h3 style="margin-bottom: 10px; font-weight: 600; color: #28a745;">Form Complete</h3>
                                <p class="text-muted" style="margin-bottom: 0;">You have successfully recorded your basic medical history profile database entries.</p>
                                <?php endif; ?>
                            </div>

                            <div class="modal fade" id="medicalAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="medicalAssessmentModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-large" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="medicalAssessmentModalLabel"><i class="fa fa-pencil-square-o" style="color: #1e3a8a; margin-right: 8px;"></i>Medical History Entry</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -22px;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="POST" id="wizardForm">
                                            <div class="modal-body" style="padding: 25px 30px;">
                                                
                                                <ul class="wizard-tabs">
                                                    <li class="active" id="tab-head-1"><a href="javascript:void(0);">1. Personal Info</a></li>
                                                    <li id="tab-head-2"><a href="javascript:void(0);">2. Family Background</a></li>
                                                    <li id="tab-head-3"><a href="javascript:void(0);">3. Emergency Data</a></li>
                                                </ul>

                                                <div class="wizard-step-panel" id="step-panel-1">
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Full Name</label>
                                                            <input type="text" name="fullname" class="form-control" required>
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label>Preferred Consultant</label>
                                                            <select name="doctor" class="form-control" required>
                                                                <option value="">Select Doctor</option>
                                                                <?php foreach ($doctors as $doctor): ?>
                                                                    <option value="<?= $doctor['id']; ?>"><?= htmlspecialchars($doctor['doctorName']); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Designation Status</label>
                                                            <select name="course_year" class="form-control" id="course_year" required>
                                                                <option value="Student">Student</option>
                                                                <option value="Staff">Staff</option>
                                                                <option value="Faculty">Faculty</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 form-group" id="school-year">
                                                            <label>Current Year Level</label>
                                                            <select name="school_year" class="form-control" id="school_year">
                                                                <option value="1st Year">1st Year</option>
                                                                <option value="2nd Year">2nd Year</option>
                                                                <option value="3rd Year">3rd Year</option>
                                                                <option value="4th Year">4th Year</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4 form-group">
                                                            <label>Birthdate</label>
                                                            <input type="date" name="birthdate" class="form-control" required>
                                                        </div>
                                                        <div class="col-sm-4 form-group">
                                                            <label>Age (Auto-Calc)</label>
                                                            <input type="number" name="age" class="form-control" required readonly>
                                                        </div>
                                                        <div class="col-sm-4 form-group">
                                                            <label>Sex</label>
                                                            <select name="sex" class="form-control" required>
                                                                <option value="Male">Male</option>
                                                                <option value="Female">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4 form-group">
                                                            <label>Civil Status</label>
                                                            <select name="civil_status" class="form-control" required>
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Widowed">Widowed</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-4 form-group">
                                                            <label>Weight (kg)</label>
                                                            <input type="number" name="weight" class="form-control" required>
                                                        </div>
                                                        <div class="col-sm-4 form-group">
                                                            <label>Blood Type</label>
                                                            <input type="text" name="bloodtype" class="form-control" required placeholder="e.g. O+">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Religion</label>
                                                            <input type="text" name="religion" class="form-control" required>
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label>Contact Number</label>
                                                            <input type="text" name="contact_number" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Home Address</label>
                                                        <input type="text" name="address" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="wizard-step-panel" id="step-panel-2" style="display:none;">
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Father's Full Name</label>
                                                            <input type="text" name="father_name" class="form-control">
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label>Father's Occupation</label>
                                                            <input type="text" name="father_occupation" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Mother's Full Name</label>
                                                            <input type="text" name="mother_name" class="form-control">
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label>Mother's Occupation</label>
                                                            <input type="text" name="mother_occupation" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Number of Children in Family</label>
                                                            <input type="number" name="num_children" class="form-control" value="0">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="wizard-step-panel" id="step-panel-3" style="display:none;">
                                                    <div class="form-group">
                                                        <label>Emergency Contact Name</label>
                                                        <input type="text" name="emergency_contact_name" class="form-control">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-6 form-group">
                                                            <label>Relationship to User</label>
                                                            <input type="text" name="emergency_contact_relation" class="form-control">
                                                        </div>
                                                        <div class="col-sm-6 form-group">
                                                            <label>Emergency Contact Number</label>
                                                            <input type="text" name="emergency_contact_number" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer" style="background: #fafafa; border-top: 1px solid #eee; padding: 15px 30px;">
                                                <button type="button" class="btn btn-default" id="prevBtn" style="display:none; border-radius:6px;">Previous</button>
                                                <button type="button" class="btn btn-custom-navy" id="nextBtn" style="border-radius:6px; padding: 6px 20px; font-weight:600;">Next Step</button>
                                                <button type="submit" name="submit" class="btn btn-custom-navy" id="submitBtn" style="display:none; border-radius:6px; padding: 6px 25px; font-weight:600;">Submit Profile</button>
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

<script>
    jQuery(document).ready(function() {
        Main.init();
    });

    // Form Wizard Logic
    let currentStep = 1;
    const totalSteps = 3;

    function updateWizardUI() {
        // Panels toggle loop
        for (let i = 1; i <= totalSteps; i++) {
            if (i === currentStep) {
                $(`#step-panel-${i}`).show();
                $(`#tab-head-${i}`).addClass('active');
            } else {
                $(`#step-panel-${i}`).hide();
                $(`#tab-head-${i}`).removeClass('active');
            }
        }

        // Navigation controls state updates
        if (currentStep === 1) {
            $('#prevBtn').hide();
            $('#nextBtn').show();
            $('#submitBtn').hide();
        } else if (currentStep === totalSteps) {
            $('#prevBtn').show();
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#prevBtn').show();
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }
    }

    $('#nextBtn').click(function() {
        // Simple HTML5 validation challenge for current view inputs before proceeding
        let inputs = $(`#step-panel-${currentStep} :input[required]`);
        let valid = true;
        inputs.each(function() {
            if (!this.checkValidity()) {
                this.reportValidity();
                valid = false;
                return false; 
            }
        });
        
        if (valid && currentStep < totalSteps) {
            currentStep++;
            updateWizardUI();
        }
    });

    $('#prevBtn').click(function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizardUI();
        }
    });

    // Handle designation changes
    $('#course_year').change(function() {
        if ($(this).val() == 'Student') {
            $('#school-year').show();  
            $('#school_year').attr('required', true);
        } else {
            $('#school-year').hide();  
            $('#school_year').removeAttr('required').val('');
        }
    });

    // Calculate age based on birthdate
    $('input[name="birthdate"]').change(function() {
        if(!this.value) return;
        
        const birthdate = new Date(this.value);
        const today = new Date();
        
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        if (age >= 0) {
            $('input[name="age"]').val(age);
        } else {
            alert('Please enter a valid birthdate.');
            $('input[name="age"]').val(''); 
            $('input[name="birthdate"]').val('');
        }
    });
</script>
</body>
</html>