<?php
include 'connect.php';
session_start();
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $package_name = $_POST["package_name"];
    $package_price = $_POST["package_price"];
    $information_1 = $_POST["information_1"];
    $information_2 = $_POST["information_2"];
    $information_3 = $_POST["information_3"];
    $information_4 = $_POST["information_4"];
    $information_5 = $_POST["information_5"];
    $information_6 = $_POST["information_6"];
    $category = $_POST["category"];

    // Handle file upload
    $targetDir = "images/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only specific file formats (e.g., JPEG, PNG)
    $allowedTypes = array('jpg', 'jpeg', 'png');
    if (in_array($fileType, $allowedTypes)) {
        // Upload the file to the server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            // File upload success, insert data into the database
            $sql = "INSERT INTO packages (package_name, package_price, information_1, information_2, information_3, information_4, information_5, information_6, category, image_link)
                    VALUES ('$package_name', '$package_price', '$information_1', '$information_2', '$information_3', '$information_4', '$information_5', '$information_6', '$category', '$fileName')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to next page
                header("Location: admin-listpackage_info.php");
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file format. Only JPG, JPEG, and PNG files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add New Package</title>
    <link rel="stylesheet" type="text/css" href="style\admin-register_package.css?v=<?php echo time(); ?>">
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

    <form action="admin-register_package.php" method="post" enctype="multipart/form-data">
        <h2>ADD PACKAGE</h2>
        <label for="package_name">Package Name:</label>
        <input type="text" id="package_name" name="package_name" required><br>

        <label for="package_price">Package Price:</label>
        <input type="text" id="package_price" name="package_price" required><br>

        <label for="information_1">Information 1:</label>
        <input type="text" id="information_1" name="information_1" required><br>

        <label for="information_2">Information 2:</label>
        <input type="text" id="information_2" name="information_2" required><br>

        <label for="information_3">Information 3:</label>
        <input type="text" id="information_3" name="information_3" required><br>

        <label for="information_4">Information 4:</label>
        <input type="text" id="information_4" name="information_4" required><br>

        <label for="information_5">Information 5:</label>
        <input type="text" id="information_5" name="information_5" required><br>

        <label for="information_6">Information 6:</label>
        <input type="text" id="information_6" name="information_6" required><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br>

        <label for="image">Package Image:</label>
        <input type="file" id="image" name="image" required><br>

        <input type="submit" value="Submit">
    </form>

</body>

</html>