<?php
session_start();
include('questions.class.php');

// Instantiate the Question class
$question = new Question();

// Get POST data from createPaper.php
$institutionId = $_POST['institution'] ?? '';
$departmentId = $_POST['department'] ?? '';
$subjectId = $_POST['subject'] ?? '';
$semester = $_POST['semester'] ?? '';
$examName = $_POST['examName'] ?? 'MODEL EXAMINATION';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '2';
$maxMarks = $_POST['totmarks'] ?? 50;
$noOfSections = $_POST['noofsections'] ?? 0;

// Fetch institution, department, and subject names using their IDs
$institution = $institutionId ? $question->getInstitutionById($institutionId)['name'] : 'Institution Name';
$department = $departmentId ? $question->getDepartmentById($departmentId)['name'] : 'Department';
$subject = $subjectId ? $question->getSubjectById($subjectId)['name'] : 'Subject';
$subjectCode = "BIT6B14"; // Hardcoded as per the image; you can make this dynamic if needed

// Format date
$formattedDate = '';
if (!empty($date)) {
    $formattedDate = date('M Y', strtotime($date));
}

// Clean time and add Hours properly
$cleanTime = trim(str_ireplace('hours', '', $time));
$cleanTime = $cleanTime . ' Hours';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Digitalized Question Paper</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }
        .page {
            width: 100%;
            padding: 15mm;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .header p {
            margin: 5px 0;
        }
        .header .details {
            font-weight: normal;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        .question-section {
            margin-bottom: 20px;
            text-align: center;
        }
        .question-section h3 {
            margin: 10px 0;
            text-decoration: underline;
            font-size: 16px;
        }
        .question-section .instructions {
            font-style: italic;
            margin-bottom: 10px;
        }
        .question-section .marks {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .question {
            margin-bottom: 8px;
            text-align: left;
        }
        ol {
            padding-left: 20px;
            margin: 8px 0;
            text-align: left;
        }
        #print-btn {
            display: block;
            margin: 20px auto;
            background-color: rgb(51, 150, 153);
            color: white;
            border-radius: 20px;
            width: 120px;
            height: 35px;
            font-size: 1.2em;
            border: none;
            cursor: pointer;
        }
        #print-btn:hover {
            background-color: rgb(26, 83, 93);
        }
    </style>
</head>
<body>

<div class='page'>
    <div class='header'>
        <p><?= htmlspecialchars(strtoupper($institution)) ?></p>
        <p><?= htmlspecialchars(strtoupper($semester . " SEMESTER B.Sc IT " . $examName . " " . $formattedDate)) ?></p>
        <p><?= htmlspecialchars(strtoupper($subjectCode . ": " . $subject)) ?></p>
        <div class="details">
            <p>Time: <?= htmlspecialchars($cleanTime) ?></p>
            <p>Max. marks: <?= htmlspecialchars($maxMarks) ?></p>
        </div>
    </div>

    <?php
    // Define part configurations
    $parts = [
        1 => ['name' => 'A', 'instruction' => 'ANSWER ALL THE QUESTIONS', 'marks_per_question' => 1, 'total_marks' => 4],
        2 => ['name' => 'B', 'instruction' => 'ANSWER ALL THE QUESTIONS', 'marks_per_question' => 2, 'total_marks' => 8],
        3 => ['name' => 'C', 'instruction' => 'ANSWER ANY THREE', 'marks_per_question' => 4, 'total_marks' => 12],
        4 => ['name' => 'D', 'instruction' => 'ANSWER ANY TWO', 'marks_per_question' => 8, 'total_marks' => 16],
    ];

    // Loop through each section (A, B, C, D)
    for ($i = 1; $i <= min($noOfSections, 4); $i++) {
        $part = $parts[$i];
        $questionFieldPrefix = "section" . $i . "_question";
        $questions = [];

        // Find all matching question keys from POST
        foreach ($_POST as $key => $value) {
            if (strpos($key, $questionFieldPrefix) === 0) {
                $questions[] = $value;
            }
        }

        // Output the section if it has questions
        if (!empty($questions)) {
            echo "<div class='question-section'>";
            echo "<h3>PART - " . $part['name'] . "</h3>";
            echo "<p class='instructions'>(" . $part['instruction'] . ")</p>";
            echo "<p class='marks'>" . count($questions) . " × " . $part['marks_per_question'] . " = " . $part['total_marks'] . "</p>";
            echo "<ol>";
            foreach ($questions as $q) {
                echo "<li class='question'>" . htmlspecialchars($q) . "</li>";
            }
            echo "</ol>";
            echo "</div>";
        }
    }
    ?>
</div>

<button id="print-btn" onclick="window.print()">Print</button>

</body>
</html>