<?php
require_once 'User.php';

class Customer extends User {
    protected $phone;
    protected $address;
    protected $password;

    // Constructor
    public function __construct($userID = null, $name = null, $email = null, $phone = null, $address = null, $password = null) {
        parent::__construct($userID, $name, $email); // Call the parent constructor
        $this->phone = $phone;
        $this->address = $address;
        $this->password = $password; // In practice, remember to hash the password
    }

    // Additional Setters and Getters for the new attributes
    public function setPhone($phone) {
        $this->phone = $phone;
    }
    public function getPhone() {
        return $this->phone;
    }

    public function setAddress($address) {
        $this->address = $address;
    }
    public function getAddress() {
        return $this->address;
    }

    public function setPassword($password) {
        $this->password = $password; // Ensure this is hashed appropriately
    }
    public function getPassword() {
        return $this->password;
    }

    // Method to add a customer to the database
    public function addUser() {
        global $conn;
        $query = "INSERT INTO user (name, email, phone, address, password) VALUES (:name, :email, :phone, :address, :password)";
        $stmt = $conn->prepare($query);

        // Bind the values from this Customer instance to the query
        $stmt->bindValue(':name', $this->getName());
        $stmt->bindValue(':email', $this->getEmail());
        $stmt->bindValue(':phone', $this->getPhone());
        $stmt->bindValue(':address', $this->getAddress());
        $stmt->bindValue(':password', $this->getPassword());

        // Execute the query and check for success
        if ($stmt->execute()) {
            echo "New customer added successfully.<br>";
        } else {
            echo "Error adding new customer.<br>";
        }
    }
}
// Example usage
$customer = new Customer();
$customer->addUser();