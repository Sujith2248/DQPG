<?php
include "connection.php"; // Ensure database connection is included

class Institution
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Fetch all institutions
    public function getAllInstitutions()
    {
        $sql = "SELECT id, name, address, contact_number, status FROM institutions";
        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch a single institution by ID
    public function getInstitutionById($id)
    {
        $sql = "SELECT * FROM institutions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Insert a new institution
    public function addInstitution($data)
    {
        print_r($data);
        $sql = "INSERT INTO institutions (name, code, address, contact_number) 
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $data["name"],
            $data["code"],
            $data["address"],
            $data["contact_number"]
        );

        return $stmt->execute();
    }

    // Update an existing institution
    public function updateInstitution($id, $data)
    {
        $sql = "UPDATE institutions SET name = ?, code = ?, address = ?, contact_number = ? WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssi",
            $data["name"],
            $data["code"],
            $data["address"],
            $data["contact_number"],
            $id
        );

        return $stmt->execute();
    }

    // Delete an institution
    public function deleteInstitution($id)
    {
        $sql = "DELETE FROM institutions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
