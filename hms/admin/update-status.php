<?php
include('include/config.php');

if(isset($_GET['id']) && isset($_GET['status'])){
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update the status in the database
    $sql = "UPDATE appointments SET status = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Appointment status updated successfully!";
    } else {
        $_SESSION['msg'] = "Error updating status.";
    }

    // Redirect back to the appointments page
    header('location: appointments.php');
    exit();
}
?>
