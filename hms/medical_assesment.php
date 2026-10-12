<?php
session_start();
//error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Retrieve the userID from session
$userID = $_SESSION['user_id'];  // Assuming the user ID is stored as 'user_id' in session

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $course_year_designation = $_POST['course_year_designation'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $civil_status = $_POST['civil_status'];
    $weight = $_POST['weight'];
    $blood_type = $_POST['blood_type'];
    $religion = $_POST['religion'];
    $home_address = $_POST['home_address'];
    $contact_number = $_POST['contact_number'];
    $father_name = $_POST['father_name'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_occupation = $_POST['mother_occupation'];
    $spouse_name = $_POST['spouse_name'];
    $spouse_occupation = $_POST['spouse_occupation'];
    $num_of_children = $_POST['num_of_children'];
    $emergency_parent = $_POST['emergency_parent'];
    $emergency_relationship = $_POST['emergency_relationship'];
    $emergency_contact = $_POST['emergency_contact'];

    // Insert into the database (Now including userID)
    $query = mysqli_query($con, "INSERT INTO medicalassesment(userID, name, course_year_designation, birthdate, age, civil_status, weight, blood_type, religion, home_address, contact_number, father_name, father_occupation, mother_name, mother_occupation, spouse_name, spouse_occupation, num_of_children, emergency_parent, emergency_relationship, emergency_contact) 
    VALUES('$userID', '$name', '$course_year_designation', '$birthdate', '$age', '$civil_status', '$weight', '$blood_type', '$religion', '$home_address', '$contact_number', '$father_name', '$father_occupation', '$mother_name', '$mother_occupation', '$spouse_name', '$spouse_occupation', '$num_of_children', '$emergency_parent', '$emergency_relationship', '$emergency_contact')");

    if($query)
    {
        echo "<script>alert('Your information has been successfully saved');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Medical Assestment Form</title>
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
    
    <!-- Additional CSS for centering the form -->
    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-panel {
            width: 100%;
            max-width: 800px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #ffffff;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input, .form-group select {
            border-radius: 4px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
        }

        .form-group select {
            background-color: #f9f9f9;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">User | Medical Assesment Form</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>User</span></li>
                                <li class="active"><span>Medical Assesment Form</span></li>
                            </ol>
                    </section>

                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row margin-top-30">
                                    <div class="col-lg-12 col-md-12 form-container">
                                        <div class="panel panel-white form-panel">
                                            <div class="panel-heading">
                                                <h5 class="panel-title">Fill up for Medical Assesment Form</h5>
                                            </div>
                                            <div class="panel-body">
                                                <form role="form" name="update_info" method="post">
                                                    <div class="form-group">
                                                        <label for="name">Full Name</label>
                                                        <input type="text" name="name" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="course_year_designation">Course/Year/Designation</label>
                                                        <input type="text" name="course_year_designation" class="form-control" required="required">
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="student-course">Student Course</label>
                                                        <input type="text" name="student-course" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="birthdate">Birthdate</label>
                                                        <input type="date" name="birthdate" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="age">Age</label>
                                                        <input type="number" name="age" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="civil_status">Civil Status</label>
                                                        <select name="civil_status" class="form-control" required="required">
                                                            <option value="Single">Single</option>
                                                            <option value="Married">Married</option>
                                                            <option value="Widowed">Widowed</option>
                                                            <option value="Divorced">Divorced</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="weight">Weight</label>
                                                        <input type="text" name="weight" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="blood_type">Blood Type</label>
                                                        <input type="text" name="blood_type" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="religion">Religion</label>
                                                        <input type="text" name="religion" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="home_address">Home Address</label>
                                                        <input type="text" name="home_address" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="contact_number">Contact Number</label>
                                                        <input type="text" name="contact_number" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="father_name">Father's Name</label>
                                                        <input type="text" name="father_name" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="father_occupation">Father's Occupation</label>
                                                        <input type="text" name="father_occupation" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="mother_name">Mother's Name</label>
                                                        <input type="text" name="mother_name" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="mother_occupation">Mother's Occupation</label>
                                                        <input type="text" name="mother_occupation" class="form-control" required="required">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="spouse_name">Spouse's Name (if married)</label>
                                                        <input type="text" name="spouse_name" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="spouse_occupation">Spouse's Occupation</label>
                                                        <input type="text" name="spouse_occupation" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="num_of_children">No. of Children</label>
                                                        <input type="number" name="num_of_children" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="emergency_parent">In Case of Emergency (Parent/Guardian)</label>
                                                        <input type="text" name="emergency_parent" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="emergency_relationship">Relationship</label>
                                                        <input type="text" name="emergency_relationship" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="emergency_contact">Emergency Contact Number</label>
                                                        <input type="text" name="emergency_contact" class="form-control">
                                                    </div>

                                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
            <?php include('include/setting.php');?>
        </div>

        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script>
            jQuery(document).ready(function() {
                Main.init();
            });
        </script>
    </body>
</html>
