<?php

include "layouts/header.php";
include "config/database.php";
?>
<div class="text-right mb-2 pr-4">
    <a href="add_employee.php" class="btn btn-sm btn-primary">
        <i class="fa fa-user-plus"></i>
    </a>
</div>
<div class="table-responsive pr-4 pl-4">
    <table class="table table-bordered" id="employee-table" width="100%" cellspacing="0">
        <thead>
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
                <td><?php echo $result['first_name'] ?></td>
                <td><?php echo $result['last_name'] ?></td>
                <td><?php echo $result['email'] ?></td>
                <td><?php echo $result['address'] ?></td>
                <td><img src='<?php echo "images/" . $result['photo'] ?>' style='width:100px'> </td>
                <td>
                    <a href="edit_employee.php?employee_id=<?php echo $result['id']?>" class="btn btn-sm btn-info">
                        <i class="fa fa-edit"></i>
                    </a>

                    <form action="delete_employee.php"
                        onsubmit="return confirm('Do you really want to delete the Employee?');"
                        method="POST"
                    >
                        <button
                            value="<?php echo $result['id'] ?>"
                            name="employee_id"
                            class="btn btn-danger btn-sm"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<?php

include "layouts/footer.php";
