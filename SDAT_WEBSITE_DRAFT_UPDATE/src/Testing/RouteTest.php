<?php
require_once '../Route.php';
require_once '../databaseConfig.php';

//Function to check conditions of test(displays pass or fail message)
function checkConditions($actual, $expected, $message) {
    if ($actual !== $expected) {
        echo "Test Failed: $message. Expected: $expected, Actual: $actual\n";
    } else {
        echo "Test Passed: $message\n";
    }
}

//Master function to run all tests when called
function testRouteClass() {
    testConstructor();
    testSettersAndGetters();
    testGetRouteDetails();
}

//Constructor test
function testConstructor() {
    $route = new Route(1, 'A to B');
    checkConditions($route->getRouteID(), 1, 'Route ID from constructor');
    checkConditions($route->getRoutes(), 'A to B', 'Routes from constructor');
}

//Getters and setters test
function testSettersAndGetters() {
    $route = new Route();
    $route->setRouteID(2);
    $route->setRoutes('C to D');
    checkConditions($route->getRouteID(), 2, 'Route ID after setting');
    checkConditions($route->getRoutes(), 'C to D', 'Routes after setting');
}

//getRouteDetails method test
function testGetRouteDetails() {
    //Mock global variable
    global $conn;
    //Using MockPDO (described in UserTest.)
    $conn = new MockPDO();

    $route = new Route(1, 'A to B');

    //Get output of getRouteDetails method
    ob_start();
    $route->displayRouteDetails();
    $output = ob_get_clean();

    //Check output
    checkConditions(strpos($output, 'Route ID: 1, Details: A to B') !== false, true, 'Get route details success message');
}

//Master function call
testRouteClass();
?>

