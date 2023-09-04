<?php
// Start a session
session_start();

// Check if the user is an admin
if ($_SESSION['user_role'] !== 'admin') {
    // Redirect the user to the login page
    header('Location: index.php');
    exit;
}

include 'connect.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the values from the form
    $package_id = $_POST['package_id'];
    $package_name = isset($_POST['package_name']) ? $_POST['package_name'] : '';
    $package_price = isset($_POST['package_price']) ? $_POST['package_price'] : '';
    $information_1 = isset($_POST['information_1']) ? $_POST['information_1'] : '';
    $information_2 = isset($_POST['information_2']) ? $_POST['information_2'] : '';
    $information_3 = isset($_POST['information_3']) ? $_POST['information_3'] : '';
    $information_4 = isset($_POST['information_4']) ? $_POST['information_4'] : '';
    $information_5 = isset($_POST['information_5']) ? $_POST['information_5'] : '';
    $information_6 = isset($_POST['information_6']) ? $_POST['information_6'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // Check if the required fields are filled in
    if ($package_name && $package_price && $information_1 && $information_2 && $information_3 && $information_4 && $information_5 && $information_6 && $category) {
        // Prepare the SQL query to update the package
        $sql = "UPDATE packages SET package_name = '$package_name', package_price = '$package_price', information_1 = '$information_1',
                information_2 = '$information_2', information_3 = '$information_3', information_4 = '$information_4' , information_5 = '$information_5' , information_6 = '$information_6' , category = '$category' WHERE package_id = $package_id";

        // Check if a new image file was selected
        if (!empty($_FILES["image"]["name"])) {
            // $targetDir = "images/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow only specific file formats (e.g., JPEG, PNG)
            $allowedTypes = array('jpg', 'jpeg', 'png');
            if (in_array($fileType, $allowedTypes)) {
                // Upload the new image file to the server
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // File upload success, update the image_link column in the database
                    $imageLink = $targetFilePath;
                    $sql = "UPDATE packages SET package_name = '$package_name', package_price = '$package_price', information_1 = '$information_1',
                    information_2 = '$information_2', information_3 = '$information_3', information_4 = '$information_4' , information_5 = '$information_5' , information_6 = '$information_6' , category = '$category',
                    image_link = '$imageLink' WHERE package_id = $package_id";
                    // Execute the SQL query
                    if (mysqli_query($conn, $sql)) {
                        // Package update successful
                        header('Location: admin-listpackage_info.php');
                        exit;
                    } else {
                        // Package update failed
                        echo "Error updating package: " . mysqli_error($conn);
                    }
                } else {
                    // File upload failed
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                // Invalid file type
                echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            }
        } else {
            // Execute the SQL query
            if (mysqli_query($conn, $sql)) {
                // Package update successful
                header('Location: admin-listpackage_info.php');
                exit;
            } else {
                // Package update failed
                echo "Error updating package: " . mysqli_error($conn);
            }
        }
    }
}

// Fetch the package details from the database
$result = mysqli_query($conn, "SELECT * FROM packages WHERE package_id = $package_id");
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Package</title>
    <link rel="stylesheet" type="text/css" href="style\admin.css?v=<?php echo time(); ?>">
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

    <form style="margin-left: 28%;" method="POST" action="admin-updateform_package.php" enctype="multipart/form-data">
        <input type="hidden" name="package_id" value="<?php echo $row['package_id']; ?>">
        <label for="package_name">Package Name:</label>
        <input type="text" name="package_name" value="<?php echo $row['package_name']; ?>" required><br><br>
        <label for="package_price">Package Price:</label>
        <input type="text" name="package_price" value="<?php echo $row['package_price']; ?>" required><br><br>
        <label for="information_1">Information 1:</label>
        <input type="text" name="information_1" value="<?php echo $row['information_1']; ?>" required><br><br>
        <label for="information_2">Information 2:</label>
        <input type="text" name="information_2" value="<?php echo $row['information_2']; ?>" required><br><br>
        <label for="information_3">Information 3:</label>
        <input type="text" name="information_3" value="<?php echo $row['information_3']; ?>" required><br><br>
        <label for="information_4">Information 4:</label>
        <input type="text" name="information_4" value="<?php echo $row['information_4']; ?>" required><br><br>
        <label for="information_5">Information 5:</label>
        <input type="text" name="information_5" value="<?php echo $row['information_5']; ?>"><br><br>
        <label for="information_6">Information 6:</label>
        <input type="text" name="information_6" value="<?php echo $row['information_6']; ?>"><br><br>
        <label for="category">Category:</label>
        <input type="text" name="category" value="<?php echo $row['category']; ?>" required><br><br>
        <label for="image">Image:</label>
        <input type="file" name="image"><br><br>
        <input type="submit" value="Update">
    </form>
</body>

</html>