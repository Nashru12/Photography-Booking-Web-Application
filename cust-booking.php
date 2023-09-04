<?php
include 'connect.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

if (isset($_GET['package'])) {
    $package_name = $_GET['package'];

    // Fetch package data from the database
    $package_query = "SELECT * FROM packages WHERE package_name = '$package_name'";
    $package_result = mysqli_query($conn, $package_query);

    if (!$package_result) {
        die('Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($package_result) > 0) {
        $package = mysqli_fetch_assoc($package_result);
    } else {
        // Redirect if the package name is not found
        header('Location: cust-dashboard.php');
        exit;
    }
} else {
    // Redirect if the package name is not provided
    header('Location: cust-dashboard.php');
    exit;
}

// Get the already booked dates
$booked_dates_query = "SELECT DISTINCT event_date FROM booking";
$booked_dates_result = mysqli_query($conn, $booked_dates_query);

if (!$booked_dates_result) {
    die('Error: ' . mysqli_error($conn));
}

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
        $insert_query = "INSERT INTO booking (package_id, id, customer_name, phone_number, address, event_date) VALUES ('$package_id', '$user_id', '$customer_name', '$phone_number', '$address', '$event_date')";

        if ($conn->query($insert_query) === TRUE) {
            // Redirect to the invoice page with the booking details
            $booking_id = $conn->insert_id;
            header("Location: cust-invoice.php?booking_id=$booking_id");
            exit;
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/cust-booking.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Booking</title>
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

            <h2 class="package-name" style="margin-left:50px;margin-top:30px;"><?php echo $package['package_name']; ?></h2>
            <!-- <ul class="breadcrumb">
                <li><a href="cust-booking.php">Booking</a></li>
                <li><a href="cust-invoice.php">Invoice</a></li>
                <li><a href="cust-payment.php">Payment</a></li>
            </ul> -->

            <div class="user-booking">
                <div class="user-booking-item" style="margin-left:38px;">
                    <img src="images\kipas.jpeg" alt="contoh">
                </div>
                <div class="booking-form-wrapper" style="margin-top:-426px;">
                    <div class="column">
                        <img src="images\cincin.jpeg" alt="" style="margin-left: 410px; margin-top:-150px;">
                    </div>
                    <div class="column">
                        <img src="images\harimerdeka.jpg" alt="" style="margin-top:240px;">
                    </div>
                    <div class="column">
                        <img src="images\photo1621377603.jpeg" alt="" style="margin-top:-150px;">
                    </div>
                    <div class="column">
                        <img src="images\mahathir.jpeg" alt="" style="margin-top: 240px;margin-left:-718px">
                    </div>
                </div>
                <div class="shape" style="margin-top: 30px;">
                    <div class="package-info">
                        <h2 class="package-name"><?php echo $package['package_name']; ?></h2>
                        <p class="package-price" style="font-weight:900;font-size:18px">RM<?php echo $package['package_price']; ?></p>
                        <div class="information-container">
                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                <?php $information = $package['information_' . $i]; ?>
                                <?php if ($information !== '-') : ?>
                                    <p style="font-weight: 500;">&#10004;<?php echo $information; ?></p>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <br>
            </div>

            <div class="form-container">
                <form method="POST" action="">
                    <input type="hidden" name="package_id" value="<?php echo $package['package_id']; ?>">
                    <div class="form-group">
                        <h2 style="text-align: center;">Booking Form</h2>
                        <!-- <label for="package">Selected Package:</label>
                        <input type="text" id="package" value="<?php echo $package['package_name']; ?>" disabled> -->
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
            <div class="foot1">
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