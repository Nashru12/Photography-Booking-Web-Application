<?php
include 'connect.php';
session_start();

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Check if the "Resolved" button is clicked
if (isset($_POST['resolved'])) {
    $contactId = $_POST['id'];

    // Update the status to "Resolved" in the database
    $stmt = $conn->prepare("UPDATE contact SET status = 'Resolved' WHERE id = ?");
    $stmt->bind_param("i", $contactId);
    $stmt->execute();
    $stmt->close();
}

// Retrieve data from the contact table
$sql = "SELECT * FROM contact";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style\admin-contact.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["subject"] . "</td>";
                echo "<td>" . $row["message"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                echo "<td>";
                if ($row["status"] === "Pending") {
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                    echo "<button type='submit' name='resolved'>Resolved</button>";
                    echo "</form>";
                } else if ($row["status"] === "Resolved") {
                    echo "&#10003;";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found.</td></tr>";
        }
        ?>
    </table>
</body>

</html>

<?php
$conn->close();
?>