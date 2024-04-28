<?php
global $conn;
session_start();
require_once 'databaseConfig.php';
require_once 'Route.php';
require_once 'Ticket.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $seatType = $_POST['seatType'];
    $numSeats = $_POST['numSeats'];

    // Prepare and execute route query
    $routeQuery = "SELECT Route_ID FROM route WHERE routes = CONCAT(:departure, '-', :destination) OR routes = CONCAT(:destination, '-', :departure)";
    $stmt = $conn->prepare($routeQuery);
    $stmt->execute([':departure' => $departure, ':destination' => $destination]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {

        $routeId = $result['Route_ID'];
        $routeDetails = $departure . '-' . $destination; // Simplified, adjust as necessary

        $route = new Route($routeId, $routeDetails); // Creating a Route object

        // Create a Ticket object
        $ticket = new Ticket($route, $date, $time, $seatType, $numSeats);

        // Use the Ticket object to insert ticket details
        $ticket->insertTicketDetails();

        // Assuming insertTicketDetails method updates $this->ticket_ID with the last inserted ID
        $lastInsertedTicketID = $ticket->getTicketID();

        $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

        // Insert booking information with the last inserted ticket ID
        $insertBookingQuery = "INSERT INTO Booking (User_ID, Ticket_ID) VALUES (?, ?)";
        $bookingStmt = $conn->prepare($insertBookingQuery);
        if ($bookingStmt->execute([$userID, $lastInsertedTicketID])) {
            $_SESSION['Booking_ID'] = $conn->lastInsertId(); // Store the last inserted Booking_ID in the session
            header("Location: payment.php");
            exit();
        } else {
            echo "Error inserting booking.";
        }
    } else {
        echo "Route not found.";
    }
}
?>
