<?php
require_once 'databaseConfig.php';
require_once 'Route.php';
class Ticket
{
    private $ticket_ID;
    private $route; // Reference to a Route object
    private $Date;
    private $Time;
    private $Seat_Type;
    private $num_seats;

    // Constructor
    public function __construct( Route $route, $Date, $Time, $Seat_Type, $num_seats)
    {
        $this->route = $route;
        $this->Date = $Date;
        $this->Time = $Time;
        $this->Seat_Type = $Seat_Type;
        $this->num_seats = $num_seats;
    }

    // Setters
    public function setTicketID($ticket_ID)
    {
        $this->ticket_ID = $ticket_ID;
    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
    }

    public function setDate($Date)
    {
        $this->Date = $Date;
    }

    public function setTime($Time)
    {
        $this->Time = $Time;
    }

    public function setSeatType($Seat_Type)
    {
        $this->Seat_Type = $Seat_Type;
    }

    public function setNumSeats($num_seats)
    {
        $this->num_seats = $num_seats;
    }

    // Getters
    public function getTicketID()
    {
        return $this->ticket_ID;
    }

    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getDate()
    {
        return $this->Date;
    }

    public function getTime()
    {
        return $this->Time;
    }

    public function getSeatType()
    {
        return $this->Seat_Type;
    }

    public function getNumSeats()
    {
        return $this->num_seats;
    }

    public function insertTicketDetails()
    {
        global $conn;

        // Prepare the SQL statement to insert ticket details without specifying ticket_ID
        $stmt = $conn->prepare("INSERT INTO ticket (Route_ID, Date, Time, Seat_Type, num_seats) VALUES (:Route_ID, :Date, :Time, :Seat_Type, :num_seats)");

        // Assign method results to variables
        $routeID = $this->route->getRouteID();

        // Bind parameters
        $stmt->bindValue(':Route_ID', $routeID, PDO::PARAM_INT);
        $stmt->bindValue(':Date', $this->Date);
        $stmt->bindValue(':Time', $this->Time);
        $stmt->bindValue(':Seat_Type', $this->Seat_Type);
        $stmt->bindValue(':num_seats', $this->num_seats, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo "New ticket inserted successfully.<br>";
        } else {
            echo "Error inserting ticket details.<br>";
        }
    }
}
/*
$routeID = 19; // Example route ID
$routeDetails = "";
$route = new Route($routeID, $routeDetails);

// Instantiate Ticket object without $ticket_ID
$Date = "2024-01-01";
$Time = "10:00 AM";
$Seat_Type = "Economy";
$num_seats = 2;
$ticket = new Ticket($route, $Date, $Time, $Seat_Type, $num_seats);

// Insert the ticket details into the database
$ticket->insertTicketDetails();*/

