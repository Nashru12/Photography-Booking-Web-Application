<?php
include 'connect.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch package data from the database for the "wedding" category
$query = "SELECT * FROM packages WHERE category = 'Wedding'";
$result = mysqli_query($conn, $query);
$packages = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\cust-wedding.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Wedding</title>
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

            <h1 id="topic1" style="text-align: center; margin-top:28px;">Wedding</h1>
            <h2 style="text-align: center;font-weight:normal;line-height:34px;margin-top:-16px;margin-bottom:40px;color:#494949;">These are the services that we offer and we guarantee<br> for the top quality</h2>

            <div class="rect">
                <?php foreach ($packages as $package) { ?>
                    <div class="kotak">
                        <img src="images/<?php echo $package['image_link']; ?>">

                        <div class="content">
                            <h3><?php echo $package['package_name']; ?></h3>
                            <ul>
                                <li class="price"><?php echo 'RM' . $package['package_price']; ?></li>

                                <?php
                                for ($i = 1; $i <= 6; $i++) {
                                    $information = $package['information_' . $i];
                                    if ($information !== '-') {
                                        echo '<li>' . $information . '</li>';
                                    }
                                }
                                ?>
                                <div class="book">
                                    <a href="cust-booking.php?package=<?php echo urlencode($package['package_name']); ?>">Booking Now!</a>
                                </div>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
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