<?php
session_start();
error_reporting(0);
include('include/config.php');
include('include/checklogin.php');
check_login();

// Get the search term from the query string
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

// SQL query to search appointments by doctor name, patient name, or status
$sql = "
    SELECT doctors.doctorName AS docname, 
           users.username AS pname, 
           appointments.*  
    FROM appointments 
    JOIN doctors ON doctors.id = appointments.doctorId 
    JOIN users ON users.id = appointments.userId
    WHERE doctors.doctorName LIKE '%$search%' 
       OR users.username LIKE '%$search%' 
       OR appointments.status LIKE '%$search%'
";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Results | CHMSU Clinic Management System</title>
    <!-- Add your CSS and other head content here -->
</head>
<body>
    <div class="container">
        <h1>Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="center">#</th>
                    <th>Doctor Name</th>
                    <th>Patient Name</th>
                    <th>Course/Year</th>
                    <th>Age</th>
                    <th>Sex</th>
                    <th>Status</th>
                    <th>Appointment Date / Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td class='center'>$cnt.</td>";
                        echo "<td>{$row['docname']}</td>";
                        echo "<td>{$row['pname']}</td>";
                        echo "<td>{$row['course_year']}</td>";
                        echo "<td>{$row['age']}</td>";
                        echo "<td>{$row['sex']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>{$row['check_up_date']} / {$row['check_up_time']}</td>";
                        echo "<td><a href='manage-patient.php?id={$row['id']}' class='btn btn-primary'>View Details</a></td>";
                        echo "</tr>";
                        $cnt++;
                    }
                } else {
                    echo "<tr><td colspan='9'>No results found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
