<?php
require_once '../Ticket.php';
require_once '../databaseConfig.php';

//Function to check conditions of test(displays pass or fail message)
function assertEqual($actual, $expected, $message) {
    if ($actual !== $expected) {
        echo "Test Failed: $message. Expected: $expected, Actual: $actual\n";
    } else {
        echo "Test Passed: $message\n";
    }
}

//Master function to run all tests when called
function testTicketClass() {
    testConstructor();
    testSettersAndGetters();
    testInsertTicketDetails();
}

//Constructor test
function testConstructor() {
    // Mock Route object
    $route = new Route(1, 'A to B');

    $ticket = new Ticket($route, '2024-01-01', '10:00 AM', 'Economy', 2);
    assertEqual($ticket->getRoute()->getRouteID(), 1, 'Route ID from constructor');
    assertEqual($ticket->getDate(), '2024-01-01', 'Date from constructor');
    assertEqual($ticket->getTime(), '10:00 AM', 'Time from constructor');
    assertEqual($ticket->getSeatType(), 'Economy', 'Seat type from constructor');
    assertEqual($ticket->getNumSeats(), 2, 'Number of seats from constructor');
}

//Getters and setters test
function testSettersAndGetters() {
    //Mock Route object
    $route = new Route(1, 'A to B');

    $ticket = new Ticket($route, '2024-01-01', '10:00 AM', 'Economy', 2);
    $ticket->setTicketID(123);
    $ticket->setRoute(new Route(2, 'C to D'));
    $ticket->setDate('2024-02-02');
    $ticket->setTime('11:00 AM');
    $ticket->setSeatType('Business');
    $ticket->setNumSeats(1);

    assertEqual($ticket->getTicketID(), 123, 'Ticket ID after setting');
    assertEqual($ticket->getRoute()->getRouteID(), 2, 'Route ID after setting');
    assertEqual($ticket->getDate(), '2024-02-02', 'Date after setting');
    assertEqual($ticket->getTime(), '11:00 AM', 'Time after setting');
    assertEqual($ticket->getSeatType(), 'Business', 'Seat type after setting');
    assertEqual($ticket->getNumSeats(), 1, 'Number of seats after setting');
}

//insertTicketDetails method test
function testInsertTicketDetails() {
    //Mock global variable
    global $conn;
    $conn = new MockPDO(); // Assuming MockPDO class from previous example

    //Mock Route object
    $route = new Route(1, 'A to B');

    $ticket = new Ticket($route, '2024-01-01', '10:00 AM', 'Economy', 2);

    //Get output of insertTicketDetails method
    ob_start();
    $ticket->insertTicketDetails();
    $output = ob_get_clean();

    //Check output
    assertEqual(strpos($output, 'New ticket inserted successfully.') !== false, true, 'Insert ticket success message');
}

//Master function call
testTicketClass();
?>
