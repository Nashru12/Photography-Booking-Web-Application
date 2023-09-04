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
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/cust-dashboard.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <title>Homepage</title>
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

            <div class="rectangle">
                <div class="inside1">
                    <h1>Welcome To<br> KetawaRiang Studio</h1>
                    <p>We will bring joy to your life.</p>
                </div>
                <img class="right-image" src="images\dashboard.jpeg" alt="Right Image">
            </div>

            <div class="half-rectangle">
                <img class="left-image" src="images\cincin.jpeg" alt="Left Image">
                <div class="inside2">
                    <p>There have many<br> services we offer for you.<br> We are waiting for you.<br> Grab it now!</p>
                    <a href="cust-information.php">Book Now &#8594;</a>
                </div>
            </div>
            <div class="foot1">
                <footer>
                    <p>&copy; Ketawariang Studio</p>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>