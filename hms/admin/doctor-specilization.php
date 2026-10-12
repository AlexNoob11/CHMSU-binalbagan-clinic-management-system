<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_POST['submit']))
{
    $sql=mysqli_query($con,"insert into doctorSpecilization(specilization) values('".$_POST['doctorspecilization']."')");
    $_SESSION['msg']="Doctor Specialization added successfully !!";
}

if(isset($_GET['del']))
{
    mysqli_query($con,"delete from doctorSpecilization where id = '".$_GET['id']."'");
    $_SESSION['msg']="Data deleted successfully !!";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Medical Staff | Doctor Specialization</title>
	
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
			body { font-family: 'Raleway', sans-serif; background-color: #f4f6f9; }
			.mainTitle { font-weight: 700; color: #1e3a8a; }
			.panel-white { border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
			.panel-white .panel-heading { border-bottom: 1px solid #f1f5f9; padding: 15px 20px; }
			.panel-white .panel-title { font-weight: 700; color: #1e3a8a; text-transform: uppercase; font-size: 14px; letter-spacing: 0.5px; }
			.btn-primary { background-color: #1e3a8a !important; border-color: #1e3a8a !important; font-weight: 600; padding: 6px 20px; border-radius: 4px; transition: all 0.2s; }
			.btn-primary:hover { background-color: #162e70 !important; border-color: #162e70 !important; }
			.table-custom-header { background-color: #f8fafc; color: #334155; }
			.table-custom-header th { font-weight: 700 !important; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; }
		</style>
	</head>
	<body>
		<div id="app">		
			<?php include('include/sidebar.php');?>
			<div class="app-content">
				<?php include('include/header.php');?>
					
				<div class="main-content">
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title" style="padding: 20px 0;">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Doctor Specialization</h1>
								</div>
								<ol class="breadcrumb">
									<li><span>Workspace</span></li>
									<li class="active"><span>Specialization</span></li>
								</ol>
							</div>
						</section>
						<!-- end: PAGE TITLE -->

						<div class="container-fluid container-fullw bg-white" style="border-radius: 8px; padding: 30px 20px;">
							<div class="row">
								<div class="col-md-12">
									
									<!-- Alerts block -->
									<?php if(!empty($_SESSION['msg'])) { ?>
									<div class="alert alert-success alert-dismissible" role="alert" style="border-radius: 6px;">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<i class="fa fa-check-circle" style="margin-right: 8px;"></i> <?php echo htmlentities($_SESSION['msg']); ?><?php $_SESSION['msg']=""; ?>
									</div>
									<?php } ?>

									<div class="row">
										<div class="col-lg-6 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Add New Specialization</h5>
												</div>
												<div class="panel-body" style="padding: 20px;">
													<form role="form" name="dcotorspcl" method="post">
														<div class="form-group">
															<label for="doctorspecilization" style="font-weight: 600; color: #475569; margin-bottom: 8px;">
																Specialization Title
															</label>
															<input type="text" name="doctorspecilization" class="form-control" placeholder="e.g. Cardiology, Pediatrics" required style="border-radius: 4px; padding: 8px 12px;">
														</div>
														<button type="submit" name="submit" class="btn btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>
									</div>

									<div class="row" style="margin-top: 30px;">
										<div class="col-md-12">
											<h5 class="over-title margin-bottom-15" style="font-weight: 700; color: #1e3a8a; text-transform: uppercase; font-size: 14px;">
												Existing Specializations
											</h5>
											
											<div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
												<table class="table table-hover style-table" id="sample-table-1" style="margin-bottom: 0;">
													<thead class="table-custom-header">
														<tr>
															<th class="center" style="width: 80px;">#</th>
															<th>Specialization</th>
															<th class="hidden-xs">Creation Date</th>
															<th>Last Updated</th>
															<th class="center" style="width: 120px;">Action</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$sql=mysqli_query($con,"select * from doctorSpecilization");
														$cnt=1;
														while($row=mysqli_fetch_array($sql))
														{
														?>
														<tr>
															<td class="center" style="vertical-align: middle;"><?php echo $cnt;?>.</td>
															<td style="vertical-align: middle; font-weight: 500; color: #334155;"><?php echo htmlentities($row['specilization']);?></td>
															<td class="hidden-xs" style="vertical-align: middle; color: #64748b;"><?php echo htmlentities($row['creationDate']);?></td>
															<td style="vertical-align: middle; color: #64748b;"><?php echo htmlentities($row['updationDate']);?></td>
															<td class="center" style="vertical-align: middle;">
																<div class="btn-group">
																	<a href="edit-doctor-specialization.php?id=<?php echo $row['id'];?>" class="btn btn-default btn-sm" style="border-radius: 4px; margin-right: 4px;" title="Edit">
																		<i class="fa fa-pencil" style="color: #475569;"></i>
																	</a>
																	<a href="doctor-specilization.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure you want to delete this specialization?')" class="btn btn-default btn-sm" style="border-radius: 4px;" title="Delete">
																		<i class="fa fa-times" style="color: #ef4444;"></i>
																	</a>
																</div>
															</td>
														</tr>
														<?php 
															$cnt=$cnt+1;
														} ?>
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
			</div>
			<?php include('include/footer.php');?>
			<?php include('include/setting.php');?>
		</div>

		<!-- MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- EXTRA PLUGINS IF REQUIRED -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- CLIP-TWO RUNTIME ENGINE -->
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