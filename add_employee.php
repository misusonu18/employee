<?php

include 'layouts/header.php';
include 'config/database.php';

if (isset($_POST['add_employee'])) {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $address = $_POST['address'];

    $file_name = date('dmYHis').str_replace(" ", "", basename($_FILES["employee_image"]["name"]));
    move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$file_name);
    $insertEmployee = "INSERT INTO employee (id,first_name,last_name,email,address,photo) VALUES(0,'$firstName', '$lastName', '$email', '$address', '$file_name')";
    if (!$result = mysqli_query($connection, $insertEmployee)) {
        mysqli_error($connection);
        echo "SomeThing Wrong";
    } else {
        header('location:index.php');
    }
}
?>
<div class="container-fluid">
    <h1 class="mt-4">Employee</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Employees / Add</li>
    </ol>
    <div class="row">
        <div class="col">
            <div class="card mt-5 border-0">
                <form action="add_employee.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>First Name</label>
                        <div class="input-group">
                            <input
                                type="text"
                                name="first_name"
                                id="first-name"
                                class="form-control"
                                placeholder="First Name"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Last Name</label>
                        <div class="input-group">
                            <input
                                type="text"
                                name="last_name"
                                id="last-name"
                                class="form-control"
                                placeholder="Last Name"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                placeholder="Email"
                                required
                            >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <div class="input-group">
                            <textarea name="address"
                                id="address"
                                class="form-control"
                                placeholder="Address"
                                required
                            ></textarea>
                        </div>
                    </div>

                    <div class="custom-file">
                        <input type="file"
                            class="custom-file-input"
                            name="employee_image"
                            id="employee-photo"
                            required
                        >
                        <label class="custom-file-label" for="employee-photo">Choose Photo</label>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <input
                                type="submit"
                                name="add_employee"
                                id="add_employee"
                                class="btn btn-primary mt-3"
                            >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

include 'layouts/footer.php';
