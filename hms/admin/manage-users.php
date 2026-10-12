<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

if(isset($_GET['del']))
{
    $id = mysqli_real_escape_string($con, $_GET['id']);
    mysqli_query($con,"delete from users where id = '$id'");
    $_SESSION['msg']="Data deleted successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Manage Users</title>
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
            background-color: #f8fafc; 
            font-family: 'Raleway', sans-serif; 
        }
        .mainTitle { 
            color: #1e293b; 
            font-weight: 700; 
        }
        .card-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            padding: 24px;
            margin-top: 10px;
            border: 1px solid #e2e8f0;
        }
        .custom-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        .custom-table thead th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
            border-top: none;
        }
        .custom-table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            font-size: 13px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
        }
        .custom-table tbody tr:hover {
            background-color: #f8fafc;
        }
        /* Custom Badge Formatting */
        .badge-patient {
            background-color: #e0f2fe;
            color: #0369a1;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
        }
        /* Requested Theme Color styling (#1e3a8a) for elements/actions */
        .text-theme {
            color: #1e3a8a;
        }
        .btn-danger-soft { 
            background-color: #fef2f2; 
            color: #ef4444; 
            border: 1px solid #fee2e2; 
            padding: 7px 12px; 
            border-radius: 6px; 
            transition: all 0.2s ease-in-out;
        }
        .btn-danger-soft:hover { 
            background-color: #ef4444; 
            color: #ffffff; 
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }
        .fw-medium { font-weight: 500; }
    </style>
</head>
<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">Admin | Manage Users</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Admin</span></li>
                                <li class="active"><span>Manage Users</span></li>
                            </ol>
                        </div>
                    </section>

                    <div class="container-fluid container-fullw">
                        <div class="row">
                            <div class="col-md-12">
                                
                                <div class="card-container">
                                    <h5 class="over-title margin-bottom-20 fw-medium" style="color: #334155;">Registered User System Database</h5>
                                    
                                    <?php if($_SESSION['msg']){ ?>
                                        <div class="alert alert-success border-0" style="background-color: #dcfce7; color: #166534; border-radius: 8px;">
                                            <i class="fa fa-check-circle"></i> <?php echo htmlentities($_SESSION['msg']); $_SESSION['msg']="";?>
                                        </div>
                                    <?php } ?>
                                    
                                    <div class="table-responsive">
                                        <table class="table custom-table" id="sample-table-1">
                                            <thead>
                                                <tr>
                                                    <th class="center" style="width: 80px;">Index</th>
                                                    <th>Username</th>
                                                    <th>Email Address</th>
                                                    <th>Patient Classification</th>
                                                    <th>Registration Date</th>
                                                    <th class="center" style="width: 100px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $sql=mysqli_query($con,"select * from users");
                                            $cnt=1;
                                            while($row=mysqli_fetch_array($sql))
                                            {
                                            ?>
                                                <tr>
                                                    <td class="center fw-medium"><?php echo $cnt;?>.</td>
                                                    <td class="fw-medium text-dark"><?php echo htmlspecialchars($row['username']);?></td>
                                                    <td><?php echo htmlspecialchars($row['email']);?></td>
                                                    <td><span class="badge-patient"><?php echo htmlspecialchars($row['patient_type']);?></span></td>
                                                    <td><?php echo htmlspecialchars($row['created_at']);?></td>
                                                    <td class="center">
                                                        <a href="manage-users.php?id=<?php echo $row['id']?>&del=delete" 
                                                           onClick="return confirm('Are you sure you want to delete this user?')" 
                                                           class="btn btn-danger-soft btn-sm">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
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