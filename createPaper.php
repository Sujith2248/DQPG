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

if (isset($_GET['id'])) {
    $editMode = true;
    $questionId = $_GET['id'];
    $existingQuestion = $question->getQuestionById($questionId);

    if (!$existingQuestion) {
        die("<script>alert('Question not found!'); window.location='allQuestions.php';</script>");
    }

    $questionData = $existingQuestion;
}

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

$institutions = $question->getAllInstitutions();
$departments = ($editMode) ? $question->getDepartmentsByInstitutionId($questionData["institution_id"]) : [];
$subjects = ($editMode) ? $question->getSubjectsByDepartmentId($questionData["department_id"]) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $editMode ? "Edit" : "Add" ?> Question Paper</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
        .question-input {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
            background: transparent;
        }

        .accordion {
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 15px;
            text-align: left;
            background-color: #f9f9f9;
        }

        .accordion h2 {
            font-size: 18px;
            padding: 10px 20px;
            background-color: rgb(31, 104, 117);
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            cursor: pointer;
        }

        .accordion .accordion-body {
            padding: 15px 20px;
        }

        .accordion input[type="number"],
        .accordion select {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
            background: transparent;
        }

        .bottom {
            position: inherit;
            background-color: rgb(31, 104, 117);
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
        <h1><?= $editMode ? "Edit" : "Add" ?> question paper</h1>
        <div class="box">
            <form id="questionPaperForm" name="login" action="questionPaperTemplate.php" method="post" class="form">
                <!-- Institution Dropdown -->
                <select name="institution" id="institution" required>
                    <option value="">Select Institution</option>
                    <?php foreach ($institutions as $inst) : ?>
                        <option value="<?= $inst['id'] ?>" <?= ($inst['id'] == $questionData['institution_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($inst['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

                <!-- Department Dropdown -->
                <select name="department" id="department" required>
                    <option value="">Select Department</option>
                    <?php foreach ($departments as $dep) : ?>
                        <option value="<?= $dep['id'] ?>" <?= ($dep['id'] == $questionData['department_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dep['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

                <!-- Subject Dropdown -->
                <select name="subject" id="subject" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $sub) : ?>
                        <option value="<?= $sub['id'] ?>" <?= ($sub['id'] == $questionData['subject_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <br>

                <!-- Semester Dropdown -->
                <input
                    type="text"
                    id="semester"
                    name="semester"
                    required
                    value="<?= $editMode && !empty($questionData['semester']) ? $questionData['semester'] : '' ?>"
                    placeholder="Enter Semester (e.g., 1, 2, 3...)" />
                <br>

                <input type="text" id="examName" name="examName" placeholder="Enter Exam Name" required><br>
                <input type="text" name="time" id="time" placeholder="Enter Exam Time (e.g., 2)" required><br>
                <input type="text" name="date" id="date" placeholder="Select Exam Date (e.g., Feb 2025)" required><br>
                <input type="text" name="totmarks" id="totmarks" placeholder="Enter Total Marks" required><br>
                <input type="text" name="noofsections" id="noofsections" placeholder="Enter Number of Sections" required><br>
                <div id="sectionsContainer"></div>

                <div class="buttons">
                    <button type="submit" id="submit">Generate</button>
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
            // Initialize jQuery UI Datepicker
            $("#date").datepicker({
                dateFormat: "yy-mm",
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                }
            });

            $("#institution").change(function() {
                let institutionId = $(this).val();
                $.get("questions.class.php", {
                    institution_id: institutionId
                }, function(data) {
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

            $('#noofsections').change(function() {
                let sectionCount = $(this).val();
                let sectionHtml = '';
                for (let i = 1; i <= sectionCount; i++) {
                    sectionHtml += `
                    <div class="accordion mt-3" id="section${i}">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading${i}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${i}" aria-expanded="true">
                                    Section ${i}
                                </button>
                            </h2>
                            <div id="collapse${i}" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <input type="number" placeholder="Number of Questions" class="form-control question-count" data-section="${i}" min="1">
                                    <select class="form-select question-method" placeholder="Question Selection" data-section="${i}">
                                        <option value="manual">Manual</option>
                                        <option value="random">Random</option>
                                    </select>
                                    <div class="manual-selection d-none" id="manualSelection${i}">
                                        <label>Enter Questions</label>
                                        <div class="question-options" id="questionOptions${i}"></div>
                                    </div>
                                    <div class="random-selection d-none" id="randomSelection${i}">
                                        <label>Randomly Selected Questions:</label>
                                        <ul id="randomQuestions${i}" class="list-group"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                }
                $('#sectionsContainer').html(sectionHtml);
            });

            // Handle dynamic question input field generation
            $(document).on("input", ".question-count", function() {
                let sectionNumber = $(this).data("section");
                let questionCount = $(this).val();
                let questionContainer = $("#questionOptions" + sectionNumber);

                // Clear previous inputs
                questionContainer.html("");

                // Generate new input fields
                for (let i = 1; i <= questionCount; i++) {
                    questionContainer.append(`
                        <div class="mb-2">
                            <label style="display: block; margin: 8px 0;">Question ${i}</label>
                            <input type="text" name="section${sectionNumber}_question${i}" class="question-input" required>
                        </div>
                    `);
                }

                // Show manual selection div if there are questions
                $("#manualSelection" + sectionNumber).removeClass("d-none");
            });

            // Handle Question Selection dropdown change
            $(document).on("change", ".question-method", function() {
                let sectionNumber = $(this).data("section");
                let method = $(this).val();

                if (method === "manual") {
                    $("#manualSelection" + sectionNumber).removeClass("d-none");
                    $("#randomSelection" + sectionNumber).addClass("d-none");
                } else {
                    $("#manualSelection" + sectionNumber).addClass("d-none");
                    $("#randomSelection" + sectionNumber).removeClass("d-none");
                }
            });

            // Handle Generate button
            $('#submit').click(function(e) {
                if ($('#questionPaperForm')[0].checkValidity()) {
                    // Form is valid, proceed with submission
                } else {
                    e.preventDefault();
                    alert('Please fill out all required fields.');
                }
            });
        });
    </script>
</body>
</html>