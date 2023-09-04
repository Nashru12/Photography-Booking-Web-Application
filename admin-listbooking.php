<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch all bookings from the database
$query = "SELECT * FROM booking b JOIN packages p ON b.package_id = p.package_id";
$result = mysqli_query($conn, $query);
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['complete'])) {
        $booking_id = $_POST['complete'];

        // Update the status of the booking to "Completed"
        $update_query = "UPDATE booking SET status = 'Completed' WHERE booking_id = '$booking_id'";
        mysqli_query($conn, $update_query);

        // Fetch the price of the package for the booking
        $package_query = "SELECT p.package_price FROM booking b JOIN packages p ON b.package_id = p.package_id WHERE b.booking_id = '$booking_id'";
        $package_result = mysqli_query($conn, $package_query);
        $row = mysqli_fetch_assoc($package_result);
        $price = $row['package_price'];

        // Insert sales information into the sales table
        $insert_query = "INSERT INTO sales (booking_id, amount, sale_date) VALUES ('$booking_id', '$price', NOW())";
        mysqli_query($conn, $insert_query);

        // Redirect to the same page to reflect the updated status
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\admin-listbooking.css?v=<?php echo time(); ?>">
    <title>Admin Bookings</title>
</head>

<body>

    <nav>
        <ul>
            <div class="logo">
                <img src="images\logo company.jpg" alt="Logo">
            </div>
            <li><a href="admin-dashboard.php" class="active">Dashboard</a></li>
            <li><a href="admin-emp_info.php">Employee Information</a></li>
            <li><a href="admin-listpackage_info.php">Package Information</a></li>
            <li><a href="admin-listbooking.php">Booking</a></li>
            <li><a href="admin-contact.php">Contact</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <h2 style="margin-left:50%;font-weight:normal;margin-top:40px;margin-bottom:30px;">Booking List</h2>
    <div class="container">
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
                    <th>Action</th>
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
                        <td>
                            <?php if ($booking['status'] !== 'Completed') : ?>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="complete" value="<?php echo $booking['booking_id']; ?>">
                                    <button type="submit">Complete</button>
                                </form>
                            <?php else : ?>
                                <div class="checkmark">&#10003;</div> <!-- Checkmark symbol -->
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>