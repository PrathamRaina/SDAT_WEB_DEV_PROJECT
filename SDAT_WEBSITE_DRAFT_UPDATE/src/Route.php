<?php
global $conn;
require_once 'databaseConfig.php';
class Route {
    private $routeID;
    private $routes;
    // Constructor
    public function __construct($routeID, $routes) {
        $this->routeID = $routeID;
        $this->routes = $routes;
    }

    // Setters
    public function setRouteID($routeID) {
        $this->routeID = $routeID;
    }
    public function setRoutes($routes) {
        $this->routes = $routes;
    }
    // Getters
    public function getRouteID() {
        return $this->routeID;
    }

    public function getRoutes() {
        return $this->routes;
    }

public function getRouteDetails(): string
{

    // Prepare the SQL statement
    global $conn;
    $stmt = $conn->prepare("SELECT Route_ID, routes FROM route WHERE Route_ID = :routeID");
    $stmt->bindParam(':routeID', $this->routeID, PDO::PARAM_INT);

    // Execute the query
    if ($stmt->execute()) {
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            // Return the detailed information about the route
            return "Route ID: " . $result['Route_ID'] . ", Details: " . $result['routes'];
        } else {
            return "No details found for Route ID: " . $this->routeID;
        }
    } else {
        return "Error fetching details for Route ID: " . $this->routeID;
    }
}
    public function displayRouteDetails() {
        $details = $this->getRouteDetails();
        echo $details;
    }

}

