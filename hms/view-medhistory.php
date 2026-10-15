<?php
session_start();
// It is recommended to turn error reporting on during development: error_reporting(E_ALL);
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $vid    = $_GET['viewid'];
    $bp     = mysqli_real_escape_string($con, $_POST['bp']);
    $bs     = mysqli_real_escape_string($con, $_POST['bs']);
    $weight = mysqli_real_escape_string($con, $_POST['weight']);
    $temp   = mysqli_real_escape_string($con, $_POST['temp']);
    $pres   = mysqli_real_escape_string($con, $_POST['pres']);
      
    $query = mysqli_query($con, "INSERT INTO tblmedicalhistory (PatientID, BloodPressure, BloodSugar, Weight, Temperature, MedicalPres) VALUES ('$vid', '$bp', '$bs', '$weight', '$temp', '$pres')");
    
    if ($query) {
        echo '<script>alert("Medical history has been added.");</script>';
        echo '<script>window.location.href = "manage-patient.php";</script>';
    } else {
        echo '<script>alert("Something Went Wrong. Please try again");</script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Users | Medical History</title>
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
	</head>
	<body>
		<div id="app">		
			<?php include('include/sidebar.php');?>
			<div class="app-content">
				<?php include('include/header.php');?>
				<div class="main-content">
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Users | Medical History</h1>
								</div>
								<ol class="breadcrumb">
									<li><span>Users</span></li>
									<li class="active"><span>Medical History</span></li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->

						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<h5 class="over-title margin-bottom-15">Users <span class="text-bold">Medical History</span></h5>
									
									<?php
									$vid = $_GET['viewid'];
									$ret = mysqli_query($con, "SELECT * FROM tblpatient WHERE ID='$vid'");
									while ($row = mysqli_fetch_array($ret)) {
									?>
									<table border="1" class="table table-bordered">
										<tr align="center">
											<td colspan="4" style="font-size:20px;color:blue">Patient Details</td>
										</tr>
										<tr>
											<th scope="row">Patient Name</th>
											<td><?php echo $row['PatientName']; ?></td>
											<th scope="row">Patient Email</th>
											<td><?php echo $row['PatientEmail']; ?></td>
										</tr>
										<tr>
											<th scope="row">Patient Mobile Number</th>
											<td><?php echo $row['PatientContno']; ?></td>
											<th scope="row">Patient Address</th>
											<td><?php echo $row['PatientAdd']; ?></td>
										</tr>
										<tr>
											<th scope="row">Patient Gender</th>
											<td><?php echo $row['PatientGender']; ?></td>
											<th scope="row">Patient Age</th>
											<td><?php echo $row['PatientAge']; ?></td>
										</tr>
										<tr>
											<th scope="row">Patient Medical History (if any)</th>
											<td><?php echo $row['PatientMedhis']; ?></td>
											<th scope="row">Patient Reg Date</th>
											<td><?php echo $row['CreationDate']; ?></td>
										</tr>
									</table>
									<?php } ?>

									<!-- Add Medical History Form -->
									<div class="row margin-top-30">
										<div class="col-md-12">
											<h5 class="over-title margin-bottom-15">Add <span class="text-bold">Medical History</span></h5>
											<form method="post">
												<div class="row">
													<div class="col-md-6 form-group">
														<label>Blood Pressure</label>
														<input type="text" name="bp" class="form-control" placeholder="Enter Blood Pressure" required>
													</div>
													<div class="col-md-6 form-group">
														<label>Blood Sugar</label>
														<input type="text" name="bs" class="form-control" placeholder="Enter Blood Sugar" required>
													</div>
												</div>
												<div class="row">
													<div class="col-md-6 form-group">
														<label>Weight</label>
														<input type="text" name="weight" class="form-control" placeholder="Enter Weight" required>
													</div>
													<div class="col-md-6 form-group">
														<label>Body Temperature</label>
														<input type="text" name="temp" class="form-control" placeholder="Enter Temperature" required>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12 form-group">
														<label>Medical Prescription</label>
														<textarea name="pres" class="form-control" placeholder="Enter Medical Prescription" rows="3" required></textarea>
													</div>
												</div>
												<button type="submit" name="submit" class="btn btn-primary">Add History</button>
											</form>
										</div>
									</div>

									<hr class="margin-top-30">

									<?php  
									$ret = mysqli_query($con, "SELECT * FROM tblmedicalhistory WHERE PatientID='$vid'");
									$cnt = 1;
									?>
									<table id="datatable" class="table table-bordered dt-responsive nowrap margin-top-20" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<tr align="center">
											<th colspan="7">Medical History Records</th> 
										</tr>
										<tr>
											<th>#</th>
											<th>Blood Pressure</th>
											<th>Weight</th>
											<th>Blood Sugar</th>
											<th>Body Temperature</th>
											<th>Medical Prescription</th>
											<th>Visit Date</th>
										</tr>
										<?php  
										while ($row = mysqli_fetch_array($ret)) { 
										?>
										<tr>
											<td><?php echo $cnt; ?></td>
											<td><?php echo $row['BloodPressure']; ?></td>
											<td><?php echo $row['Weight']; ?></td>
											<td><?php echo $row['BloodSugar']; ?></td> 
											<td><?php echo $row['Temperature']; ?></td>
											<td><?php echo $row['MedicalPres']; ?></td>
											<td><?php echo $row['CreationDate']; ?></td> 
										</tr>
										<?php 
											$cnt++;
										} 
										?>
									</table>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- start: FOOTER -->
			<?php include('include/footer.php');?>
			<!-- end: FOOTER -->
			
			<!-- start: SETTINGS -->
			<?php include('include/setting.php');?>
			<!-- end: SETTINGS -->
		</div>

		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
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
