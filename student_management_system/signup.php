<?php
session_start();
include("db_connection.php");


//check if the user is click the post button
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $fullname = $_POST['fullname'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //save to database
   
    $query = "INSERT INTO `users`(`fullname`, `age`, `gender`, `email`, `password`) 
        VALUES ('$fullname','$age','$gender','$email','$password')";

    mysqli_query($con, $query);

    header("location: login.php");
    die;
}

$_SESSION;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">

<div class="row border rounded-5 p-3 shadow box-area">


    <div class="container">
        <div class="row align-items-center">
            <div class="header-text mb-1">
                <p style="color: black;">Sign Up</p>
            </div>
            <form method="post" onsubmit="return validatePassword()">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">


                            <div class="  mb-2">
                                <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Fullname" name="fullname" required>
                            </div>

                            <div class=" mb-2">
                                <input type="number" class="form-control form-control-lg bg-light fs-6" placeholder="Age" name="age" required>
                            </div>

                            <div class="btn-group w-100 mb-2" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="gender" id="btnradio1" autocomplete="off" checked value="male">
                                <label class="btn btn-outline-primary" for="btnradio1">Male</label>

                                <input type="radio" class="btn-check" name="gender" id="btnradio2" autocomplete="off" value="female">
                                <label class="btn btn-outline-primary" for="btnradio2">Female</label>
                            </div>

                            <div class="mb-2">
                                <input type="email" class="form-control form-control-lg bg-light fs-6" placeholder="Email Address" name="email" required>
                            </div>
                        </div>

                        <!--2nd row-->
                        <div class="col-md-6">

                            <div class=" mb-2">
                                <input type="password" class="form-control form-control-lg bg-light fs-6" id="password" placeholder="Password" name="password" required>
                            </div>

                            <div class=" mb-2">
                                <input type="password" class="form-control form-control-lg bg-light fs-6" id="confirmPassword" placeholder="Confirm Password" required>
                                <span id="passwordError" class="error"></span>
                            </div>

                        </div>



                    </div>

                </div>
        </div>

        <div class="input-group mb-3 mt-3 align-items-center justify-content-center">
            <button type="submit" class="btn btn-md btn-primary w-50 fs-6">Sign up</button>
        </div>

        <div class="row text-center">
            <Small style="color: black;">Have an account? <a href="login.php">Log in</a></Small>
        </div>

        </form>



    </div>

</div>
</div>

</body>
<script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.js"></script>
</html>
