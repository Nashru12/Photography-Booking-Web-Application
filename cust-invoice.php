<?php
include 'connect.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user email from the database
$query = "SELECT User_email FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);
    $user_email = $user['User_email'];

    if (isset($_GET['booking_id'])) {
        $booking_id = $_GET['booking_id'];

        // Fetch booking data from the database
        $query = "SELECT b.*, p.package_name, p.package_price
                  FROM booking b
                  JOIN packages p ON b.package_id = p.package_id
                  WHERE b.booking_id = '$booking_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $booking = mysqli_fetch_assoc($result);
        } else {
            // Redirect or display an error message if the query failed
            echo "Error retrieving booking data: " . mysqli_error($conn);
            exit;
        }
    } else {
        // Redirect if the booking ID is not provided
        header('Location: cust-dashboard.php');
        exit;
    }
} else {
    // Redirect or display an error message if the query failed
    echo "Error retrieving user email: " . mysqli_error($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title>Invoice</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap");

        body {
            background-color: #fff;
            font-family: "Montserrat", sans-serif;
        }

        .logo {
            max-width: 90px;
            height: auto;
            margin-bottom: 10px;
        }

        .invoice-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        .card {
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        }

        .card-header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-body .row {
            margin-top: 10px;
        }

        .card-footer {
            display: flex;
            justify-content: center;
        }

        h5,
        p {
            font-size: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-container">
            <div class="card">
                <div class="card-header">
                    <img src="images\logo company.jpg" alt="Logo" class="logo">
                    <h4 class="text-center">INVOICE</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Booking ID: <?php echo $booking['booking_id']; ?></h5>
                            <p><strong>Package Name:</strong> <?php echo $booking['package_name']; ?></p>
                            <p><strong>Package Price:</strong> RM<?php echo $booking['package_price']; ?></p>
                            <p><strong>Customer Name:</strong> <?php echo $booking['customer_name']; ?></p>
                            <p><strong>Phone Number:</strong> <?php echo $booking['phone_number']; ?></p>
                            <p><strong>Email:</strong> <?php echo $user_email; ?></p>
                            <p><strong>Event Address:</strong> <?php echo $booking['address']; ?></p>
                            <p><strong>Event Date:</strong> <?php echo $booking['event_date']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-primary" onclick="payNow()">Pay Now</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function payNow() {
            // Get the necessary data from the current page
            var package_name = '<?php echo $booking['package_name']; ?>';
            var package_price = '<?php echo $booking['package_price']; ?>';
            var customer_name = '<?php echo $booking['customer_name']; ?>';
            var phone_number = '<?php echo $booking['phone_number']; ?>';
            var email = '<?php echo $user_email; ?>';
            var address = '<?php echo $booking['address']; ?>';
            var event_date = '<?php echo $booking['event_date']; ?>';

            // Create a form to send the data to payment.php
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'payment.php';

            // Create hidden input fields to hold the data
            var package_nameInput = document.createElement('input');
            package_nameInput.type = 'hidden';
            package_nameInput.name = 'package_name';
            package_nameInput.value = package_name;

            var package_priceInput = document.createElement('input');
            package_priceInput.type = 'hidden';
            package_priceInput.name = 'package_price';
            package_priceInput.value = package_price;

            var customer_nameInput = document.createElement('input');
            customer_nameInput.type = 'hidden';
            customer_nameInput.name = 'customer_name';
            customer_nameInput.value = customer_name;

            var phone_numberInput = document.createElement('input');
            phone_numberInput.type = 'hidden';
            phone_numberInput.name = 'phone_number';
            phone_numberInput.value = phone_number;

            var emailInput = document.createElement('input');
            emailInput.type = 'hidden';
            emailInput.name = 'email';
            emailInput.value = email;

            var addressInput = document.createElement('input');
            addressInput.type = 'hidden';
            addressInput.name = 'address';
            addressInput.value = address;

            var event_dateInput = document.createElement('input');
            event_dateInput.type = 'hidden';
            event_dateInput.name = 'event_date';
            event_dateInput.value = event_date;

            // Append the input fields to the form
            form.appendChild(package_nameInput);
            form.appendChild(package_priceInput);
            form.appendChild(customer_nameInput);
            form.appendChild(phone_numberInput);
            form.appendChild(emailInput);
            form.appendChild(addressInput);
            form.appendChild(event_dateInput);

            // Append the form to the document and submit it
            document.body.appendChild(form);
            form.submit();
        }
    </script>

</body>

</html>