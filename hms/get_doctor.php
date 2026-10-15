<?php
include('include/config.php');

if (!empty($_POST["specilizationid"])) {
    $specilizationid = mysqli_real_escape_string($con, $_POST['specilizationid']);
    $sql = mysqli_query($con, "SELECT doctorName, id FROM doctors WHERE specilization = '$specilizationid'");
?>
    <option selected="selected">Select Doctor</option>
<?php
    while ($row = mysqli_fetch_array($sql)) {
?>
    <option value="<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['doctorName']); ?></option>
<?php
    }
}

if (!empty($_POST["doctor"])) {
    $doctor = mysqli_real_escape_string($con, $_POST['doctor']);
    $sql = mysqli_query($con, "SELECT docFees FROM doctors WHERE id = '$doctor'");
    while ($row = mysqli_fetch_array($sql)) {
?>
    <option value="<?php echo htmlentities($row['docFees']); ?>"><?php echo htmlentities($row['docFees']); ?></option>
<?php
    }
}
?>
