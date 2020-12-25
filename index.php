<?php
include "layouts/header.php";
include "config/database.php";
session_start();

if (isset($_POST['delete_employee_id'])) {
    $employeeId = $_POST['delete_employee_id'];
    $getEmployee = mysqli_query($connection, 'SELECT * FROM employee WHERE id = "'.$employeeId.'"');
    $record = mysqli_fetch_assoc($getEmployee);

    $delete = mysqli_query($connection, "DELETE FROM employee WHERE id='$employeeId'");
    
    if (file_exists("images/".$record['photo'])) {
        unlink("images/".$record['photo']);
    }

    if ($delete == true) {
        $_SESSION['ErrorMessage']['success'] = 'Employee Deleted Successfully';
        session_write_close(); 
        header('location:index.php');
    } else {
        $_SESSION['ErrorMessage']['error'] = 'Something Went Wrong';
        session_write_close(); 
        header('location:index.php');
    }
}
?>
<div class="text-right mb-2 pr-4">
    <a href="add_employee.php" class="btn btn-sm btn-primary" title="Add Employee">
        <i class="fa fa-user-plus"></i>
    </a>
</div>

<div class="table-responsive pr-4 pl-4">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead class="thead-dark">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $results = mysqli_query($connection, 'SELECT * FROM employee');
                foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['first_name']; ?></td>
                <td><?php echo $result['last_name']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><?php echo $result['address']; ?></td>
                <td class="text-center"><img src='<?php echo "images/" . $result['photo']; ?>' style='width:100px'> </td>
                <td>
                    <div class="d-flex justify-content-around">
                        <a href="edit_employee.php?employee_id=<?php echo $result['id']; ?>"
                            title="Edit Employee"
                            class="btn btn-sm btn-warning"
                            data-cy="edit-<?php echo $result['id']; ?>"
                        >
                            <i class="fa fa-edit"></i>
                        </a>

                        <form id="delete-employee-form" 
                            onclick="confirmation(<?php echo $result['id']; ?>);" 
                            method="post"
                            data-cy="delete-<?php echo $result['id']; ?>"
                        >
                            <input type="hidden" name="delete_employee_id" id="delete-employee-id">
                            <button type="button" title="Delete Employee" class="btn btn-danger btn-sm" >
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php
            }
                if (mysqli_num_rows($results) <= 0) {
                ?>
                    <tr>
                        <td colspan="6" class="text-center">No Records Found</tr>
                    </tr>
                <?php
                }
            ?>
        </tbody>
    </table>
</div>

<?php
include "layouts/footer.php";

if (isset($_SESSION['ErrorMessage']['success'])) {
    echo "
        <script type='text/javascript'>
            alertify.success('".$_SESSION['ErrorMessage']['success']."');
        </script>
    ";
    unset($_SESSION['ErrorMessage']['success']);
} elseif (isset($_SESSION['ErrorMessage']['error'])) {
    echo "
        <script type='text/javascript'>
            alertify.danger('".$_SESSION['ErrorMessage']['error']."');
        </script>
    ";
}
?>

<script>
    function confirmation(employeeId) {
        alertify.confirm("Delete Employee", "Do You Really Want To Delete Employee?", function (e) {
            event.preventDefault();
            if (e) {
                document.getElementById('delete-employee-id').setAttribute('value', employeeId);
                document.getElementById("delete-employee-form").submit();
                return true;
            } else {
                return false;
            }
        },
            function () {}
        );
    }
</script>
