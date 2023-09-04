<?php
include 'connect.php';

session_start();
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Get the selected month and year
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('n');
$selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Get the start and end date of the selected month
$start_date = date('Y-m-01', strtotime("$selected_year-$selected_month-01"));
$end_date = date('Y-m-t', strtotime("$selected_year-$selected_month-01"));

// Fetch the monthly sales report
$query = "SELECT b.booking_id, b.customer_name, b.event_date, b.package_id, b.phone_number, b.address, b.booking_date, s.amount 
          FROM sales s 
          INNER JOIN booking b ON s.booking_id = b.booking_id 
          WHERE b.event_date >= '$start_date' AND b.event_date <= '$end_date' 
          ORDER BY b.event_date";
$result = mysqli_query($conn, $query);

// Check if there are any results
if ($result && mysqli_num_rows($result) > 0) {
    $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $sales = array(); // Set an empty array if no results found
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Monthly Sales Report</title>
    <link rel="stylesheet" type="text/css" href="style\admin-monthlysale-report.css?v=<?php echo time(); ?>">
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
    <h2>Monthly Sales Report</h2>
    <div class="container">
        <h3>Month: <?php echo date('F Y', strtotime("$selected_year-$selected_month-01")); ?></h3>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Package ID</th>
                    <th>Customer Name</th>
                    <th>Customer Phone Number</th>
                    <th>Address</th>
                    <th>Event Date</th>
                    <th>Booking Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['booking_id']); ?></td>
                        <td><?php echo htmlspecialchars($sale['package_id']); ?></td>
                        <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($sale['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($sale['address']); ?></td>
                        <td><?php echo htmlspecialchars($sale['event_date']); ?></td>
                        <td><?php echo htmlspecialchars($sale['booking_date']); ?></td>
                        <td>RM<?php echo htmlspecialchars($sale['amount']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>