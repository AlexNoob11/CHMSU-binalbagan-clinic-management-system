<?php
session_start();
include('include/config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];
$alertMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle feedback submission
    $rating = mysqli_real_escape_string($con, $_POST['rating']);
    $comments = mysqli_real_escape_string($con, $_POST['comments']);
    $overall_experience = mysqli_real_escape_string($con, $_POST['overall_experience']);
    $ease_of_use = mysqli_real_escape_string($con, $_POST['ease_of_use']);
    $service_quality = mysqli_real_escape_string($con, $_POST['service_quality']);

    $query = "INSERT INTO feedback (userId, rating, comments, overall_experience, ease_of_use, service_quality, created_at) 
              VALUES ('$userId', '$rating', '$comments', '$overall_experience', '$ease_of_use', '$service_quality', NOW())";

    if (mysqli_query($con, $query)) {
        $alertMessage = "<div class='alert alert-success' style='border-radius: 8px;'><i class='fa fa-check-circle'></i> Thank you for your feedback!</div>";
    } else {
        $alertMessage = "<div class='alert alert-danger' style='border-radius: 8px;'><i class='fa fa-exclamation-triangle'></i> Failed to submit feedback. Please try again later.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User | Feedback Survey</title>
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
        
        /* Dashboard Form Alignment Fix */
        .main-content {
            padding-top: 20px !important;
        }

        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #edf2f9;
            margin-bottom: 30px;
        }

        .section-header-custom {
            font-size: 20px;
            font-weight: 600;
            color: #34495e;
            margin-top: 0;
            margin-bottom: 25px;
            border-bottom: 2px solid #f1f3f5;
            padding-bottom: 12px;
        }

        .form-group label {
            font-size: 12px;
            text-transform: uppercase;
            color: #7f8c8d;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #dcdde1;
            padding: 10px 14px;
            height: auto;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
        }

        .btn-submit-custom {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 6px;
            border: none;
            transition: background 0.2s ease;
        }

        .btn-submit-custom:hover {
            background-color: #111827;
            color: #ffffff;
        }
    </style>
</head>
<body>
<div id="app">        
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>

        <div class="main-content">
            <div class="wrap-content container" id="container">
                <section id="page-title" style="padding: 25px 0; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Feedback Survey</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>User</span></li>
                            <li class="active"><span>Submit Feedback</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            
                            <?php if (!empty($alertMessage)) echo $alertMessage; ?>

                            <div class="form-card">
                                <h2 class="section-header-custom"><i class="fa fa-comments-o" style="margin-right: 8px; color: #1e3a8a;"></i> Your Feedback Matters</h2>
                                
                                <form action="" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="rating">General Rating</label>
                                                <select class="form-control" id="rating" name="rating" required>
                                                    <option value="">Select Rating</option>
                                                    <option value="5">5 - Excellent</option>
                                                    <option value="4">4 - Very Good</option>
                                                    <option value="3">3 - Good</option>
                                                    <option value="2">2 - Fair</option>
                                                    <option value="1">1 - Poor</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="overall_experience">Overall Experience</label>
                                                <select class="form-control" id="overall_experience" name="overall_experience" required>
                                                    <option value="">Select Rating</option>
                                                    <option value="5">5 - Excellent</option>
                                                    <option value="4">4 - Very Good</option>
                                                    <option value="3">3 - Good</option>
                                                    <option value="2">2 - Fair</option>
                                                    <option value="1">1 - Poor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ease_of_use">Ease of Use</label>
                                                <select class="form-control" id="ease_of_use" name="ease_of_use" required>
                                                    <option value="">Select Rating</option>
                                                    <option value="5">5 - Excellent</option>
                                                    <option value="4">4 - Very Good</option>
                                                    <option value="3">3 - Good</option>
                                                    <option value="2">2 - Fair</option>
                                                    <option value="1">1 - Poor</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="service_quality">Service Quality</label>
                                                <select class="form-control" id="service_quality" name="service_quality" required>
                                                    <option value="">Select Rating</option>
                                                    <option value="5">5 - Excellent</option>
                                                    <option value="4">4 - Very Good</option>
                                                    <option value="3">3 - Good</option>
                                                    <option value="2">2 - Fair</option>
                                                    <option value="1">1 - Poor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="comments">Comments & Suggestions</label>
                                        <textarea class="form-control" id="comments" name="comments" rows="5" placeholder="Please share your experience or any areas of improvement with us..." required></textarea>
                                    </div>

                                    <div class="form-group style-submit text-center" style="margin-top: 25px; margin-bottom: 0;">
                                        <button type="submit" class="btn-submit-custom">
                                            Submit Feedback <i class="fa fa-paper-plane" style="margin-left: 5px; font-size: 11px;"></i>
                                        </button>
                                    </div>
                                </form>
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
<script src="assets/js/form-elements.js"></script>
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>
</body>
</html>