<?php
require 'databaseConfig.php';

global $conn;

class User {
    protected $userID;
    protected $name;
    protected $email;

    // Constructor
    public function __construct($userID = null, $name = null, $email = null) {
        $this->userID = $userID;
        $this->name = $name;
        $this->email = $email;
    }

    // Setters and Getters
    public function setUserID($userID) {
        $this->userID = $userID;
    }
    public function getUserID() {
        return $this->userID;
    }

    public function setName($name) {
        $this->name = $name;
    }
    public function getName() {
        return $this->name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }

    // Static method to fetch users from the database
    public static function fetchAllUsers() {
        global $conn;
        $query = "SELECT user_id, name, email FROM user"; // Query adjusted to fetch only userID, name, and email
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $allUsers = array();

        foreach ($rows as $row) {
            $user = new User($row['user_id'], $row['name'], $row['email']);
            $allUsers[] = $user;
        }

        return $allUsers;
    }

    // Method to display user details
    public function displayUser() {
        echo "UserID: " . $this->getUserID() . "<br>";
        echo "Name: " . $this->getName() . "<br>";
        echo "Email: " . $this->getEmail() . "<br><hr>";
    }
}

// Example usage
$allUsers = User::fetchAllUsers();
foreach ($allUsers as $user) {
    $user->displayUser();
}
?>
