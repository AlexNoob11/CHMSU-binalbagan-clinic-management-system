<?php
function check_login()
{
    session_start();
    
    // Ensure admin or doctor session exists
    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['doctor_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>
