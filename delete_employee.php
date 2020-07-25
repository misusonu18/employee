<?php

include "layouts/header.php";
include 'config/database.php';

$employeeId = $_POST['employee_id'];
$getEmployee = mysqli_query($connection, 'SELECT * FROM employee WHERE id = "'.$employeeId.'"');
$record = mysqli_fetch_assoc($getEmployee);

if (file_exists("images/".$record['photo'])) {
    $delete = mysqli_query($connection, "DELETE FROM employee WHERE id='$employeeId'");
    unlink("images/".$record['photo']);
} else {
    $delete = "notSuccess";
}

include "layouts/footer.php";
