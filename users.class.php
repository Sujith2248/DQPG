<?php
include "connection.php"; // Include database connection

class User
{
    private $conn;

    public function __construct()
    {
        global $conn; // Use existing database connection
        $this->conn = $conn;
    }

    //Fetch all users
    public function getAllUsers()
    {
        $sql = "SELECT id, first_name, last_name, phone_number, email, role, address, gender, status FROM users";
        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch a single user by ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Add a new user
    public function addUser($data)
    {
        $sql = "INSERT INTO users ( first_name, last_name, email, phone_number, password, role, address, gender) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $hashedPassword = password_hash($data["password"], PASSWORD_BCRYPT); // Hash password for security
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssssss",
            $data["first_name"],
            $data["last_name"],
            $data["email"],
            $data["phone_number"],
            $hashedPassword,
            $data["role"],
            $data["address"],
            $data["gender"]
        );
        return $stmt->execute();
    }

    // Update an existing user
    public function updateUser($id, $data)
    {
        $sql = "UPDATE users SET  first_name = ?, last_name = ?, email = ?, phone_number = ?, role = ?, address = ?, gender = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "sssssssi",
            $data["first_name"],
            $data["last_name"],
            $data["email"],
            $data["phone_number"],
            $data["role"],
            $data["address"],
            $data["gender"],
            $id
        );
        return $stmt->execute();
    }

    // Delete a user
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
