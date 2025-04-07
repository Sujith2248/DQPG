<?php
include "connection.php";
class QuestionPaper
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
    }


    // 1. Get All Question Papers (with institution, department, subject names)
    public function getAllPapers()
    {
        $sql = "SELECT qp.*, i.name AS institution_name, d.name AS department_name, 
                       s.name AS subject_name, u.first_name AS created_by_name
                FROM question_papers qp
                JOIN institutions i ON qp.institution_id = i.id
                JOIN departments d ON qp.department_id = d.id
                JOIN subjects s ON qp.subject_id = s.id
                JOIN users u ON qp.created_by = u.id
                ORDER BY qp.created_at DESC";

        $result = $this->conn->query($sql);
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 2. Get Single Paper By ID (with all questions & section info)
    public function getPaperById($paper_id)
    {
        $sql = "SELECT qp.*, i.name AS institution_name, d.name AS department_name, 
                       s.name AS subject_name, u.first_name AS created_by_name
                FROM question_papers qp
                JOIN institutions i ON qp.institution_id = i.id
                JOIN departments d ON qp.department_id = d.id
                JOIN subjects s ON qp.subject_id = s.id
                JOIN users u ON qp.created_by = u.id
                WHERE qp.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $paper_id);
        $stmt->execute();
        $paper = $stmt->get_result()->fetch_assoc();

        if (!$paper) return null;

        // Fetch questions in that paper
        $q_sql = "SELECT qpq.*, q.question_text, q.difficulty_level
                  FROM question_paper_questions qpq
                  JOIN questions q ON qpq.question_id = q.id
                  WHERE qpq.paper_id = ?
                  ORDER BY section_name, question_order";

        $stmt_q = $this->conn->prepare($q_sql);
        $stmt_q->bind_param("i", $paper_id);
        $stmt_q->execute();
        $questions = $stmt_q->get_result()->fetch_all(MYSQLI_ASSOC);

        $paper['questions'] = $questions;
        return $paper;
    }

    // 3. Delete Paper and its Questions
    public function deletePaper($paper_id)
    {
        // Delete questions first (foreign key with CASCADE works too)
        $stmt1 = $this->conn->prepare("DELETE FROM question_paper_questions WHERE paper_id = ?");
        $stmt1->bind_param("i", $paper_id);
        $stmt1->execute();

        // Delete paper
        $stmt2 = $this->conn->prepare("DELETE FROM question_papers WHERE id = ?");
        $stmt2->bind_param("i", $paper_id);
        return $stmt2->execute();
    }

    // 4. Update Paper Metadata (not the questions)
    public function updatePaper($paper_id, $data)
    {
        $sql = "UPDATE question_papers SET
                    institution_id = ?, department_id = ?, subject_id = ?, semester = ?,
                    exam_name = ?, exam_code = ?, academic_year = ?, updated_at = NOW()
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiisssii",
            $data['institution_id'],
            $data['department_id'],
            $data['subject_id'],
            $data['semester'],
            $data['exam_name'],
            $data['exam_code'],
            $data['academic_year'],
            $paper_id
        );
        return $stmt->execute();
    }

    // 5. Filter papers by institute, department, subject, semester
    public function getPapersByFilter($filters = [])
    {
        $conditions = [];
        $params = [];
        $types = "";

        if (!empty($filters['institution_id'])) {
            $conditions[] = "qp.institution_id = ?";
            $params[] = $filters['institution_id'];
            $types .= "i";
        }
        if (!empty($filters['department_id'])) {
            $conditions[] = "qp.department_id = ?";
            $params[] = $filters['department_id'];
            $types .= "i";
        }
        if (!empty($filters['subject_id'])) {
            $conditions[] = "qp.subject_id = ?";
            $params[] = $filters['subject_id'];
            $types .= "i";
        }
        if (!empty($filters['semester'])) {
            $conditions[] = "qp.semester = ?";
            $params[] = $filters['semester'];
            $types .= "i";
        }

        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

        $sql = "SELECT qp.*, i.name AS institution_name, d.name AS department_name, 
                       s.name AS subject_name
                FROM question_papers qp
                JOIN institutions i ON qp.institution_id = i.id
                JOIN departments d ON qp.department_id = d.id
                JOIN subjects s ON qp.subject_id = s.id
                $whereClause
                ORDER BY qp.created_at DESC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 6. Get Semester by Subject ID (from subjects table)
    public function getSemesterBySubject($subject_id)
    {
        $sql = "SELECT semester FROM subjects WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['semester'];
        }

        return null; // or 0 or ''
    }
}

if (isset($_GET['semester_id'])) {

    $question = new QuestionPaper();
    $semester = $question->getSemesterBySubject($_GET['semester_id']);
    print_r($semester);
    exit(1);
    if ($semester !== null) {
        echo "<option value='$semester' selected>Semester $semester</option>";
    } else {
        echo "<option value=''>No Semester Found</option>";
    }
    exit;
}
