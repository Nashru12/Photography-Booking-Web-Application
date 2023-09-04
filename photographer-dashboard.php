<?php
include 'connect.php';

session_start();
if ($_SESSION['user_role'] !== 'photographer') {
    header('Location: index.php');
    exit;
}

// Retrieve the photographer's ID from the session
$photographerId = $_SESSION['user_id'];

// Fetch the assigned bookings for the photographer
$query = "SELECT b.booking_id, b.customer_name, b.phone_number, b.address, b.event_date, b.status, p.package_name
          FROM booking b
          JOIN packages p ON b.package_id = p.package_id
          WHERE FIND_IN_SET('$photographerId', b.employee_ids)";
$result = mysqli_query($conn, $query);

if ($result) {
    $bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "Error: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/photographer-bookings.css?v=<?php echo time(); ?>">
    <title>My Bookings</title>
</head>

<body>
    <nav>
        <ul>
            <div class="logo">
                <img src="images/logo-company.jpg" alt="Logo">
            </div>
            <li><a href="photographer-dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <h1>My Bookings</h1>
    <div class="container">
        <?php if (count($bookings) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Package Name</th>
                        <th>Customer Name</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Event Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking) : ?>
                        <tr>
                            <td><?php echo $booking['booking_id']; ?></td>
                            <td><?php echo $booking['package_name']; ?></td>
                            <td><?php echo $booking['customer_name']; ?></td>
                            <td><?php echo $booking['phone_number']; ?></td>
                            <td><?php echo $booking['address']; ?></td>
                            <td><?php echo $booking['event_date']; ?></td>
                            <td><?php echo $booking['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No bookings assigned.</p>
        <?php endif; ?>
    </div>
</body>

</html>