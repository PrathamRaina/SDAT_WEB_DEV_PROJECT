<?php
// Start session to ensure we can access session variables
session_start();

// Check if the user is not logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EIREWAY_COACHES_Welcome</title>
    <link rel="stylesheet" href="css/home_style.css"> <!-- Ensure this path is correct -->
</head>
<body>
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
        <h1>Welcome, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b></h1>
        <p>Thank you for choosing Eireway Coaches. Your adventure through Ireland starts here. Ready to explore?</p>
        <a href="booking_form.php" class="book-now-link">
            <button class="book-now-button">Book Your Next Trip</button>
        </a>
    </div>
</div>
</body>
</html>
