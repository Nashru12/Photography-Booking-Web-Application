<?php
include 'connect.php';

// Initialize error variable
$error = "";

// Check if the form is submitted
if (isset($_POST['User_email']) && isset($_POST['User_pass'])) {
    $email = $_POST['User_email'];
    $password = $_POST['User_pass'];

    // Check if the user exists with the given email
    $sql = "SELECT * FROM user WHERE User_email='$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['User_pass'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_role'] = $row['User_role'];

            if ($row['User_role'] === 'admin') {
                header("Location: admin-dashboard.php");
                exit;
            } elseif ($row['User_role'] === 'customer') {
                header("Location: cust-dashboard.php");
                exit;
            }
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "User not found";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\loginsignup.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="logo">
                <img src="images\logo company.jpg">
                <h2 style="margin-top: 50px; font-size: 28px;font-weight:900;">KETAWARIANG STUDIO</h2>
            </div>
        </div>
        <div class="right">
            <h1>Login</h1>
            <?php if (!empty($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>
            <form class="" action="" method="post" autocomplete="off">
                <label for="User_email">Email: </label>
                <input type="email" name="User_email" id="User_email" required value="">
                <label for="User_pass">Password : </label>
                <input type="password" name="User_pass" id="User_pass" required value=""><br>
                <a href="forgotpassword.php" id="forgot">Forgot Password?</a>
                <button type="submit" name="submit">Login</button>
            </form>

            <a class="signup" href="signup.php">Don't Have an Account</a>
        </div>
    </div>
</body>

</html>