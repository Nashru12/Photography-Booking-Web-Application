<?php
include 'connect.php';

// Start the session
session_start();

// Check if the user is logged in and has the role of 'customer'
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch customer bookings from the database for the logged-in user
$query = "SELECT booking.booking_id, packages.package_name, booking.address, booking.event_date, booking.status
          FROM booking
          INNER JOIN packages ON booking.package_id = packages.package_id
          WHERE booking.id = $user_id";
$result = mysqli_query($conn, $query);

// Check if the query was executed successfully
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\cust-profile.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">

    <title>Profile</title>
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

            <h1 style="color:black;margin-left:70px;margin-top:50px;margin-bottom:-40px;">Booking List</h1>
            <div class="table-container">
                <h2>Your Booking</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Package Name</th>
                            <th>Address</th>
                            <th>Event Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['booking_id']; ?></td>
                                <td><?php echo $row['package_name']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['event_date']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>

</html>