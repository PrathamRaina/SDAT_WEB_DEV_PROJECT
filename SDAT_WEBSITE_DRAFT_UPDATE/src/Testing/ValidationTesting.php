<?php
require_once 'databaseConfig.php';

//Master function to test validation when called
function testValidation()
{
    testRegistrationFormValidation();
    testLoginFormValidation();
    testBookingFormValidation();
    testPaymentFormValidation();
}

//Set the present date for testing (April 29, 2024)
$currentDate = '2024-04-29';

//Test Case 1: Registration Form Validation
function testRegistrationFormValidation()
{
    global $conn;

    //Test unique email address validation
    $testEmail = 'test@example.com';
    $emailCheckQuery = "SELECT COUNT(*) AS count FROM user WHERE email = :email";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bindParam(':email', $testEmail);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['count'] > 0) {
        echo "Test Case 1.1: Unique Email Address Validation - FAIL\n";
    } else {
        echo "Test Case 1.1: Unique Email Address Validation - PASS\n";
    }

    //Test password criteria validation
    $testPassword = 'Test123!';
    $passwordPattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"; // Define the password criteria pattern
    if (!preg_match($passwordPattern, $testPassword)) {
        echo "Test Case 1.2: Password Criteria Validation - FAIL\n";
    } else {
        echo "Test Case 1.2: Password Criteria Validation - PASS\n";
    }
}

//Test Case 2: Login Form Validation
function testLoginFormValidation()
{
    global $conn;

    //Test email address exists validation
    $testEmail = 'test@example.com';
    $password = 'Test123!';
    $sql = "SELECT * FROM user WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $testEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "Test Case 2.1: Email Address Exists Validation - FAIL\n";
    } else {
        echo "Test Case 2.1: Email Address Exists Validation - PASS\n";
    }

    //Test password matches validation
    if (!password_verify($password, $user['password'])) {
        echo "Test Case 2.2: Password Matches Validation - FAIL\n";
    } else {
        echo "Test Case 2.2: Password Matches Validation - PASS\n";
    }
}

//Test Case 3: Booking Form Validation
function testBookingFormValidation()
{
    global $conn, $currentDate;

    //Test valid routes validation
    $departure = 'Dublin'; // Sample departure
    $destination = 'Cork'; // Sample destination
    $routeQuery = "SELECT COUNT(*) AS count FROM route WHERE routes = CONCAT(:departure, '-', :destination) OR routes = CONCAT(:destination, '-', :departure)";
    $stmt = $conn->prepare($routeQuery);
    $stmt->execute([':departure' => $departure, ':destination' => $destination]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result['count'] == 0) {
        echo "Test Case 3.1: Valid Routes Validation - FAIL\n";
    } else {
        echo "Test Case 3.1: Valid Routes Validation - PASS\n";
    }

    //Test future date and time validation
    $date = '2024-05-01';
    $time = '12:00';
    if ($date < $currentDate || ($date == $currentDate && $time < date('H:i'))) {
        echo "Test Case 3.2: Future Date and Time Validation - FAIL\n";
    } else {
        echo "Test Case 3.2: Future Date and Time Validation - PASS\n";
    }

    //Test number of seats requested validation
    $numSeats = 2; // Sample number of seats
    if (!is_numeric($numSeats) || $numSeats <= 0 || floor($numSeats) != $numSeats) {
        echo "Test Case 3.3: Number of Seats Requested Validation - FAIL\n";
    } else {
        echo "Test Case 3.3: Number of Seats Requested Validation - PASS\n";
    }
}

//Test Case 4: Payment Form Validation
function testPaymentFormValidation()
{
    global $currentDate;

    //Test transaction future date validation
    $transactionDate = '2024-05-01';
    if ($transactionDate < $currentDate) {
        echo "Test Case 4.1: Future Date Validation - FAIL\n";
    } else {
        echo "Test Case 4.1: Future Date Validation - PASS\n";
    }

    //Test customer name not empty validation
    $customerName = '';
    if (empty($customerName)) {
        echo "Test Case 4.2: Customer Name Not Empty Validation - FAIL\n";
    } else {
        echo "Test Case 4.2: Customer Name Not Empty Validation - PASS\n";
    }
}

//Master function call
testValidation();
?>
