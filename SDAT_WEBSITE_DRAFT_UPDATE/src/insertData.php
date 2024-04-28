<?php
// Include database configuration file
global $conn;
require_once 'databaseConfig.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = trim($_POST['password']);

    // Password hashing for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare an insert statement
    $sql = "INSERT INTO user (name, email, phone, address, password) VALUES (:name, :email, :phone, :address, :password)";

    try {
        $stmt = $conn->prepare($sql);

        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page after successful registration
            header("location: login.html");
        } else {
            echo "Something went wrong. Please try again later.";
        }
    } catch (PDOException $e) {
        echo "Error preparing the query: " . $e->getMessage();
    }

    // Close connection
    $conn = null;
}
?>
