<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['submit']))
{
    $docspecialization = $_POST['Doctorspecialization'];
    $docname = $_POST['docname'];
    $docaddress = $_POST['clinicaddress'];
    $docfees = $_POST['docfees'];
    $doccontactno = $_POST['doccontact'];
    $docemail = $_POST['docemail'];
    $password = $_POST['npass']; 

    $sql = mysqli_query($con, "INSERT INTO doctors (specilization, doctorName, address, docFees, contactno, docEmail, password) 
                               VALUES ('$docspecialization', '$docname', '$docaddress', '$docfees', '$doccontactno', '$docemail', '$password')");

    if($sql) {
        echo "<script>alert('Doctor info added Successfully');</script>";
        echo "<script>window.location.href ='manage-doctors.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical Staff | Add Doctor</title>
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
            background-color: #f4f6f9;
        }
        .mainTitle {
            font-weight: 700;
            color: #1e3a8a;
        }
        .custom-form-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        .custom-form-card .panel-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e3a8a;
            margin-bottom: 25px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
        }
        .form-group label {
            font-weight: 600;
            color: #334155;
            font-size: 13px;
            margin-bottom: 6px;
        }
        .form-control {
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            height: auto;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        .btn-submit-medical {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 6px;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-submit-medical:hover {
            background-color: #0056b3;
            color: #ffffff;
        }
    </style>

    <script type="text/javascript">
    function valid() {
        if(document.adddoc.npass.value != document.adddoc.cfpass.value) {
            alert("Password and Confirm Password Field do not match  !!");
            document.adddoc.cfpass.focus();
            return false;
        }
        return true;
    }

    function checkemailAvailability() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'emailid=' + $("#docemail").val(),
            type: "POST",
            success: function(data) {
                $("#email-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function () {}
        });
    }
    </script>
</head>
<body>
    <div id="app">		
        <?php include('include/sidebar.php');?>
        <div class="app-content">
            <?php include('include/header.php');?>
            
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title" style="padding: 20px 0; margin-bottom: 20px;">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Medical Staff | Add Doctor</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Doctors</span></li>
                                <li class="active"><span>Add Doctor</span></li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white" style="border-radius: 8px; padding: 30px 15px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-8 col-md-12 col-lg-offset-2">
                                        <div class="custom-form-card">
                                            <h5 class="panel-title">Doctor Registration Profile</h5>
                                
                                            <form role="form" name="adddoc" method="post" onSubmit="return valid();">
                                                <div class="form-group">
                                                    <label for="DoctorSpecialization">Doctor Specialization</label>
                                                    <select name="Doctorspecialization" class="form-control" required="true">
                                                        <option value="">Select Specialization</option>
                                                        <?php 
                                                        $ret = mysqli_query($con,"select * from doctorspecilization");
                                                        while($row = mysqli_fetch_array($ret)) {
                                                        ?>
                                                            <option value="<?php echo htmlentities($row['specilization']);?>">
                                                                <?php echo htmlentities($row['specilization']);?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="doctorname">Doctor Name</label>
                                                    <input type="text" name="docname" class="form-control" placeholder="Enter Full Name" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="address">Doctor Clinic Address</label>
                                                    <textarea name="clinicaddress" class="form-control" rows="3" placeholder="Enter Office / Clinic Address" required="true"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="fess">Doctor Consultancy Fees</label>
                                                    <input type="text" name="docfees" class="form-control" placeholder="Enter Fee Amount" required="true">
                                                </div>
            
                                                <div class="form-group">
                                                    <label for="doccontact">Doctor Contact No</label>
                                                    <input type="text" name="doccontact" class="form-control" placeholder="Enter Mobile Number" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="docemail">Doctor Email</label>
                                                    <input type="email" id="docemail" name="docemail" class="form-control" placeholder="username@domain.com" required="true" onBlur="checkemailAvailability()">
                                                    <span id="email-availability-status" style="font-size: 12px; margin-top: 5px; display: block;"></span>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="npass">Password</label>
                                                            <input type="password" name="npass" class="form-control" placeholder="Create Password" required="required">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="cfpass">Confirm Password</label>
                                                            <input type="password" name="cfpass" class="form-control" placeholder="Repeat Password" required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div style="margin-top: 20px;">
                                                    <button type="submit" name="submit" id="submit" class="btn-submit-medical">
                                                        <i class="fa fa-check-circle" style="margin-right: 5px;"></i> Register Doctor
                                                    </button>
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
        <?php include('include/setting.php');?>
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