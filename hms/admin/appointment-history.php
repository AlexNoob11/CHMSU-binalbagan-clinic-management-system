<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Handle AJAX Request
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($con, $_POST['search']);
    $query = "SELECT id, fullname, course_year, age, sex, contact_number, status, created_at 
              FROM appointments
              WHERE fullname LIKE '%$search%' 
                 OR course_year LIKE '%$search%' 
                 OR contact_number LIKE '%$search%'";
    $result = mysqli_query($con, $query);
    
    $cnt = 1;
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $btnClass = ($row['status'] == 'Completed') ? 'btn-info' : 'btn-primary';
            $btnText = ($row['status'] == 'Completed') ? 'Update Schedule' : 'View';
            echo "<tr>
                    <td class='center'>{$cnt}</td>
                    <td>{$row['fullname']}</td>
                    <td>{$row['course_year']}</td>
                    <td>{$row['age']}</td>
                    <td>{$row['sex']}</td>
                    <td>{$row['contact_number']}</td>
                    <td><span class='label label-inverse'>{$row['status']}</span></td>
                    <td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>
                    <td>
                        <a href='view-appointment.php?id={$row['id']}' class='btn {$btnClass} btn-xs'>{$btnText}</a>
                        " . ($row['status'] != 'Completed' ? "<a href='edit-appointment.php?id={$row['id']}' class='btn btn-warning btn-xs'>Edit</a>" : "") . "
                    </td>
                  </tr>";
            $cnt++;
        }
    } else {
        echo "<tr><td colspan='9' class='text-center'>No records found</td></tr>";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical Staff | Appointment History</title>
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
        .search-wrapper { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #1e3a8a; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        #search { height: 45px; border-radius: 6px; border: 1px solid #cbd5e1; }
        .table thead { background-color: #ffffff; color: #fff; }
        .table > thead > tr > th { text-align: center; border-bottom: none; }
        .label-inverse { background-color: #34495e; }
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
                                <h1 class="mainTitle">Medical | Appointment History</h1>
                            </div>
                        </div>
                    </section>

                    <div class="search-wrapper">
                        <input type="text" id="search" class="form-control" placeholder="🔍 Search by name, course, or contact number..." />
                    </div>
                    
                    <div class="container-fluid container-fullw bg-white" style="border-radius: 8px;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Course/Year</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="appointment-table">
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php include('include/footer.php'); ?>
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
        $(document).ready(function(){
            // Initial Load
            function loadData(query = '') {
                $.ajax({
                    url: '', 
                    method: 'POST',
                    data: {search: query},
                    success: function(data) { $('#appointment-table').html(data); }
                });
            }
            loadData(); // Load all on start
            
            $("#search").on("input", function() {
                loadData($(this).val());
            });
        });
        jQuery(document).ready(function() { Main.init(); });
    </script>
</body>
</html>