<?php
class Department
{
    private $conn;

    // Constructor: Include database connection automatically
    public function __construct()
    {
        include "connection.php"; // Include the existing database connection
        $this->conn = $conn; // Use the connection from config.php
    }

    // Fetch all departments
    public function getAllDepartments()
    {
        $sql = "SELECT d.id, d.name AS department_name, d.department_code, d.description, 
                       i.name AS institution_name 
                FROM departments d 
                JOIN institutions i ON d.institution_id = i.id";

        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch a single department by ID
    public function getDepartmentById($id)
    {
        $sql = "SELECT * FROM departments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Insert a new department
    public function addDepartment($data)
    {
        $sql = "INSERT INTO departments (institution_id, name, department_code, description) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isss", $data["insId"], $data["depName"], $data["depCode"], $data["depDescription"]);
        return $stmt->execute();
    }

    // Update an existing department
    public function updateDepartment($id, $data)
    {
        $sql = "UPDATE departments SET institution_id = ?, name = ?, department_code = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssi", $data["insId"], $data["depName"], $data["depCode"], $data["depDescription"], $id);
        return $stmt->execute();
    }

    // Delete a department
    public function deleteDepartment($id)
    {
        $sql = "DELETE FROM departments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    // Fetch institutions for dropdown
    public function getInstitutions()
    {
        $sql = "SELECT id, name FROM institutions WHERE status = 1";
        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
