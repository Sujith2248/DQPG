<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Paper Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2 class="mb-3">Question Paper Generator</h2>
		<form action="selectquestionuser.php" method="post">       
 <form id="questionPaperForm" name="login" action="signupscript.php" method="post" class="form" onsubmit="return validateLogin()">
            <div class="mb-3">
                <label for="institution" class="form-label">Institution</label>
                <select id="institution" class="form-select" required>
                    <option value="">Select Institution</option>
                    <option value="TEC">TEC</option>
                    <option value="NSS">NSS</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select id="department" class="form-select" required>
				<option value="">Select Department</option>
                    <option value="BSc">B Sc</option>
                    <option value="BA">BA</option>
					<option value="BCom">BCom</option>
				</select>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select id="semester" class="form-select" required>
				<option value="sem1">sem1</option>
                    <option value="sem2">sem2</option>
					<option value="sem3">sem3</option>
					<option value="sem4">sem4</option>
				</select>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <select id="subject" class="form-select" required>
				<option value="java">java</option>
                    <option value="html">html</option>
					<option value="english">english</option>
					<option value="dbms">dbms</option>
				</select>
            </div>

            <div class="mb-3">
                <label for="examName" class="form-label">Exam Name</label>
                <input type="text" id="examName" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="totalMarks" class="form-label">Total Marks</label>
                <input type="number" id="totalMarks" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label for="sections" class="form-label">Number of Sections</label>
                <input type="number" id="sections" class="form-control" required min="1">
            </div>

            <div id="sectionsContainer"></div>

            <button type="button" class="btn btn-primary mt-3" id="generateBtn">Generate</button>
            <button type="reset" class="btn btn-secondary mt-3">Reset</button>
			<div class="buttons">
                <input id="submit" type="submit" value="Select Questions" />
                </div>

        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#institution').change(function () {
                let institutionId = $(this).val();
                if (institutionId) {
                    // AJAX to load departments based on selected institution
                    $.ajax({
                        url: 'generator.class.php',
                        type: 'POST',
                        data: { type: 'departments', institutionId: institutionId },
                        success: function (data) {
                            $('#department').html(data).prop('disabled', false);
                        }
                    });
                }
            });

            $('#department').change(function () {
                let department = $(this).val();
                let institutionId = $('#institution').val();
                if (department) {
                    // AJAX to load semesters based on department
                    $.ajax({
                        url: 'generator.class.php',
                        type: 'POST',
                        data: { type: 'semesters', institutionId: institutionId },
                        success: function (data) {
                            $('#semester').html(data).prop('disabled', false);
                        }
                    });
                }
            });

            $('#semester').change(function () {
                let department = $('#department').val();
                if (department) {
                    // AJAX to load subjects based on selected department
                    $.ajax({
                        url: 'generator.class.php',
                        type: 'POST',
                        data: { type: 'subjects', department: department },
                        success: function (data) {
                            $('#subject').html(data).prop('disabled', false);
                        }
                    });
                }
            });

            // Dynamic section generation
            $('#sections').change(function () {
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
                                    <label>Number of Questions</label>
                                    <input type="number" class="form-control question-count" data-section="${i}" min="1">
                                    <label>Question Selection</label>
                                    <select class="form-select question-method" data-section="${i}">
                                        <option value="manual">Manual</option>
                                        <option value="random">Random</option>
                                    </select>
                                    <div class="manual-selection d-none" id="manualSelection${i}">
                                        <label>Select Questions</label>
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

            // Handle generate button click
            $('#generateBtn').click(function () {
                // Form validation before generation
                if ($('#questionPaperForm')[0].checkValidity()) {
                    alert('Form is valid! Generating question paper...');
                    // Implement the paper generation logic here
                } else {
                    alert('Please fill out all required fields.');
                }
            });
        });
    </script>
</body>

</html>
