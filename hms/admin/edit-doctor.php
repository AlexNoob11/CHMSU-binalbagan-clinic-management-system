<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

$msg = ""; // Initialize message variable to prevent undefined warning
$did = intval($_GET['id']); // Securely grab the doctor ID from the URL string

// Form Processor Update Logic
if(isset($_POST['submit'])) {
    $docspecialization = mysqli_real_escape_string($con, $_POST['Doctorspecialization']);
    $docname = mysqli_real_escape_string($con, $_POST['docname']);
    $clinicaddress = mysqli_real_escape_string($con, $_POST['clinicaddress']);
    $docfees = mysqli_real_escape_string($con, $_POST['docfees']);
    $doccontact = mysqli_real_escape_string($con, $_POST['doccontact']);
    
    $sql = mysqli_query($con, "UPDATE doctors SET specilization='$docspecialization', doctorName='$docname', address='$clinicaddress', docFees='$docfees', contactno='$doccontact' WHERE id='$did'");
    
    if($sql) {
        $msg = "Doctor details updated successfully.";
    } else {
        $msg = "Error updating records: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Edit Doctor Details</title>
		
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
			.card-container {
				background: #ffffff;
				border-radius: 12px;
				box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
				padding: 30px;
				margin-top: 20px;
				border: 1px solid #e2e8f0;
			}
			.profile-meta-box {
				background-color: #f8fafc;
				border-left: 4px solid #1e3a8a;
				padding: 15px;
				border-radius: 0 8px 8px 0;
				margin-bottom: 25px;
			}
			.profile-meta-box h4 { margin-top: 0; font-weight: 700; color: #1e3a8a; }
			.profile-meta-box p { margin-bottom: 5px; font-size: 13px; color: #64748b; }
			.control-label, label { font-weight: 600; color: #475569; font-size: 13px; }
			.form-control {
				border-radius: 8px;
				border: 1px solid #cbd5e1;
				height: 40px;
				font-size: 14px;
				transition: all 0.3s ease;
			}
			.form-control:focus {
				border-color: #1e3a8a;
				box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.15);
			}
			textarea.form-control { height: auto; min-height: 80px; }
			.btn-custom-submit {
				background-color: #1e3a8a !important;
				color: #ffffff !important;
				font-weight: 600;
				font-size: 14px;
				padding: 10px 30px;
				border-radius: 6px;
				border: none;
				transition: all 0.2s ease-in-out;
			}
			.btn-custom-submit:hover {
				background-color: #172554 !important;
				box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
			}
			.alert-custom-success {
				background-color: #f0fdf4;
				border: 1px solid #bbf7d0;
				color: #16a34a;
				border-radius: 8px;
				padding: 12px 15px;
				font-size: 14px;
				font-weight: 600;
				margin-bottom: 20px;
			}
		</style>
	</head>
	<body>
		<div id="app">		
			<?php include('include/sidebar.php');?>
			<div class="app-content">
				<?php include('include/header.php');?>
				
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title" class="padding-top-15 padding-bottom-15">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Edit Doctor Details</h1>
								</div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>Edit Doctor Details</span></li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->

						<div class="container-fluid container-fullw">
							<div class="row">
								<div class="col-md-12 col-lg-9">
									
									<div class="card-container">
										<?php if(!empty($msg)) { ?>
											<div class="alert-custom-success"><i class="fa fa-check-circle"></i> <?php echo htmlentities($msg);?></div>
										<?php } ?>

										<?php 
										$sql = mysqli_query($con, "select * from doctors where id='$did'");
										while($data = mysqli_fetch_array($sql)) {
										?>
										
										<div class="profile-meta-box">
											<h4><?php echo htmlentities($data['doctorName']);?>'s Profile</h4>
											<p><b>Profile Registered Date: </b><?php echo htmlentities($data['creationDate']);?></p>
											<?php if($data['updationDate']){?>
												<p><b>Last Updated Date: </b><?php echo htmlentities($data['updationDate']);?></p>
											<?php } ?>
										</div>

										<form role="form" name="adddoc" method="post">
											<div class="form-group">
												<label for="DoctorSpecialization">Doctor Specialization</label>
												<select name="Doctorspecialization" class="form-control" required="required">
													<option value="<?php echo htmlentities($data['specilization']);?>">
														<?php echo htmlentities($data['specilization']);?>
													</option>
													<?php 
													$ret = mysqli_query($con, "select * from doctorspecilization");
													while($row = mysqli_fetch_array($ret)) {
														if($row['specilization'] != $data['specilization']) {
													?>
														<option value="<?php echo htmlentities($row['specilization']);?>">
															<?php echo htmlentities($row['specilization']);?>
														</option>
													<?php 
														}
													} 
													?>
												</select>
											</div>

											<div class="form-group">
												<label for="doctorname">Doctor Name</label>
												<input type="text" name="docname" class="form-control" value="<?php echo htmlentities($data['doctorName']);?>" required>
											</div>

											<div class="form-group">
												<label for="address">Doctor Clinic Address</label>
												<textarea name="clinicaddress" class="form-control" required><?php echo htmlentities($data['address']);?></textarea>
											</div>

											<div class="form-group">
												<label for="fess">Doctor Consultancy Fees</label>
												<input type="text" name="docfees" class="form-control" required="required" value="<?php echo htmlentities($data['docFees']);?>" >
											</div>
				
											<div class="form-group">
												<label for="doccontact">Doctor Contact No</label>
												<input type="text" name="doccontact" class="form-control" required="required" value="<?php echo htmlentities($data['contactno']);?>">
											</div>

											<div class="form-group">
												<label for="docemail">Doctor Email</label>
												<input type="email" name="docemail" class="form-control" readonly="readonly" value="<?php echo htmlentities($data['docEmail']);?>">
												<small class="text-muted">Email modifications cannot be changed here for authentication consistency.</small>
											</div>
											
											<?php } ?>
											
											<div class="margin-top-25">
												<button type="submit" name="submit" class="btn btn-custom-submit">
													Update Profile
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
			<!-- start: FOOTER -->
			<?php include('include/footer.php');?>
			<!-- start: SETTINGS -->
			<?php include('include/setting.php');?>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
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