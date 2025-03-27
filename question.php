<?php
include('header.php');
include('questions.class.php');

$question = new Question();
$editMode = false;
$questionData = [
    "institution_id" => "",
    "department_id" => "",
    "semester" => "",
    "subject_id" => "",
    "question_text" => "",
    "marks" => "",
    "difficulty_level" => ""
];

// Check if editing an existing question
if (isset($_GET['id'])) {
    $editMode = true;
    $questionId = $_GET['id'];
    $existingQuestion = $question->getQuestionById($questionId);

    if (!$existingQuestion) {
        die("<script>alert('Question not found!'); window.location='allQuestions.php';</script>");
    }

    $questionData = $existingQuestion;
}

// Handle Form Submission (Add or Update)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "institution_id" => $_POST["institution"],
        "department_id" => $_POST["department"],
        "semester" => $_POST["semester"],
        "subject_id" => $_POST["subject"],
        "question_text" => $_POST["question"],
        "marks" => $_POST["mark"],
        "difficulty_level" => $_POST["difficulty"]
    ];


    if ($editMode) {
        if ($question->updateQuestion($questionId, $data)) {
            echo "<script>alert('Question updated successfully!'); window.location='allQuestions.php';</script>";
        } else {
            echo "<script>alert('Failed to update question.');</script>";
        }
    } else {
        if ($question->addQuestion($data)) {
            echo "<script>alert('Question added successfully!'); window.location='allQuestions.php';</script>";
        } else {
            echo "<script>alert('Failed to add question.');</script>";
        }
    }
}

// Fetch Institutions, Departments, and Subjects
$institutions = $question->getAllInstitutions();
$departments = ($editMode) ? $question->getDepartmentsByInstitutionId($questionData["institution_id"]) : [];
$subjects = ($editMode) ? $question->getSubjectsByDepartmentId($questionData["department_id"]) : [];
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $editMode ? "Edit" : "Add" ?> Question</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style type="text/css">
        .bottom {
            position: inherit;
            background-color: rgb(31, 104, 117);
            color: white;
            padding: 20px;
            padding-left: 60px;
            margin: 10px 0px 0px 0px;
        }

        h1 {
            color: white;
            font-weight: lighter;
        }

        .box {
            border: 2px solid transparent;
            background-color: white;
            border-radius: 19px;
            padding: 20px;
            margin-left: 180px;
            margin-bottom: 50px;
            width: 700px;
            text-align: center;
        }

        .foot {
            letter-spacing: 1px;
            color: white;
            padding: 20px;
            text-align: center;
            background-color: rgb(26, 83, 93);
        }

        input[type=text],
        input[type=password],
        select {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
            background: transparent;
        }

        #submit,
        #reset {
            background-color: rgb(31, 104, 117);
            color: white;
            border-radius: 30px;
            width: 100px;
            height: 30px;
            font-size: 1.2em;
            border: 1px solid transparent;
            margin-bottom: 30px;
        }

        #submit:hover,
        #reset:hover {
            background-color: rgb(26, 83, 93);
            color: white;
            border: none;
        }

        #submit:focus,
        #reset:focus {
            outline: 0;
        }
    </style>
</head>

<body>
    <div class="bottom">
        <h1><?= $editMode ? "Edit" : "Add" ?> Question</h1>
        <div class="box">
            <form name="register" method="post">

                <!-- Institution Dropdown -->
                <select name="institution" id="institution" required>
                    <option value="">Select Institution</option>
                    <?php foreach ($institutions as $inst) : ?>
                        <option value="<?= $inst['id'] ?>" <?= ($inst['id'] == $questionData['institution_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($inst['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <!-- Department Dropdown -->
                <select name="department" id="department" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $dep) : ?>
                        <option value="<?= $dep['id'] ?>" <?= ($dep['id'] == $questionData['department_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dep['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <!-- Semester Dropdown -->
                <select name="semester" required>
                    <option value="">Select Semester</option>
                    <?php for ($i = 1; $i <= 8; $i++) : ?>
                        <option value="<?= $i ?>" <?= ($i == $questionData['semester']) ? 'selected' : '' ?>>
                            <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select><br>

                <!-- Subject Dropdown -->
                <select name="subject" id="subject" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $sub) : ?>
                        <option value="<?= $sub['id'] ?>" <?= ($sub['id'] == $questionData['subject_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <input type="text" name="question" placeholder="Enter question" value="<?= htmlspecialchars($questionData['question_text']) ?>" required><br>

                <!-- Difficulty Dropdown -->
                <select name="difficulty" required>
                    <option value="">Select Difficulty</option>
                    <option value="long_descriptive" <?= ($questionData['difficulty_level'] == 'long_descriptive') ? 'selected' : '' ?>>Long Descriptive</option>
                    <option value="short_descriptive" <?= ($questionData['difficulty_level'] == 'short_descriptive') ? 'selected' : '' ?>>Short Descriptive</option>
                    <option value="oneword" <?= ($questionData['difficulty_level'] == 'oneword') ? 'selected' : '' ?>>One Word</option>
                </select><br>

                <input type="text" name="mark" placeholder="Enter mark" value="<?= htmlspecialchars($questionData['marks']) ?>" required><br>

                <div class="buttons">
                    <button type="submit" id="submit"><?= $editMode ? "Update" : "Submit" ?></button>
                    <button type="reset" id="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>

    <div class="foot">
        Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
    </div>

    <script>
        $(document).ready(function() {
            console.log("here==>")
            $("#institution").change(function() {
                let institutionId = $(this).val();
                console.log(institutionId)
                $.get("questions.class.php", {
                    institution_id: institutionId
                }, function(data) {
                    console.log("===>", data)
                    $("#department").html('<option value="">Select Department</option>');
                    $.each(data, function(index, department) {
                        $("#department").append(`<option value="${department.id}">${department.name}</option>`);
                    });
                }, "json");
            });

            $("#department").change(function() {
                let departmentId = $(this).val();
                $.get("questions.class.php", {
                    department_id: departmentId
                }, function(data) {
                    $("#subject").html('<option value="">Select Subject</option>');
                    $.each(data, function(index, subject) {
                        $("#subject").append(`<option value="${subject.id}">${subject.name}</option>`);
                    });
                }, "json");
            });
        });
    </script>
</body>

</html>