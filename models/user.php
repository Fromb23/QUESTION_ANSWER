<?php
include_once __DIR__ . '/../config/db.php';

class User {
	private $conn;
	private $table = "users";

	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $username;
	public $password;
	public $created_at;

	// constructor initialize the database connection
	public function __construct($db) {
		$this->conn = $db;
	}

	// create user
	public function register($firstname, $lastname, $email, $username, $phone, $password) {
		$query = "INSERT INTO " . $this->table . " (firstname, lastname, email, username, phone, password, created_at) 
				  VALUES (?, ?, ?, ?, ?, ?, ?)";
	
		$stmt = $this->conn->prepare($query);
	
		if (!$stmt) {
			die("Prepare failed: " . $this->conn->error);
		}
	
		// Hash the password
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$created_at = date("Y-m-d H:i:s");
	
		// ✅ Bind parameters correctly
		$stmt->bind_param("sssssss", $firstname, $lastname, $email, $username, $phone, $hashed_password, $created_at);
	
		if (!$stmt->execute()) {
			die("Execute failed: " . $stmt->error);
		}
	
		return true;
	}
	
	public function checkUserExists($email, $username) {
		$query = "SELECT id FROM " . $this->table . " WHERE email = ? OR username = ? LIMIT 1";
		$stmt = $this->conn->prepare($query);
	
		$stmt->bind_param("ss", $email, $username);
		$stmt->execute();
		$stmt->store_result();
	
		return $stmt->num_rows > 0;
	}

	// Authenticate user login
	public function login() {
        $query = "SELECT id, password FROM " . $this->table . " WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($this->id, $hashed_password);
            $stmt->fetch();
            return password_verify($this->password, $hashed_password);
        }
        return false;
    }

	// public function verifyEmail
	public function verifyEmail() {
		$query = "SELECT id FROM " . $this->table . " WHERE email = ? LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param("s", $this->email);
		$stmt->execute();
		$stmt->store_result();
		
		if ($stmt->num_rows > 0) {
			$stmt->bind_result($this->id);
			$stmt->fetch();
			return true;
		}
		return false;
	}

	// public funtion update password
	public function updatePassword() {
		$query = "UPDATE " . $this->table . " SET password = ? WHERE email = ?";
		$stmt = $this->conn->prepare($query);
		
		// Hash new password
		$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
		
		$stmt->bind_param("ss", $hashed_password, $this->email);
		
		return $stmt->execute();
	}

	 // Get User Details
	 public function getUserById($id) {
        $query = "SELECT id, firstname, lastname, username, email, phone FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

	// Update User Details
    public function updateUser() {
        $query = "UPDATE " . $this->table . " SET firstname = ?, lastname = ?, username = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $this->firstname, $this->lastname, $this->username, $this->email, $this->phone, $this->id);
        return $stmt->execute();
    }

	// Delete User Account
    public function deleteUser() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

	// Fetch All Users
	public function getAllUsers() {
    	$query = "SELECT id, firstname, lastname, username, email, phone FROM " . $this->table;
    	$stmt = $this->conn->prepare($query);
    	$stmt->execute();
    	$result = $stmt->get_result();
    
    	$users = [];
    	while ($row = $result->fetch_assoc()) {
	        $users[] = $row;
    	}
    	return $users;
	}
}

?>