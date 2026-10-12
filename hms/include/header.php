<?php 
error_reporting(0); 

// Use the user_id from the session variable
$userId = $_SESSION['user_id']; 

// Query to fetch the number of appointments with a set check-up date and time
$query = mysqli_query($con, "SELECT COUNT(*) as notifications FROM appointments WHERE userId = '$userId' AND check_up_date IS NOT NULL AND check_up_time IS NOT NULL AND status = 'Completed'");

$notificationCount = 0;
$appointments = [];
if ($row = mysqli_fetch_assoc($query)) {
    $notificationCount = $row['notifications']; 

    // Fetch all pending appointments with check-up date and time
    $appointmentsQuery = mysqli_query($con, "SELECT * FROM appointments WHERE userId = '$userId' AND check_up_date IS NOT NULL AND check_up_time IS NOT NULL AND status = 'Completed'");
    
    while ($appointment = mysqli_fetch_assoc($appointmentsQuery)) {
        $appointments[] = $appointment;
    }
}
?>

<header class="navbar navbar-default navbar-static-top" style="z-index: 1050;">
    <div class="navbar-header">
        <a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
            <i class="ti-align-justify"></i>
        </a>
        <a class="navbar-brand" href="dashboard.php">
            <h2 style="padding-top:20%; font-size:24px; font-weight:bold; margin:0;">HOME</h2>
        </a>
        <a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
            <i class="ti-align-justify"></i>
        </a>
        <a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <i class="ti-view-grid"></i>
        </a>
    </div>

    <div class="navbar-collapse collapse">
        <ul class="nav navbar-right" style="display: flex; align-items: center; margin-right: 0; padding-right: 15px; height: 65px;">
            <li class="hidden-xs hidden-sm" style="display: inline-flex; align-items: center; margin-right: 25px;">
                <img src="images/CHMSUWeb.png" alt="Logo" style="height: 40px; margin-right: 10px;">
                <h2 style="margin: 0; font-size: 20px; font-weight: bold; color: #2c3e50;">CHMSU Binalbagan Center Clinic Management System</h2>
            </li>

            <li class="dropdown" style="position: relative; z-index: 9999; display: flex; align-items: center; height: 100%;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" id="notificationBell" onclick="showAlert()" style="padding: 15px 12px; display: inline-block; position: relative;">
                    <i class="ti-bell" style="color: black; font-size: 20px;"></i> 
                    <?php if ($notificationCount > 0): ?>
                        <span class="badge" style="position: absolute; top: 5px; right: 0; font-size: 11px; background-color: #e74c3c; color: white; padding: 3px 7px; border-radius: 10px; font-weight: bold; border: 2px solid #fff;"><?php echo $notificationCount; ?></span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-dark pull-right" style="max-height: 300px; overflow-y: auto; padding: 10px; background-color: #2c3e50; right: 0; left: auto; margin-top: 0;">
                    <?php if ($notificationCount > 0): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <li style="padding: 15px; font-size: 18px; cursor: pointer; border-bottom: 1px solid #ddd;">
                                <a href="medical-history.php?id=<?php echo $appointment['id']; ?>" style="display: block; color: white; font-size: 16px;">
                                    <?php echo "Your appointment is scheduled for " . date("F j, Y", strtotime($appointment['check_up_date'])) . " at " . date("g:i A", strtotime($appointment['check_up_time'])); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li style="padding: 15px; font-size: 16px; color: #999; text-align: center; min-width: 200px;">No upcoming appointments</li>
                    <?php endif; ?>
                </ul>
            </li>

            <li class="dropdown current-user" style="position: relative; z-index: 9999; display: flex; align-items: center; height: 100%; margin-left: 10px;">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" style="padding: 15px 5px; display: flex; align-items: center; gap: 8px;">
                    <img src="assets/images/default-user.png" alt="User Image" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;"> 
                    <span class="username" style="color: black; font-weight: 600; font-size: 14px; display: inline-block; vertical-align: middle;">
                        <?php 
                        echo isset($_SESSION['patient_type']) ? ucfirst(htmlspecialchars($_SESSION['patient_type'])) : 'User';
                        ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-dark pull-right" style="background-color: #2c3e50; right: 0; left: auto; margin-top: 0;">
                    <li><a href="edit-profile.php" style="color: white; padding: 10px 20px;">My Profile</a></li>
                    <li><a href="change-password.php" style="color: white; padding: 10px 20px;">Change Password</a></li>
                    <li class="divider" style="height: 1px; margin: 5px 0; background-color: #34495e;"></li>
                    <li><a href="logout.php" style="color: white; font-weight: bold; padding: 10px 20px;">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>

<script type="text/javascript">
    function showAlert() {
        <?php if ($notificationCount > 0): ?>
            alert("You have <?php echo $notificationCount; ?> upcoming appointment(s) scheduled!");
        <?php endif; ?>
    }
</script>