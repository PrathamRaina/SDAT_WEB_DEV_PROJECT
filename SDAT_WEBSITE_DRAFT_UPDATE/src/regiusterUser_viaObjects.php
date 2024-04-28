<?php
require 'databaseConfig.php'; // Ensure this file contains the correct PDO connection setup
require 'User.php'; // Your User class file
require 'Customer.php'; // Your Customer class file

// Check if the form data has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $password = $_POST['password'] ?? ''; // Password should be hashed before storage

    // Validate and sanitize the input data here

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create a new Customer object with the form data
    $customer = new Customer(null, $name, $email, $phone, $address, $hashedPassword);

    // Add the new customer to the database
    $customer->addUser();

    // Redirect to the login page after registration
    header('Location: login.html');
    exit();
}

