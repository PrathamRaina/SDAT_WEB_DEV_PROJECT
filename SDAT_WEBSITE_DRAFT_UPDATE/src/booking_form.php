<?php
// Include your database configuration file
global $conn;
require_once 'databaseConfig.php';

// Fetch city names from the database using PDO
$query = "SELECT city_name FROM cities ORDER BY city_name ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$cities = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $cities[] = $row['city_name'];
}

// Close connection
$conn = null; // In PDO, setting the connection to null closes the connection
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EIREWAY_COACHES_booking</title>
    <link rel="stylesheet" href="css/booking_form_css.css">
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
    <div class="booking-form">
        <h2>Book Your Ticket</h2>
        <form action="submitTicket_viaObjects.php" method="post">
            <div class="form-group">
                <label for="departure">Departure:</label>
                <select id="from" name="departure" required>
                    <option value="">Select departure city</option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="destination">Destination:</label>
                <select id="destination" name="destination" required>
                    <option value="">Select destination city</option>
                    <?php foreach ($cities as $city): ?>
                        <option value="<?php echo htmlspecialchars($city); ?>"><?php echo htmlspecialchars($city); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- The rest of your form fields go here -->
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="numSeats">Seats:</label>
                <input type="number" id="numSeats" name="numSeats" required min="1">
            </div>
            <div class="form-group radio-group">
                <label>Seat Type:</label>
                <div class="radio-option">
                    <input type="radio" id="economy" name="seatType" value="Economy" required>
                    <label for="economy">Economy</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="premium" name="seatType" value="Premium">
                    <label for="premium">Premium</label>
                </div>
            </div>
            <div class="form-group">
                <button type="submit">BOOK TICKET</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
