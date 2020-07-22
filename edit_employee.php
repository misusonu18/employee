<?php

include 'layouts/header.php';
include 'config/database.php';

if (isset($_GET['employee_id'])) {
    $id = $_GET['employee_id'];
    $getEmployee = mysqli_query($connection, 'select * from employee where id="'.$id.'"');
    $record = mysqli_fetch_assoc($getEmployee);
}

if (isset($_POST['edit_employee'])) {
    $id = $_POST['employee_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $image = $_POST['image'];

    if (!empty($_FILES['employee_image']['name'])) {
        if (file_exists("images/".$image)) {
            $file_path = date('dmYHis').str_replace(" ", "", basename($_FILES["employee_image"]["name"]));
            move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$file_path);
            $updateQuery = 'update employee set first_name="'.$firstName.'", last_name="'.$lastName.'", email="'.$email.'", address="'.$address.'",photo="'.$file_path.'" where id="'.$id.'"';
            $update = mysqli_query($connection, $updateQuery);
            unlink("images/".$image);
            header('location:index.php');
        }
    } else {
        if (file_exists("images/".$image)) {
            $updateQuery = 'update employee set first_name="'.$firstName.'", last_name="'.$lastName.'", email="'.$email.'", address="'.$address.'" where id="'.$id.'"';
            $update = mysqli_query($connection, $updateQuery);
            header('location:index.php');
        }
    }
}


?>
<div class="container-fluid">
    <h1 class="mt-4">Employee</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Employees / Edit</li>
    </ol>
    <div class="row">
        <div class="col">
            <form action="edit_employee.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>First Name</label>
                    <div class="input-group">
                        <input type="text"
                            name="first_name"
                            id="first-name"
                            class="form-control"
                            placeholder="First Name"
                            value="<?php echo $record['first_name'] ?>"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <div class="input-group">
                        <input type="text"
                            name="last_name"
                            id="last-name"
                            class="form-control"
                            placeholder="Last Name"
                            value="<?php echo $record['last_name'] ?>"
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Email"
                        value="<?php echo $record['email'] ?>"
                        required
                    >
                    </div>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <div class="input-group">
                        <input type="text"
                            name="address"
                            id="address"
                            class="form-control"
                            placeholder="Address"
                            value="<?php echo $record['address'] ?>"
                            required
                        >
                    </div>
                </div>

                <div class="row col justify-content-between">
                    <div class="form-group">
                        <input type="file" name="employee_image">
                        <input type="hidden" name="image" value="<?php echo $record['photo'] ?>">
                    </div>

                    <div>
                        <img src="<?php echo "images/".$record['photo']?>" alt="Employee photo" style='width:100px'>
                    </div>
                </div>

                <div class="input-group">
                    <input type="hidden" name="employee_id" value="<?php echo $record['id'] ?>">
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="submit"
                            name="edit_employee"
                            id="edit-employee"
                            class="btn btn-warning"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

include 'layouts/footer.php';
