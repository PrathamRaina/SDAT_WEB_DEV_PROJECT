<?php
session_start();

if(isset($_SESSION['booking_reference']) && isset($_SESSION['customer_name'])) {
    $bookingReference = $_SESSION['booking_reference'];
    $customerName = $_SESSION['customer_name']; // Use the customer name from the form
} else {
    // Redirect if required session variables are not set
    header("Location: home.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - EIREWAY COACHES</title>
    <link rel="stylesheet" href="css/home_style.css">
</head>
<body>
<!-- Your Header Here -->
<header class="header">
    <a href="#" class="logo">EIREWAY COACHES</a>
    <nav class="navbar">
        <div class="nav-links">
            <a href="home.html" class="nav-link">HOME</a>
            <a href="#" class="nav-link">ABOUT US</a>
            <a href="booking_form.php" class="nav-link">BOOK TICKET</a>
            <a href="#" class="nav-link">PAGES</a>
        </div>
        <div class="nav-links right">
            <a href="login.html" class="nav-link">LOGIN</a>
            <a href="registration.html" class="nav-link">REGISTER</a>
        </div>
    </nav>
</header>
<div class="container">
    <div class="central-text-section">
        <h1>Payment Successful!</h1>
        <p>Thank you, <b><?php echo htmlspecialchars($customerName); ?></b>. Your payment has been processed.</p>
        <p>Your booking reference number is: <b><?php echo htmlspecialchars($bookingReference); ?></b></p>
        <a href="booking_form.php" class="book-now-link">
            <button class="book-now-button">Book Another Trip</button>
        </a>
    </div>
</div>
</body>
</html>
