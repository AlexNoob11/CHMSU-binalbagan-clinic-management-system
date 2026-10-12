<?php
// Start the session
session_start();

// Include the database configuration
include("include/config.php");

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login-user.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize it
    $userId = $_SESSION['user_id']; // The user ID from session
    $patientName = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $chiefComplaints = mysqli_real_escape_string($conn, $_POST['chief_complaints']);
    $history = mysqli_real_escape_string($conn, $_POST['history']);
    $evaluation = mysqli_real_escape_string($conn, $_POST['evaluation']);
    
    // Insert data into the referrals table
    $query = "INSERT INTO referrals (user_id, patient_name, age, sex, chief_complaints, history, evaluation, status) 
              VALUES ('$userId', '$patientName', '$age', '$sex', '$chiefComplaints', '$history', '$evaluation', 'Pending')";
    
    if (mysqli_query($conn, $query)) {
        // Referral request was successfully inserted
        $_SESSION['success'] = "Referral request submitted successfully!";
        header("Location: dashboard.php"); // Redirect to user dashboard or another page
        exit();
    } else {
        // Failed to insert the referral request
        $_SESSION['error'] = "Failed to submit referral request. Please try again.";
        header("Location: referral-request.php"); // Redirect back to the referral page with an error message
        exit();
    }
} else {
    // If form is not submitted, redirect back to the referral page
    header("Location: referral-request.php");
    exit();
}
?>
