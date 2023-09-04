<?php
include 'connect.php';

session_start();
if ($_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

if (isset($_GET['package'])) {
    $package_name = $_GET['package'];

    // Fetch package data from the database
    $query = "SELECT * FROM packages WHERE package_name = '$package_name'";
    $result = mysqli_query($conn, $query);
    $package = mysqli_fetch_assoc($result);
} else {
    // Redirect if the package name is not provided
    header('Location: cust-dashboard.php');
    exit;
}

// Get the already booked dates
$booked_dates_query = "SELECT DISTINCT event_date FROM booking";
$booked_dates_result = mysqli_query($conn, $booked_dates_query);
$booked_dates = [];
while ($row = mysqli_fetch_assoc($booked_dates_result)) {
    $booked_dates[] = $row['event_date'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $event_date = $_POST['event_date'];

    // Check if the selected date is already booked
    if (in_array($event_date, $booked_dates)) {
        $message = "The selected date has already been booked. Please choose a different date.";
    } else {
        // Insert the booking data into the database
        $package_id = $package['package_id'];
        $sql = "INSERT INTO booking (package_id, customer_name, phone_number, address, event_date) VALUES ('$package_id', '$customer_name', '$phone_number', '$address', '$event_date')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to the invoice page with the booking details
            $booking_id = $conn->insert_id;
            header("Location: cust-invoice.php?booking_id=$booking_id");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style\testing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Booking</title>
</head>

<body>
    <div class="container">
        <div class="main">
            <div class="nav">
                <a href="logout.php">LOGOUT</a>
                <a href="profile.php">PROFILE</a>
                <a href="cust-booking.php">BOOKING</a>
                <a href="cust-information.php">INFORMATION</a>
                <a href="cust-dashboard.php">HOME</a>
                <img src="images\logo company.jpg">
            </div>

            <h2 id="topic1" style="text-align: center; margin: 35px;">Booking Form</h2>

            <div class="form-container">
                <form method="POST" action="">
                    <input type="hidden" name="package_id" value="<?php echo $package['package_id']; ?>">
                    <div class="form-group">
                        <label for="package">Selected Package:</label>
                        <input type="text" id="package" value="<?php echo $package['package_name']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="customer_name">Customer Name:</label>
                        <input type="text" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number:</label>
                        <input type="tel" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="event_date">Event Date:</label>
                        <input type="text" id="event_date" name="event_date" required>
                        <?php if (isset($message)) : ?>
                            <p class="error-message"><?php echo $message; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <button type="submit">Book Now</button>
                    </div>
                </form>
            </div>

            <div class="foot">
                <footer>
                    <p>&copy; Ketawariang Studio</p>
                </footer>
            </div>
        </div>
    </div>

    <script>
        flatpickr("#event_date", {
            minDate: "today",
            enable: [
                <?php
                $current_date = date('Y-m-d');
                $max_date = date('Y-m-d', strtotime('+1 year'));
                $date = $current_date;
                $available_dates = [];
                while ($date <= $max_date) {
                    if (!in_array($date, $booked_dates)) {
                        $available_dates[] = $date;
                    }
                    $date = date('Y-m-d', strtotime($date . ' +1 day'));
                }
                echo "'" . implode("','", $available_dates) . "'";
                ?>
            ]
        });
    </script>
</body>

</html>
