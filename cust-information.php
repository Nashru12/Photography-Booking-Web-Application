<?php
include 'connect.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\cust-information.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <title>Packages</title>
</head>

<body>
    <div class="container">
        <div class="main">
            <div class="nav">
                <a href="logout.php" style="font-weight:600;">Logout</a>
                <a href="cust-profile.php" style="font-weight:600;">Profile</a>
                <a href="cust-contact.php" style="font-weight:600;">Contact</a>
                <a href="cust-information.php" style="font-weight:600;">Information</a>
                <a href="cust-dashboard.php" style="font-weight:600;">Home</a>
                <img src="images/logo company.jpg">
            </div>

            <h1 id="topic1" style="text-align: center; margin-top:28px;">Services</h1>
            <h2 style="text-align: center;font-weight:normal;line-height:34px;margin-top:-16px;margin-bottom:40px;color:#494949;">These are the services that we offer and we guarantee<br> for the top quality</h2>
            <div class="block">
                <div class="box">
                    <h2>Wedding</h2>
                    <img src="images\cincin.jpeg" alt="Image 1">
                    <p>Our main service is wedding. We will make your beautiful day as unforgettable memory.</p>
                    <a href="cust-wedding.php" class="button-link">Preview</a>
                </div>
                <div class="box">
                    <h2>Event Photoshoot</h2>
                    <img src="images\nabilarzali.jpeg" alt="Image 2">
                    <p>We accept to do party photoshoot. We will ensure the joy is displayed in your face</p>
                    <a href="cust-event.php" class="button-link">Preview</a>
                </div>
                <div class="box">
                    <h2>Other</h2>
                    <img src="images\jump.jpeg" alt="Image 3">
                    <p>Others event that require photographer we will accept. The memories will remain in every single picture.</p>
                    <a href="cust-other.php" class="button-link">Preview</a>
                </div>
            </div>

            <div class="foot1">
                <footer>
                    <p>&copy; Ketawariang Studio</p>
                </footer>
            </div>
        </div>
</body>

</html>