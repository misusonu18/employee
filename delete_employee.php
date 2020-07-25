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
    $delete = "error";
}

include "layouts/footer.php";

    if (isset($delete)) {
        echo "
            <script type='text/javascript'>
                alertify.notify('Delete Successfully', 'success', 1, function(){
                    window.location.href='index.php';
                });
            </script>
        ";
    } else {
        echo "
            <script type='text/javascript'>
                alertify.notify('Something Went Wrong', 'error', 1, function(){
                    window.location.href='index.php';
                });
            </script>
        ";
    }
