<?php
include 'connect.php';

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the temporary table
    $sql = "SELECT * FROM password_reset WHERE token='$token'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        // Token is valid, allow the user to reset their password
        if (isset($_POST['submit'])) {
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validate the new password and confirm password
            if ($newPassword !== $confirmPassword) {
                $error_message = "New password and confirm password do not match.";
            } else {
                // Retrieve the user's email from the temporary table
                $row = mysqli_fetch_assoc($result);
                $email = $row['email'];

                // Update the user's password in the main table
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql = "UPDATE user SET User_pass='$hashedPassword' WHERE User_email='$email'";
                $updateResult = mysqli_query($conn, $sql);

                if ($updateResult) {
                    // Password updated successfully, remove the token from the temporary table
                    $sql = "DELETE FROM password_reset WHERE token='$token'";
                    mysqli_query($conn, $sql);

                    $success_message = "Password updated successfully. You can now <a href='index.php'>Login</a> with your new password.";
                } else {
                    $error_message = "Failed to update the password. Please try again.";
                }
            }
        }
    } else {
        echo "<p class='error-message'>Invalid token.</p>";
    }
} else {
    echo "<p class='error-message'>Token not provided.</p>";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\resetpassword.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Reset Password</title>
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
            <h1>Reset Password</h1>
            <?php if (isset($error_message)) { ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php } elseif (isset($success_message)) { ?>
                        <p class="success-message"><?php echo $success_message; ?></p>
                    <?php } ?>
            <?php if (isset($_GET['token'])) { ?>
                <form class="" action="" method="post" autocomplete="off">
                    <label for="new_password">New Password: </label>
                    <input type="password" name="new_password" id="new_password" required value="">
                    <label for="confirm_password">Confirm Password: </label>
                    <input type="password" name="confirm_password" id="confirm_password" required value="">
                    <button type="submit" name="submit">Update Password</button>
                </form>
            <?php } else { ?>
                <p class="error-message">Token not provided.</p>
            <?php } ?>

            <a class="signup" href="signup.php">Don't Have an Account</a>
            <!-- <div class="signup">
        <p>Don't have an account?</p>
        <button type="button">Sign up</button>
    </div> -->
        </div>

    </div>
</body>

</html>