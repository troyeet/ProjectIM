<?php
session_start();
include 'server/connection.php';

$error = ""; // Variable to store error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['login_password']);

    $query_users = "SELECT * FROM users WHERE username='$username'";
    $result_users = mysqli_query($conn, $query_users);

    if ($result_users && mysqli_num_rows($result_users) == 1) {
        $user = mysqli_fetch_assoc($result_users);

        // Check if the password matches
        if ($password === $user['password']) {
            // Store user information in session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect based on user type
            if ($user['user_type'] == 'a') {
                header("Location: admin_page.php");
            } elseif ($user['user_type'] == 'u') {
                header("Location: user_page.php");
            }
            exit;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="form-box">
    <div class="form-section active">
        <h3>SIGN IN</h3>
        <form action="" method="POST">
            <div class="form-group">
                <input type="username" id="username" name="username" placeholder="Username" required>
                <?php if (!empty($error) && strpos($error, 'email') !== false): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="password" id="login_password" name="login_password" placeholder="Password" required>
                <?php if (!empty($error) && strpos($error, 'password') !== false): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>
            </div>
            <p class="forgot"><a href="/forgot-password">Forgot your password?</a></p>
            <div class="form-group">
                <button type="submit">LOGIN</button>
            </div>
            <div class="form-group login-text">
                <p>Don't have an account? <a href="/management_system/signup.php">Sign up now</a></p>
            </div>
        </form>
    </div>
</div>

</body>
</html>

