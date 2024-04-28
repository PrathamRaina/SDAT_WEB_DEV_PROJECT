<?php
global $conn;
session_start();
require_once 'databaseConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['Booking_ID'], $_POST['transactionDate'],  $_POST['customerName'])) {
    $bookingID = $_SESSION['Booking_ID'];
    $transactionDate = $_POST['transactionDate'];
    $customerName = $_POST['customerName'];

    // Generate a unique 5-digit booking reference number
    $bookingReferenceNumber = random_int(10000, 99999);

    try {
        $sql = "INSERT INTO PAYMENT (Booking_ID, Transaction_Date) VALUES (:bookingID, :transactionDate)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
        $stmt->bindParam(':transactionDate', $transactionDate, PDO::PARAM_STR);
        $stmt->execute();

        // Store customer name and booking reference in session for the success page
        $_SESSION['customer_name'] = $customerName;
        $_SESSION['booking_reference'] = $bookingReferenceNumber;

        // Redirect to the success page
        header("Location: paymentSuccess.php");
        exit();
    } catch (PDOException $e) {
        // Handle error
        $_SESSION['payment_error'] = "Payment processing failed. Please try again.";
        header("Location: paymentError.php");
        exit();
    }
}
?>