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

        if (empty($_FILES['employee_image']['name'])) {
            $_SESSION['ErrorMessage']['employee_image'] = "Image Required";
        }
    } else {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $fileName = rand(1, 999).basename($_FILES["employee_image"]["name"]);
        move_uploaded_file($_FILES["employee_image"]["tmp_name"], "images/".$fileName);

        if ($insert = mysqli_query(
            $connection,
            "INSERT INTO employee (first_name,last_name,email,address,photo) VALUES('$firstName', '$lastName', '$email', '$address', '$fileName')"
        )) {
            $_SESSION['ErrorMessage']['success'] = 'Employee Inserted Successfully';
            header('location:index.php');
        } else {
            $_SESSION['ErrorMessage']['error'] = 'Something Went Wrong';
            header('location:index.php');
        }
    }
}
?>
<div class="row pr-4 pl-4">
    <div class="col">
        <div class="card p-4 border-0">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="text-dark">First Name</label>
                    <div class="input-group">
                        <input type="text" 
                            name="first_name" 
                            class="form-control" 
                            placeholder="First Name" 
                            data-cy="first-name"
                            required 
                        />
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
                            required 
                            data-cy="last-name"
                        />
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
                            data-cy="email"
                            required 
                        />
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
                        <textarea name="address" 
                            class="form-control" 
                            placeholder="Address" 
                            data-cy="address"
                            required 
                        />
                        </textarea>
                    </div>

                    <?php
                        if (isset($_SESSION['ErrorMessage']['address'])) {
                            echo '<small class="text-danger">'.$_SESSION['ErrorMessage']['address'].'</small>';
                            unset($_SESSION['ErrorMessage']['address']);
                        }
                    ?>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="file" 
                            name="employee_image" 
                            data-cy="photo"
                            required   
                        />
                    </div>

                    <?php
                        if (isset($_SESSION['ErrorMessage']['employee_image'])) {
                            echo '<small class="text-danger">'.$_SESSION['ErrorMessage']['employee_image'].'</small>';
                            unset($_SESSION['ErrorMessage']['employee_image']);
                        }
                    ?>
                </div>

                <div class="row justify-content-left">
                    <div class="form-group mr-3">
                        <div class="input-group">
                            <input type="submit" data-cy="submit" name="add_employee" class="btn btn-primary mt-3" >
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