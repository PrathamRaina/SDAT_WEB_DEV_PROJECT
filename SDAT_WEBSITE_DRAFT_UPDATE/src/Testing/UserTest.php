<?php
require '../User.php';
require '../databaseConfig.php';

//Function to check conditions of test(displays pass or fail message)
function checkConditions($actual, $expected, $message) {
    if ($actual !== $expected) {
        echo "Test Failed: $message. Expected: $expected, Actual: $actual\n";
    } else {
        echo "Test Passed: $message\n";
    }
}

/*
Simulate a PDOStatement object for the test.
Provides mock implementations of the execute() and fetchAll() methods,
allowing test cases to simulate query execution and data retrieval without
interacting with our actual database.
*/
class MockPDOStatement {
    public function execute() {
        return true;
    }

    public function fetchAll() {
        return [
            ['user_id' => 1, 'name' => 'John', 'email' => 'john@example.com'],
            ['user_id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com'],
        ];
    }
}
/*
Simulates a PDO object for testing purposes.
It provides a mock implementation of the prepare() method,
returning a MockPDOStatement object when called.
This lets test cases isolate the code being tested from
our  actual database by replacing it with a mock object.
*/
class MockPDO {
    public function prepare($query) {
        return new MockPDOStatement();
    }
}

//Mock global variable
global $conn;
$conn = new MockPDO();

//Master function that runs all tests when called
function testUserClass() {
    testConstructor();
    testSettersAndGetters();
    testFetchAllUsers();
    testDisplayUser();
}

//Constructor test
function testConstructor() {
    $user = new User(1, 'John', 'john@example.com');
    checkConditions($user->getUserID(), 1, 'User ID from constructor');
    checkConditions($user->getName(), 'John', 'Name from constructor');
    checkConditions($user->getEmail(), 'john@example.com', 'Email from constructor');
}

//Getters and setters test
function testSettersAndGetters() {
    $user = new User();
    $user->setUserID(2);
    $user->setName('Jane');
    $user->setEmail('jane@example.com');
    checkConditions($user->getUserID(), 2, 'User ID after setting');
    checkConditions($user->getName(), 'Jane', 'Name after setting');
    checkConditions($user->getEmail(), 'jane@example.com', 'Email after setting');
}

//FetchAllUsers function test
function testFetchAllUsers() {
    $allUsers = User::fetchAllUsers();
    checkConditions(count($allUsers), 2, 'Number of users fetched');
    checkConditions($allUsers[0]->getUserID(), 1, 'User ID of first user');
    checkConditions($allUsers[0]->getName(), 'John', 'Name of first user');
    checkConditions($allUsers[0]->getEmail(), 'john@example.com', 'Email of first user');
    checkConditions($allUsers[1]->getUserID(), 2, 'User ID of second user');
    checkConditions($allUsers[1]->getName(), 'Jane', 'Name of second user');
    checkConditions($allUsers[1]->getEmail(), 'jane@example.com', 'Email of second user');
}

//displayUser method test
function testDisplayUser() {
    $user = new User(1, 'John', 'john@example.com');
    ob_start();
    $user->displayUser();
    $output = ob_get_clean();
    checkConditions($output, "UserID: 1<br>Name: John<br>Email: john@example.com<br><hr>", 'Display user details');
}

//Master function call
testUserClass();
?>
