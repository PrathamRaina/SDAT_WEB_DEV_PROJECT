<?php
global $conn;
session_start();
require_once 'databaseConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $seatType = $_POST['seatType'];
    $numSeats = $_POST['numSeats'];

    // Prepare route query using named placeholders
    $routeQuery = "SELECT Route_ID FROM route WHERE routes = CONCAT(:departure, '-', :destination) OR routes = CONCAT(:destination, '-', :departure)";
    $stmt = $conn->prepare($routeQuery);
    // Bind parameters
    $stmt->execute([':departure' => $departure, ':destination' => $destination]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $routeId = $result['Route_ID'];

        // Prepare insert ticket query
        $insertTicketQuery = "INSERT INTO TICKET (Route_ID, Date, Time, Seat_Type, num_seats) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertTicketQuery);

        // Execute query with an array of values
        $insertStmt->execute([$routeId, $date, $time, $seatType, $numSeats]);
        $lastInsertedTicketID = $conn->lastInsertId(); // Get the last inserted id
        $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

        // Prepare insert booking query
        $insertBookingQuery = "INSERT INTO Booking (User_ID, Ticket_ID) VALUES (?, ?)";
        $bookingStmt = $conn->prepare($insertBookingQuery);
        if ($bookingStmt->execute([$userID, $lastInsertedTicketID])) {
            $_SESSION['Booking_ID'] = $conn->lastInsertId(); // Store the last inserted Booking_ID in the session
            header("Location: payment.php"); // Redirect to payment.php
            exit();
        } else {
            echo "Error inserting booking.";
        }
    } else {
        echo "Route not found.";
    }
}
?>
