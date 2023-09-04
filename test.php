<?php
// Start the session
include 'connect.php';

session_start();
if ($_SESSION['user_role'] !== 'customer') {
    header('Location: login.php');
    exit;
}

// Connect to the database
include 'connect.php';

// Get the user's email from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT User_email FROM user WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
while($user = mysqli_fetch_assoc($result)){

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
</head>
<body>
	<h1>Welcome to your profile, <?php echo $user['User_email']; ?>!</h1><?php } ?>
	<a href="logout.php">Log out</a>
</body>
</html>
