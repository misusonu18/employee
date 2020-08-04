<?php
include 'layouts/header.php';
include 'config/database.php';
session_start();

if (isset($_GET['employee_id'])) {
    $id = $_GET['employee_id'];
    $getEmployee = mysqli_query($connection, 'select * from employee where id="'.$id.'"');
    $record = mysqli_fetch_assoc($getEmployee);
}

if (isset($_POST['edit_employee'])) {
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
        $id = $_GET['employee_id'];
        $firstName = mysqli_real_escape_string($connection, $_POST['first_name']);
        $lastName = mysqli_real_escape_string($connection, $_POST['last_name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $address = mysqli_real_escape_string($connection, $_POST['address']);
        $image = $_POST['image'];

        if (!empty($_FILES['employee_image']['name'])) {
            $fileName = rand(1, 99999).str_replace(" ", "", basename($_FILES["employee_image"]["name"]));
            move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$fileName);

            $updateQuery = 'update employee set first_name="'.$firstName.'", last_name="'.$lastName.'", email="'.$email.'", address="'.$address.'",photo="'.$fileName.'" where id="'.$id.'"';
            $updateQuery = mysqli_query($connection, $updateQuery);
            if (file_exists("images/".$image)) {
                unlink("images/".$image);
            }

            if ($updateQuery === true) {
                $update = "success";
            } else {
                $update = "error";
            }
        } else {
            $updateQuery = 'update employee set first_name="'.$firstName.'", last_name="'.$lastName.'", email="'.$email.'", address="'.$address.'" where id="'.$id.'"';
            if (mysqli_query($connection, $updateQuery)) {
                $update = "success";
            } else {
                $update = "error";
            }
        }
    }
}

?>
<div class="row pr-4 pl-4">
    <div class="col">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="text-dark">First Name</label>
                <div class="input-group">
                    <input type="text"
                        name="first_name"
                        class="form-control"
                        placeholder="First Name"
                        value="<?php echo $record['first_name'] ?>"
                        required
                    >
                </div>

                <?php
                    echo isset($_SESSION['ErrorMessage']['first_name']) ? $_SESSION['ErrorMessage']['first_name'] : "";
                    unset($_SESSION['ErrorMessage']['first_name']);
                ?>
            </div>

            <div class="form-group">
                <label class="text-dark">Last Name</label>
                <div class="input-group">
                    <input type="text"
                        name="last_name"
                        class="form-control"
                        placeholder="Last Name"
                        value="<?php echo $record['last_name'] ?>"
                        required
                    >
                </div>

                <?php
                    echo isset($_SESSION['ErrorMessage']['last_name']) ? $_SESSION['ErrorMessage']['last_name'] : "";
                    unset($_SESSION['ErrorMessage']['last_name']);
                ?>
            </div>

            <div class="form-group">
                <label class="text-dark">Email</label>
                <div class="input-group">
                    <input type="email"
                        name="email"
                        class="form-control"
                        placeholder="Email"
                        value="<?php echo $record['email'] ?>"
                        required
                >
                </div>

                <?php
                    echo isset($_SESSION['ErrorMessage']['email']) ? $_SESSION['ErrorMessage']['email'] : "";
                    unset($_SESSION['ErrorMessage']['email']);
                ?>
            </div>

            <div class="form-group">
                <label class="text-dark">Address</label>
                <div class="input-group">
                    <input type="text"
                        name="address"
                        class="form-control"
                        placeholder="Address"
                        value="<?php echo $record['address'] ?>"
                        required
                    >
                </div>

                <?php
                    echo isset($_SESSION['ErrorMessage']['address']) ? $_SESSION['ErrorMessage']['address'] : "";
                    unset($_SESSION['ErrorMessage']['address']);
                ?>
            </div>

            <div class="row col justify-content-left">
                <div class="form-group">
                    <input type="file" name="employee_image">
                    <input type="hidden" name="image" value="<?php echo $record['photo'] ?>">
                </div>

                <div>
                    <img src="<?php echo "images/".$record['photo']?>" alt="Employee photo" style='width:100px'>
                </div>
            </div>

            <div class="row justify-content-left">
                <div class="form-group mr-3">
                    <div class="input-group">
                        <input type="submit" name="edit_employee" class="btn btn-primary" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <a href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php

include 'layouts/footer.php';

if (isset($update) && $update === "success") {
    echo "
        <script type='text/javascript'>
            alertify.notify('Update Successfully', 'success', 1, function(){
                window.location.href='index.php';
            });
        </script>
    ";
} elseif (isset($update) && $update === "error") {
    echo "
        <script type='text/javascript'>
            alertify.notify('Something Went Wrong', 'error', 1, function(){
                window.location.href='index.php';
            });
        </script>
    ";
}
