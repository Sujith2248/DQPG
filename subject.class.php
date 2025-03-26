<?php
include "connection.php"; // Include database connection

class Subject
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Fetch all subjects with institution and department details
    public function getAllSubjects()
    {
        $sql = "SELECT s.id, s.name AS subject_name, s.subject_code, 
                i.name AS institution_name, d.name AS department_name, 
                u.first_name AS created_by
         FROM subjects s
         JOIN institutions i ON s.institution_id = i.id
         JOIN departments d ON s.department_id = d.id
         LEFT JOIN users u ON s.created_by = u.id";

        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch a single subject by ID
    public function getSubjectById($id)
    {
        $sql = "SELECT * FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Insert a new subject
    public function addSubject($data)
    {
        $sql = "INSERT INTO subjects (institution_id, department_id, name, subject_code, created_by) 
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iissi",
            $data["institution_id"],
            $data["department_id"],
            $data["name"],
            $data["subject_code"],
            $data["created_by"]
        );

        return $stmt->execute();
    }

    // Update an existing subject
    public function updateSubject($id, $data)
    {
        $sql = "UPDATE subjects SET institution_id = ?, department_id = ?, name = ?, subject_code = ?, created_by = ? 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iissii",
            $data["institution_id"],
            $data["department_id"],
            $data["name"],
            $data["subject_code"],
            $data["created_by"],
            $id
        );

        return $stmt->execute();
    }

    // Delete a subject
    public function deleteSubject($id)
    {
        $sql = "DELETE FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    // Fetch departments based on institution ID (Moved from `Department.php`)
    public function getDepartmentsByInstitutionId($institutionId)
    {
        $sql = "SELECT id, name FROM departments WHERE institution_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $institutionId);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}

// Handle AJAX request to fetch departments
if (isset($_GET['institution_id'])) {
    $subject = new Subject();
    $institutionId = $_GET['institution_id'];
    $departments = $subject->getDepartmentsByInstitutionId($institutionId);
    echo json_encode($departments);
    exit;
}
