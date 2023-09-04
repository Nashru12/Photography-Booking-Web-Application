<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: index.php');
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Initialize the message variable
$message = '';

// Retrieve user email from the database
$stmt = $conn->prepare("SELECT User_email FROM user WHERE id = ?");
if (!$stmt) {
    die('Error preparing statement: ' . $conn->error);
}
$stmt->bind_param("i", $user_id);
if (!$stmt->execute()) {
    die('Error executing statement: ' . $stmt->error);
}
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$email = $row['User_email'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data 
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare and execute the SQL query to insert the data into the 'contact' table 
    $sql = "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if (!$stmt->execute()) {
        die('Error executing statement: ' . $stmt->error);
    }

    // Check if the insertion was successful 
    if ($stmt->affected_rows > 0) {
        // Data inserted successfully 
        $message = 'Message sent successfully.';
    } else {
        // Error occurred while inserting data 
        $message = 'Failed to send message. Please try again later.';
    }

    // Close the statement and database connection 
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/cust-contact.css?v=<?php echo time(); ?>">
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
            <h1 style="margin-top:28px;margin-left:50px;">Contact Information</h1>
            <div class="contact-details">
                <h3 style="font-weight: normal;">Contact Details</h3>
                <ul class="list-group">
                    <li class="list-group-item">Email: ketawariangstudio@gmail.com</li>
                    <li class="list-group-item">Phone: 017-6563816</li>
                    <li class="list-group-item">Address: Alor Gajah, Melaka</li>
                </ul>
            </div>
            <div class="contact-form">
                <h3>Contact Form</h3>
                <?php if ($message != '') : ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>
                <form action="cust-contact.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <!-- <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>" readonly>
                    </div> -->
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
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