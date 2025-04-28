<?php
include "connection.php";

class Question
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }

    // Add Question
    public function addQuestion($data)
    {
        $sql = "INSERT INTO questions (institution_id, department_id, semester, subject_id, question_text, marks, difficulty_level) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiisiss",  // i = integer, s = string
            $data['institution_id'],
            $data['department_id'],
            $data['semester'],
            $data['subject_id'],
            $data['question_text'],
            $data['marks'],
            $data['difficulty_level']
        );

        return $stmt->execute();
    }

    // Get All Questions with Institution, Department, and Subject Names
    public function getAllQuestions()
    {
        $sql = "SELECT q.id, q.question_text, q.marks, q.difficulty_level, q.semester,
                       i.name AS institution_name, d.name AS department_name, s.name AS subject_name
                FROM questions q
                LEFT JOIN institutions i ON q.institution_id = i.id
                LEFT JOIN departments d ON q.department_id = d.id
                LEFT JOIN subjects s ON q.subject_id = s.id";

        $result = $this->conn->query($sql);

        if (!$result) {
            die("Error fetching questions: " . $this->conn->error);
        }

        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Get Question by ID
    public function getQuestionById($id)
    {
        $sql = "SELECT * FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Update Question
    public function updateQuestion($id, $data)
    {
        $sql = "UPDATE questions SET institution_id = ?, department_id = ?, semester = ?, subject_id = ?, 
                question_text = ?, marks = ?, difficulty_level = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiisissi",
            $data['institution_id'],
            $data['department_id'],
            $data['semester'],
            $data['subject_id'],
            $data['question_text'],
            $data['marks'],
            $data['difficulty_level'],
            $id
        );
        return $stmt->execute();
    }

    // Delete Question
    public function deleteQuestion($id)
    {
        $sql = "DELETE FROM questions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Fetch all Institutions
    public function getAllInstitutions()
    {
        $sql = "SELECT id, name FROM institutions";
        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch Institution by ID
    public function getInstitutionById($id)
    {
        $sql = "SELECT id, name FROM institutions WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : ['id' => 0, 'name' => 'Unknown Institution'];
    }

    // Fetch Departments by Institution
    public function getDepartmentsByInstitutionId($institutionId)
    {
        $sql = "SELECT id, name FROM departments WHERE institution_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $institutionId);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch Department by ID
    public function getDepartmentById($id)
    {
        $sql = "SELECT id, name FROM departments WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : ['id' => 0, 'name' => 'Unknown Department'];
    }

    // Fetch Subjects by Department
    public function getSubjectsByDepartmentId($departmentId)
    {
        $sql = "SELECT id, name FROM subjects WHERE department_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $departmentId);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Fetch Subject by ID
    public function getSubjectById($id)
    {
        $sql = "SELECT id, name FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_assoc() : ['id' => 0, 'name' => 'Unknown Subject'];
    }
}

// Handle AJAX Request for Departments & Subjects
if (isset($_GET['institution_id'])) {
    $question = new Question();
    $departments = $question->getDepartmentsByInstitutionId($_GET['institution_id']);
    header('Content-Type: application/json');
    echo json_encode($departments);
    exit;
}

if (isset($_GET['department_id'])) {
    $question = new Question();
    $subjects = $question->getSubjectsByDepartmentId($_GET['department_id']);
    header('Content-Type: application/json');
    echo json_encode($subjects);
    exit;
}
?>