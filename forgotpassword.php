<?php
include 'connect.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if user exists with the given email
    $sql = "SELECT * FROM user WHERE User_email='$email'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        // Generate a unique verification token
        $token = bin2hex(random_bytes(32));

        // Store the verification token and user email in a temporary table
        $sql = "CREATE TABLE IF NOT EXISTS password_reset (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    email VARCHAR(255) NOT NULL,
                    token VARCHAR(64) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                )";
        mysqli_query($conn, $sql);

        // Remove any existing entries for the user
        $sql = "DELETE FROM password_reset WHERE email='$email'";
        mysqli_query($conn, $sql);

        // Insert the new token into the temporary table
        $sql = "INSERT INTO password_reset (email, token) VALUES ('$email', '$token')";
        mysqli_query($conn, $sql);

        // Redirect the user to the password reset page
        header("Location: resetpassword.php?token=$token");
        exit;
    } else {
        $error_message = "User not found.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\forgotpassword.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Forgot Password</title>
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
            <h1>Forgot Password</h1>
            <?php if (isset($error_message)) { ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
            <form class="" action="" method="post" autocomplete="off">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" required value="">
                <button type="submit" name="submit">Reset Password</button>
            </form>

            <a class="signup" href="signup.php">Don't Have an Account</a>
            <!-- <div class="signup">
        <p>Don't have an account?</p>
        <button type="button">Sign up</button>
    </div> -->
        </div>

    </div>
</body>

</html>