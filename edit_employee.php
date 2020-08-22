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
            $_SESSION['ErrorMessage']['first_name'] = "First Name Required";
        }

        if (empty($_POST['last_name'])) {
            $_SESSION['ErrorMessage']['last_name'] = "Last Name Required";
        }

        if (empty($_POST['email'])) {
            $_SESSION['ErrorMessage']['email'] = "Email Address Required";
        }

        if (empty($_POST['address'])) {
            $_SESSION['ErrorMessage']['address'] = "Address Required";
        }
    } else {
        $id = $_GET['employee_id'];
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $image = $record['photo'];

        if ($_FILES['employee_image']['name'] != '') {
            if (($_FILES['employee_image']['name'] != '') && file_exists('images/'.$image)) {
                unlink('images/'.$image);
            }

            $fileName = rand(1, 999).basename($_FILES["employee_image"]["name"]);
            move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$fileName);

            $updateQuery = mysqli_query(
                $connection,
                "update employee set first_name='$firstName', last_name='$lastName', email='$email', address='$address', photo='$fileName' where id='$id'"
            );

            if ($updateQuery === true) {
                $_SESSION['ErrorMessage']['success'] = 'Employee Updated Successfully';
                header('location:index.php');
            } else {
                $_SESSION['ErrorMessage']['error'] = 'Something Went Wrong';
                header('location:index.php');
            }
        } else {
            if (mysqli_query(
                $connection,
                "update employee set first_name='$firstName', last_name='$lastName', email='$email', address='$address' where id='$id'"
            )) {
                $_SESSION['ErrorMessage']['success'] = 'Employee Updated Successfully';
                header('location:index.php');
            } else {
                $_SESSION['ErrorMessage']['error'] = 'Something Went Wrong';
                header('location:index.php');
            }
        }
    }
}

?>
<div class="row pr-4 pl-4">
    <div class="col">
        <div class="card p-4 border-0">
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
                        if (isset($_SESSION['ErrorMessage']['first_name'])) {
                            echo '<small class="text-danger">'.$_SESSION['ErrorMessage']['first_name'].'</small>';
                            unset($_SESSION['ErrorMessage']['first_name']);
                        }
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
                        if (isset($_SESSION['ErrorMessage']['last_name'])) {
                            echo '<small class="text-danger">'.$_SESSION['ErrorMessage']['last_name'].'</small>';
                            unset($_SESSION['ErrorMessage']['last_name']);
                        }
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
                        if (isset($_SESSION['ErrorMessage']['email'])) {
                            echo '<small class="text-danger">'.$_SESSION['ErrorMessage']['email'].'</small>';
                            unset($_SESSION['ErrorMessage']['email']);
                        }
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
                        if (isset($_SESSION['ErrorMessage']['address'])) {
                            echo '<small class="text-danger">'.$_SESSION['ErrorMessage']['address'].'</small>';
                            unset($_SESSION['ErrorMessage']['address']);
                        }
                    ?>
                </div>

                <div class="row col justify-content-left">
                    <div class="form-group">
                        <input type="file" name="employee_image">
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
</div>
<?php

include 'layouts/footer.php';
