<?php
global $conn;
session_start();
require_once 'databaseConfig.php';

// This assumes you have the booking ID stored in the session or passed via GET/POST
$bookingID = isset($_SESSION['Booking_ID']) ? $_SESSION['Booking_ID'] : null;

$bookingInfo = null;
$totalAmount = 0;
$seatTypePrice = [
    'Economy' => 15,
    'Premium' => 30,
];

if ($bookingID) {
    // Retrieve booking information based on the Booking_ID using PDO
    $bookingQuery = "SELECT Booking.*, Ticket.*, Route.routes FROM Booking 
                     JOIN Ticket ON Booking.Ticket_ID = Ticket.Ticket_ID 
                     JOIN Route ON Ticket.Route_ID = Route.Route_ID 
                     WHERE Booking.Booking_ID = :bookingID";
    $stmt = $conn->prepare($bookingQuery);
    $stmt->bindParam(':bookingID', $bookingID, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $bookingInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        // Calculate the total amount due based on seat type and number of seats
        $totalAmount = $seatTypePrice[$bookingInfo['Seat_Type']] * $bookingInfo['num_seats'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/payment.css"> <!-- Update this path to your actual CSS file -->
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
    <div class="payment-form">
        <h2>PAYMENT INFORMATION </h2>
        <?php if ($bookingInfo): ?>
            <div class="booking-summary">
                <h3>Booking Summary</h3>
                <p>Route: <?php echo htmlspecialchars($bookingInfo['routes']); ?></p>
                <p>Date: <?php echo htmlspecialchars($bookingInfo['Date']); ?></p>
                <p>Time: <?php echo htmlspecialchars($bookingInfo['Time']); ?></p>
                <p>Seat Type: <?php echo htmlspecialchars($bookingInfo['Seat_Type']); ?></p>
                <p>Seats: <?php echo htmlspecialchars($bookingInfo['num_seats']); ?></p>
                <p>Total Amount Due: €<?php echo htmlspecialchars($totalAmount); ?></p>
            </div>
        <?php endif; ?>

        <form action="processPayment.php" method="post"> <!-- Make sure this action points to your payment processing script -->
            <div class="form-group">

                <label>Card Type:</label>
                <div class="radio-option">
                    <input type="radio" id="visa" name="cardType" value="Visa" required>
                    <label for="visa">Visa</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="mastercard" name="cardType" value="MasterCard" required>
                    <label for="mastercard">MasterCard</label>
                </div>
            </div>

            <div class="form-group">
                <label for="customerName">Customer Name:</label>
                <input type="text" id="customerName" name="customerName" required>
            </div>

            <div class="form-group">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber" required>
            </div>

            <div class="form-group">
                <label for="expiry">Expiry Date:</label>
                <input type="month" id="expiry" name="expiry" required>
            </div>

            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="transactionDate" required>
            </div>

            <div class="form-group">
                <button type="submit" class="pay-button">Pay</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
