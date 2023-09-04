<?php
session_start(); // Start the session
include 'connect.php';

// Function to sanitize user input
function sanitizeInput($input)
{
    // Remove leading/trailing white space
    $input = trim($input);
    // Remove special characters
    $input = htmlspecialchars($input);
    return $input;
}

$error = ""; // Initialize an empty error message

if (isset($_POST['submit'])) {
    $email = sanitizeInput($_POST['User_email']);
    $password = sanitizeInput($_POST['User_pass']);
    $confirmPassword = sanitizeInput($_POST['User_confirm_pass']);
    $role = 'admin';

    if ($password !== $confirmPassword) {
        $error = "Password and confirm password do not match!";
    } else {
        // Check if user with the same email already exists
        $stmt = $conn->prepare("SELECT * FROM user WHERE User_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "User with email already exists!";
        } else {
            // Save user information to the users table
            $stmt = $conn->prepare("INSERT INTO user (User_email, User_pass, User_role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, password_hash($password, PASSWORD_DEFAULT), $role);
            if ($stmt->execute()) {
                $user_id = $stmt->insert_id; // Get the ID of the newly created user
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_role'] = $role;
                header('Location: index.php');
                exit;
            } else {
                $error = "Error creating user: " . $stmt->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style\signup.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Sign Up</title>
    <!-- <style>
        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style> -->
</head>

<body>
    <div class="container">
        <div class="left">
            <div class="logo">
                <img src="images/logo company.jpg">
                <h2 style="margin-top: 50px; font-size: 28px;font-weight:900;">KETAWARIANG STUDIO</h2>
            </div>
        </div>
        <div class="right">
            <h1>Sign Up</h1>
            <?php if (!empty($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form class="" action="" method="post" autocomplete="off">
                <label for="User_email">Email:</label>
                <input type="email" name="User_email" id="User_email" required value="">
                <label for="User_pass">Password:</label>
                <input type="password" name="User_pass" id="User_pass" required value="">
                <label for="User_confirm_pass">Confirm Password:</label>
                <input type="password" name="User_confirm_pass" id="User_confirm_pass" required value="">
                <button type="submit" name="submit" style="margin-top: 16px;">Register</button>
            </form>
        </div>
    </div>
</body>

</html>
