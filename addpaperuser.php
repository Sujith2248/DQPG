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
        <form id="questionPaperForm" name="login" action="questionPaperTemplate.php" method="post" class="form">
            <div class="mb-3">
                <label for="institution" class="form-label">Institution</label>
                <select id="institution" name="institution" class="form-select" required>
                    <option value="">Select Institution</option>
                    <option value="TEC">TEC</option>
                    <option value="NSS">NSS</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select id="department" name="department" class="form-select" required>
                    <option value="">Select Department</option>
                    <option value="BSc">B Sc</option>
                    <option value="BA">BA</option>
                    <option value="BCom">BCom</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select id="semester" name="semester" class="form-select" required>
                    <option value="sem1">sem1</option>
                    <option value="sem2">sem2</option>
                    <option value="sem3">sem3</option>
                    <option value="sem4">sem4</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <select id="subject" name="subject" class="form-select" required>
                    <option value="java">Java</option>
                    <option value="html">HTML</option>
                    <option value="english">English</option>
                    <option value="dbms">DBMS</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="examName" class="form-label">Exam Name</label>
                <input type="text" id="examName" name="examName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Exam Time</label>
                <input type="text" name="time" id="time" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Exam Date</label>
                <input type="text" name="date" id="date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="totmarks" class="form-label">Total Marks</label>
                <input type="number" name="totmarks" id="totmarks" class="form-control" required min="1">
            </div>

            <div class="mb-3">
                <label for="noofsections" class="form-label">Number of Sections</label>
                <input type="number" name="noofsections" id="noofsections" class="form-control" required min="1">
            </div>

            <div id="sectionsContainer"></div>

            <button type="submit" class="btn btn-primary mt-3" id="generateBtn">Generate</button>
            <button type="reset" class="btn btn-secondary mt-3">Reset</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#noofsections').change(function () {
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
            $(document).on("input", ".question-count", function () {
                let sectionNumber = $(this).data("section");
                let questionCount = $(this).val();
                let questionContainer = $("#questionOptions" + sectionNumber);

                // Clear previous inputs
                questionContainer.html("");

                // Generate new input fields
                for (let i = 1; i <= questionCount; i++) {
                    questionContainer.append(`
                        <div class="mb-2">
                            <label>Question ${i}</label>
                            <input type="text" name="section${sectionNumber}_question${i}" class="form-control" required>
                        </div>
                    `);
                }

                // Show manual selection div if there are questions
                $("#manualSelection" + sectionNumber).removeClass("d-none");
            });

            // Handle Question Selection dropdown change
            $(document).on("change", ".question-method", function () {
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
            $('#generateBtn').click(function () {
                if ($('#questionPaperForm')[0].checkValidity()) {
                    alert('Form is valid! Generating question paper...');
                } else {
                    alert('Please fill out all required fields.');
                }
            });
        });
    </script>
</body>

</html>
