<?php

include 'layouts/header.php';
include 'config/database.php';
session_start();

if (isset($_POST['add_employee'])) {
    if (empty($_POST['first_name']) ||
        empty($_POST['last_name']) ||
        empty($_POST['email']) ||
        empty($_POST['address']) ||
        empty($_FILES['employee_image']['name'])
        ) {
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

        if (empty($_FILES['employee_image']['name'])) {
            $_SESSION['ErrorMessage']['employee_image'] = "<font style='color:red;' font-size:16px;>Image Required</font>";
        }
    } else {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $fileName = rand(1, 99999).str_replace(" ", "", basename($_FILES["employee_image"]["name"]));
        move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$fileName);

        if ($insert = mysqli_query(
            $connection,
            "INSERT INTO employee (first_name,last_name,email,address,photo) VALUES('$firstName', '$lastName', '$email', '$address', '$fileName')"
        )) {
            $insert = "success";
        } else {
            $insert = "error";
        }
    }
}
?>
<div class="row pr-4 pl-4">
    <div class="col">
        <div class="card border-0">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="text-dark">First Name</label>
                    <div class="input-group">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" required />
                    </div>

                    <?php
                        echo isset($_SESSION['ErrorMessage']['first_name']) ? $_SESSION['ErrorMessage']['first_name'] : "";
                        unset($_SESSION['ErrorMessage']['first_name']);
                    ?>
                </div>

                <div class="form-group">
                    <label class="text-dark">Last Name</label>
                    <div class="input-group">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name" required />
                    </div>

                    <?php
                        echo isset($_SESSION['ErrorMessage']['last_name']) ? $_SESSION['ErrorMessage']['last_name'] : "";
                        unset($_SESSION['ErrorMessage']['last_name']);
                    ?>
                </div>

                <div class="form-group">
                    <label class="text-dark">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required />
                    </div>

                    <?php
                        echo isset($_SESSION['ErrorMessage']['email']) ? $_SESSION['ErrorMessage']['email'] : "";
                        unset($_SESSION['ErrorMessage']['email']);
                    ?>
                </div>

                <div class="form-group">
                    <label class="text-dark">Address</label>
                    <div class="input-group">
                        <textarea name="address" class="form-control" placeholder="Address" required /></textarea>
                    </div>

                    <?php
                        echo isset($_SESSION['ErrorMessage']['address']) ? $_SESSION['ErrorMessage']['address'] : "";
                        unset($_SESSION['ErrorMessage']['address']);
                    ?>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="file" name="employee_image" required />
                    </div>

                    <?php
                        echo isset($_SESSION['ErrorMessage']['employee_image']) ? $_SESSION['ErrorMessage']['employee_image'] : "";
                        unset($_SESSION['ErrorMessage']['employee_image']);
                    ?>
                </div>

                <div class="row justify-content-left">
                    <div class="form-group mr-3">
                        <div class="input-group">
                            <input type="submit" name="add_employee" class="btn btn-primary mt-3" >
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <a href="index.php" class="btn btn-secondary mt-3">Cancel</a>
                        </div>
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
