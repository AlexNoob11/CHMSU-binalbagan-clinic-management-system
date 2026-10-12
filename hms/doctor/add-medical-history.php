<?php
session_start();
error_reporting(0);
include('include/config.php');

// Ensure the doctor is logged in
if (!isset($_SESSION['doctor_id'])) {
    header('location:logout.php');
    exit();
}

// Get the appointment ID from the URL
$appointment_id = $_GET['id'];

// Fetch appointment details
$query = "SELECT * FROM appointments WHERE id = '$appointment_id'";
$result = mysqli_query($con, $query);

if ($row = mysqli_fetch_array($result)) {
    // Appointment details
    $fullname = $row['fullname'];
    $course_year = $row['course_year'];
    $birthdate = $row['birthdate'];
    $age = $row['age'];
    $sex = $row['sex'];
    $civil_status = $row['civil_status'];
    $weight = $row['weight'];
    $bloodtype = $row['bloodtype'];
    $religion = $row['religion'];
    $address = $row['address'];
    $contact_number = $row['contact_number'];
    $father_name = $row['father_name'];
    $father_occupation = $row['father_occupation'];
    $mother_name = $row['mother_name'];
    $mother_occupation = $row['mother_occupation'];
    $num_children = $row['num_children'];
    $emergency_contact_name = $row['emergency_contact_name'];
    $emergency_contact_relation = $row['emergency_contact_relation'];
    $emergency_contact_number = $row['emergency_contact_number'];
    $check_up_date = $row['check_up_date'];
    $check_up_time = $row['check_up_time'];
} else {
    echo "No appointment found!";
    exit();
}

// Process the form if submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medical_history = $_POST['medical_history'];

    // Save the medical history
    $update_query = "UPDATE appointments SET medical_history = '$medical_history' WHERE id = '$appointment_id'";
    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        echo "<script>alert('Medical history added successfully.'); window.location='appointment-history.php';</script>";
    } else {
        echo "<script>alert('Error adding medical history.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Medical History | Doctor</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Add Medical History for <?php echo $fullname; ?></h2>
        <form method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" value="<?php echo $fullname; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="course_year">Course/Year</label>
                <input type="text" class="form-control" id="course_year" value="<?php echo $course_year; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="text" class="form-control" id="birthdate" value="<?php echo $birthdate; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="age">Age</label>
                <input type="text" class="form-control" id="age" value="<?php echo $age; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="sex">Sex</label>
                <input type="text" class="form-control" id="sex" value="<?php echo $sex; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="civil_status">Civil Status</label>
                <input type="text" class="form-control" id="civil_status" value="<?php echo $civil_status; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" class="form-control" id="weight" value="<?php echo $weight; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="bloodtype">Blood Type</label>
                <input type="text" class="form-control" id="bloodtype" value="<?php echo $bloodtype; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="religion">Religion</label>
                <input type="text" class="form-control" id="religion" value="<?php echo $religion; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" value="<?php echo $address; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="contact_number">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" value="<?php echo $contact_number; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="father_name">Father's Name</label>
                <input type="text" class="form-control" id="father_name" value="<?php echo $father_name; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="father_occupation">Father's Occupation</label>
                <input type="text" class="form-control" id="father_occupation" value="<?php echo $father_occupation; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="mother_name">Mother's Name</label>
                <input type="text" class="form-control" id="mother_name" value="<?php echo $mother_name; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="mother_occupation">Mother's Occupation</label>
                <input type="text" class="form-control" id="mother_occupation" value="<?php echo $mother_occupation; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="num_children">Number of Children</label>
                <input type="text" class="form-control" id="num_children" value="<?php echo $num_children; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="emergency_contact_name">Emergency Contact Name</label>
                <input type="text" class="form-control" id="emergency_contact_name" value="<?php echo $emergency_contact_name; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="emergency_contact_relation">Emergency Contact Relation</label>
                <input type="text" class="form-control" id="emergency_contact_relation" value="<?php echo $emergency_contact_relation; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="emergency_contact_number">Emergency Contact Number</label>
                <input type="text" class="form-control" id="emergency_contact_number" value="<?php echo $emergency_contact_number; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="check_up_date">Check-up Date</label>
                <input type="text" class="form-control" id="check_up_date" value="<?php echo $check_up_date; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="check_up_time">Check-up Time</label>
                <input type="text" class="form-control" id="check_up_time" value="<?php echo $check_up_time; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="medical_history">Medical History</label>
                <textarea class="form-control" id="medical_history" name="medical_history" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-success">Save Medical History</button>
            <a href="appointment-history.php" class="btn btn-primary">Back to Appointment History</a>
        </form>
    </div>
</body>
</html>
