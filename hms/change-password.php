<?php
session_start();
// error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

date_default_timezone_set('Asia/Kolkata');
$currentTime = date('d-m-Y h:i:s A', time());

if (isset($_POST['submit'])) {
    $cpass   = mysqli_real_escape_string($con, $_POST['cpass']);
    $npass   = mysqli_real_escape_string($con, $_POST['npass']);
    $user_id = intval($_SESSION['id']);
    
    $sql = mysqli_query($con, "SELECT password FROM users WHERE password = '" . md5($cpass) . "' AND id = '$user_id'");
    $num = mysqli_fetch_array($sql);
    
    if ($num > 0) {
        $update_sql = mysqli_query($con, "UPDATE users SET password = '" . md5($npass) . "', updationDate = '$currentTime' WHERE id = '$user_id'");
        $_SESSION['msg_success'] = "Password Changed Successfully !!";
    } else {
        $_SESSION['msg_error'] = "Old Password does not match !!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User | Change Password</title>
		
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
			
			.password-card {
				background: #ffffff;
				border-radius: 12px;
				box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
				padding: 30px;
				border: 1px solid #e2e8f0;
				max-width: 650px;
				margin-top: 10px;
			}
			.card-header-segment {
				border-bottom: 2px solid #f1f5f9;
				padding-bottom: 15px;
				margin-bottom: 25px;
			}
			.card-header-segment h4 {
				font-weight: 600;
				color: #334155;
				margin: 0;
			}
			.form-group label {
				font-weight: 600;
				color: #475569;
				font-size: 13px;
				margin-bottom: 8px;
			}
			.form-control {
				border-radius: 8px;
				border: 1px solid #cbd5e1;
				height: 42px;
				font-size: 14px;
				transition: all 0.3s ease;
				box-shadow: none !important;
			}
			.form-control:focus {
				border-color: #1e3a8a;
				box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.15) !important;
			}
			
			.btn-custom-submit {
				background-color: #1e3a8a !important;
				color: #ffffff !important;
				font-weight: 600;
				font-size: 14px;
				height: 44px;
				padding: 0 30px;
				border-radius: 8px;
				border: none;
				transition: all 0.2s ease-in-out;
				margin-top: 10px;
			}
			.btn-custom-submit:hover {
				background-color: #172554 !important;
				box-shadow: 0 4px 12px rgba(30, 58, 138, 0.25);
			}

			.alert-custom {
				padding: 12px 16px;
				border-radius: 8px;
				font-size: 13px;
				font-weight: 500;
				margin-bottom: 20px;
				border: 1px solid transparent;
			}
			.alert-custom-danger {
				background-color: #fef2f2;
				color: #991b1b;
				border-color: #fca5a5;
			}
			.alert-custom-success {
				background-color: #f0fdf4;
				color: #166534;
				border-color: #86efac;
			}
		</style>

		<script type="text/javascript">
			function valid() {
				if (document.chngpwd.cpass.value == "") {
					alert("Current Password Field is Empty !!");
					document.chngpwd.cpass.focus();
					return false;
				} else if (document.chngpwd.npass.value == "") {
					alert("New Password Field is Empty !!");
					document.chngpwd.npass.focus();
					return false;
				} else if (document.chngpwd.cfpass.value == "") {
					alert("Confirm Password Field is Empty !!");
					document.chngpwd.cfpass.focus();
					return false;
				} else if (document.chngpwd.npass.value != document.chngpwd.cfpass.value) {
					alert("Password and Confirm Password Field do not match !!");
					document.chngpwd.cfpass.focus();
					return false;
				}
				return true;
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
						<!-- start: PAGE TITLE -->
						<section id="page-title" class="padding-top-15 padding-bottom-15">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">User | Change Password</h1>
								</div>
								<ol class="breadcrumb">
									<li><span>User</span></li>
									<li class="active"><span>Change Password</span></li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->
						
						<div class="container-fluid container-fullw">
							<div class="row">
								<div class="col-md-12">
									
									<div class="password-card">
										<div class="card-header-segment">
											<h4>Security Credentials Update</h4>
											<small class="text-muted">Ensure your security footprint remains intact by changing passwords periodically</small>
										</div>

										<!-- Message Display Logic Area -->
										<?php if (isset($_SESSION['msg_error']) && $_SESSION['msg_error'] != "") { ?>
											<div class="alert-custom alert-custom-danger">
												<i class="fa fa-exclamation-circle"></i> <?php echo htmlentities($_SESSION['msg_error']); ?>
												<?php $_SESSION['msg_error'] = ""; ?>
											</div>
										<?php } ?>

										<?php if (isset($_SESSION['msg_success']) && $_SESSION['msg_success'] != "") { ?>
											<div class="alert-custom alert-custom-success">
												<i class="fa fa-check-circle"></i> <?php echo htmlentities($_SESSION['msg_success']); ?>
												<?php $_SESSION['msg_success'] = ""; ?>
											</div>
										<?php } ?>
										
										<?php if (isset($_SESSION['msg1']) && $_SESSION['msg1'] != "") { ?>
											<div class="alert-custom alert-custom-danger">
												<i class="fa fa-info-circle"></i> <?php echo htmlentities($_SESSION['msg1']); ?>
												<?php $_SESSION['msg1'] = ""; ?>
											</div>
										<?php } ?>

										<form role="form" name="chngpwd" method="post" onSubmit="return valid();">
											<div class="form-group">
												<label>Current Password</label>
												<input type="password" name="cpass" class="form-control" placeholder="Enter Current Password">
											</div>
											
											<div class="form-group">
												<label>New Password</label>
												<input type="password" name="npass" class="form-control" placeholder="Enter New Password">
											</div>
											
											<div class="form-group">
												<label>Confirm Password</label>
												<input type="password" name="cfpass" class="form-control" placeholder="Confirm Your New Password">
											</div>
											
											<button type="submit" name="submit" class="btn btn-custom-submit">
												Update Password
											</button>
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
		
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
			});
		</script>
	</body>
</html>
