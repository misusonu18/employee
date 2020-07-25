<?php

include 'layouts/header.php';
include 'config/database.php';
session_start();

if (isset($_POST['add_employee'])) {
    if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['address'])) {
        if (empty($_POST['first_name'])) {
            $_SESSION['ErrorMessage']['first_name'] = "<font style='color:red;' font-size:16px;>First Name Required</font>";
        }

        if (empty($_POST['last_name'])) {
            $_SESSION['ErrorMessage']['last_name'] = "<font style='color:red;' font-size:16px;>Last Name Required</font>";
        }

        if (empty($_POST['email'])) {
            $_SESSION['ErrorMessage']['email'] = "<font style='color:red;' font-size:16px;>Email Address Required</font>";
        }

        if (empty($_POST['address'])) {
            $_SESSION['ErrorMessage']['address'] = "<font style='color:red;' font-size:16px;>Address Required</font>";
        }
    } else {
        $firstName = mysqli_real_escape_string($connection, $_POST['first_name']);
        $lastName = mysqli_real_escape_string($connection, $_POST['last_name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);

        $fileName = date('dmYHis').str_replace(" ", "", basename($_FILES["employee_image"]["name"]));
        move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$fileName);
        $insertEmployee = "INSERT INTO employee (first_name,last_name,email,address,photo) VALUES('$firstName', '$lastName', '$email', '$address', '$fileName')";
        if ($insert = mysqli_query($connection, $insertEmployee)) {
            $insert = "success";
        } else {
            $insert = "error";
        }
    }
}
?>
<div class="row pr-4 pl-4">
    <div class="col">
        <div class="card mt-5 border-0">
            <form method="post" enctype="multipart/form-data">
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
                    <?php
                        echo isset($_SESSION['ErrorMessage']['first_name']) ? $_SESSION['ErrorMessage']['first_name'] : "";
                        unset($_SESSION['ErrorMessage']['first_name']);
                    ?>
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
                    <?php
                        echo isset($_SESSION['ErrorMessage']['last_name']) ? $_SESSION['ErrorMessage']['last_name'] : "";
                        unset($_SESSION['ErrorMessage']['last_name']);
                    ?>
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
                    <?php
                        echo isset($_SESSION['ErrorMessage']['email']) ? $_SESSION['ErrorMessage']['email'] : "";
                        unset($_SESSION['ErrorMessage']['email']);
                    ?>
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
                    <?php
                        echo isset($_SESSION['ErrorMessage']['address']) ? $_SESSION['ErrorMessage']['address'] : "";
                        unset($_SESSION['ErrorMessage']['address']);
                    ?>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="file"
                            name="employee_image"
                            id="employee-photo"
                            required
                        >
                    </div>
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
<?php

include 'layouts/footer.php';

    if (isset($insert) && $insert === "success") {
        echo "
            <script type='text/javascript'>
                alertify.notify('Insert Successfully', 'success', 1, function(){
                    window.location.href='index.php';
                });
            </script>
        ";
    } elseif (isset($insert) && $insert === "error") {
        echo "
            <script type='text/javascript'>
                alertify.notify('Something Went Wrong', 'error', 1, function(){
                    window.location.href='index.php';
                });
            </script>
        ";
    }
