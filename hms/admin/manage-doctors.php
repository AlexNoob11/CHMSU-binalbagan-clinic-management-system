<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_GET['del'])) {
    mysqli_query($con, "delete from doctors where id = '".$_GET['id']."'");
    $_SESSION['msg']="Data deleted successfully !!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Manage Doctors</title>
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
        .panel-white { border: none; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .panel-heading { background: #fff !important; border-bottom: 2px solid #f4f6f9; padding: 20px; }
        .table > thead > tr > th { border-bottom: 2px solid #e2e8f0; color: #1e3a8a; text-transform: uppercase; font-size: 12px; }
        .btn-action { color: #1e3a8a; padding: 5px 10px; transition: 0.3s; }
        .btn-action:hover { color: #0056b3; background: #eef2ff; border-radius: 4px; }
        .badge-specialty { background: #eef2ff; color: #1e3a8a; padding: 5px 10px; border-radius: 15px; font-weight: 600; }
    </style>
</head>
<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Manage Doctors</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Manage Doctors</span></li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw bg-white panel-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Current <span class="text-bold">Doctor List</span></h5>
                                <p style="color:green;"><?php echo htmlentities($_SESSION['msg']); $_SESSION['msg']="";?></p>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover" id="sample-table-1">
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>Specialization</th>
                                                <th>Doctor Name</th>
                                                <th>Creation Date</th>
                                                <th class="center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = mysqli_query($con, "select * from doctors");
                                            $cnt = 1;
                                            while($row = mysqli_fetch_array($sql)) {
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $cnt;?>.</td>
                                                <td><span class="badge-specialty"><?php echo $row['specilization'];?></span></td>
                                                <td style="font-weight: 600;"><?php echo $row['doctorName'];?></td>
                                                <td><?php echo $row['creationDate'];?></td>
                                                <td class="center">
                                                    <a href="edit-doctor.php?id=<?php echo $row['id'];?>" class="btn-action" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a href="manage-doctors.php?id=<?php echo $row['id']?>&del=delete" onClick="return confirm('Are you sure?')" class="btn-action" title="Remove"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                            <?php $cnt++; } ?>
                                        </tbody>
                                    </table>
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