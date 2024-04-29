<?php
require_once '../Customer.php';
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
function testCustomerClass() {
    testConstructor();
    testSettersAndGetters();
    testAddUser();
}

//Constructor test
function testConstructor() {
    $customer = new Customer(1, 'John Doe', 'john@example.com', '1234567890', '123 Main St', 'password123');
    checkConditions($customer->getUserID(), 1, 'User ID from constructor');
    checkConditions($customer->getName(), 'John Doe', 'Name from constructor');
    checkConditions($customer->getEmail(), 'john@example.com', 'Email from constructor');
    checkConditions($customer->getPhone(), '1234567890', 'Phone from constructor');
    checkConditions($customer->getAddress(), '123 Main St', 'Address from constructor');
    checkConditions($customer->getPassword(), 'password123', 'Password from constructor');
}

//Getters and setters test
function testSettersAndGetters() {
    $customer = new Customer();
    $customer->setUserID(2);
    $customer->setName('Jane Doe');
    $customer->setEmail('jane@example.com');
    $customer->setPhone('9876543210');
    $customer->setAddress('456 Elm St');
    $customer->setPassword('newpassword');
    checkConditions($customer->getUserID(), 2, 'User ID after setting');
    checkConditions($customer->getName(), 'Jane Doe', 'Name after setting');
    checkConditions($customer->getEmail(), 'jane@example.com', 'Email after setting');
    checkConditions($customer->getPhone(), '9876543210', 'Phone after setting');
    checkConditions($customer->getAddress(), '456 Elm St', 'Address after setting');
    checkConditions($customer->getPassword(), 'newpassword', 'Password after setting');
}

//addUser method test
function testAddUser() {
    //Mock global variable
    global $conn;
    //Using MockPDO (described in UserTest.)
    $conn = new MockPDO();

    $customer = new Customer();
    $customer->setName('Test Customer');
    $customer->setEmail('test@example.com');
    $customer->setPhone('5555555555');
    $customer->setAddress('789 Oak St');
    $customer->setPassword('testpassword');

    //Get output of addUser method
    ob_start();
    $customer->addUser();
    $output = ob_get_clean();

    //Check output
    checkConditions(strpos($output, 'New customer added successfully.') !== false, true, 'Add user success message');
}

//Master function call
testCustomerClass();
?>

