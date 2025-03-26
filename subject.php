<?php
include('header.php');
include('subject.class.php');
include('institutions.class.php');
include('department.class.php');

$subject = new Subject();
$institution = new Institution();
$department = new Department();

$editMode = false;
$subjectData = [
    "institution_id" => "",
    "department_id" => "",
    "name" => "",
    "subject_code" => "",
    "created_by" => ""
];

// Fetch institutions
$institutions = $institution->getAllInstitutions();

// Check if editing an existing subject
if (isset($_GET['id'])) {
    $editMode = true;
    $subjectId = $_GET['id'];
    $existingSubject = $subject->getSubjectById($subjectId);

    if (!$existingSubject) {
        die("<script>alert('Subject not found!'); window.location='subjects.php';</script>");
    }

    $subjectData = $existingSubject;
}


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "institution_id" => $_POST["institution_id"],
        "department_id" => $_POST["department_id"],
        "name" => $_POST["name"],
        "subject_code" => $_POST["subject_code"],
        "created_by" => 1 // Change to actual logged-in user ID
    ];

    if ($editMode) {
        if ($subject->updateSubject($subjectId, $data)) {
            echo "<script>alert('Subject updated successfully!'); window.location='allSubjects.php';</script>";
        } else {
            echo "<script>alert('Failed to update subject.');</script>";
        }
    } else {
        if ($subject->addSubject($data)) {
            echo "<script>alert('Subject added successfully!'); window.location='allSubjects.php';</script>";
        } else {
            echo "<script>alert('Failed to add subject.');</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $editMode ? "Edit" : "Add" ?> Subject</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style type="text/css">
        .bottom {
            /* height :500px; */
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
            height: auto;
            letter-spacing: 1px;
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
        input[type=password] {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
        }

        #submit,
        #reset,
        #cancel {
            background-color: rgb(31, 104, 117);
            color: white;
            border-radius: 30px;
            width: 100px;
            height: 30px;
            font-size: 1.2em;
            border: 1px solid transparent;
            /* margin: 30px; */
            margin-bottom: 30px;
        }

        select {
            width: 70%;
            padding: 12px 20px;
            margin: 8px 0;
            box-sizing: border-box;
            border: none;
            border-bottom: 2px solid rgb(26, 83, 93);
            background-color: transparent;
            font-size: 15px;
        }

        select {
            cursor: pointer;
        }

        #submit:hover,
        #reset:hover,
        #cancel:hover {
            background-color: rgb(26, 83, 93);
            color: white;
            border: none;
        }

        #submit:focus,
        #reset:focus,
        #cancel:focus {
            outline: 0;
        }

        form>a:link,
        form>a:visited {
            text-decoration: none !important;
        }

        form>a:hover {
            color: rgb(26, 83, 93);
            font-size: 1.1em;
            background-color: ghostwhite;
        }

        #input2 {
            font-size: 15px;
            font-weight: lighter;
            width: 470px;
            height: 50px;
            border-bottom: 2px solid rgb(26, 83, 93);
            ;
            background-color: transparent;
            color: black;
            padding-left: 20px;
            margin-top: 10px;
        }

        input,
        textarea:focus {
            outline: 0;
        }

        .radio {
            color: black;
            margin-top: 30px;
            margin-right: 330px;
        }

        .buttons {
            margin-top: 30px;
        }

        #reset {
            margin-left: 50px;
        }
    </style>

    <script>
        function validateForm() {
            let fname = document.forms["login"]["Fname"].value.trim();
            let lname = document.forms["login"]["Lname"].value.trim();
            let contact = document.forms["login"]["contact"].value.trim();
            let email = document.forms["login"]["email"].value.trim();
            let password = document.forms["login"]["password"].value.trim();
            let address = document.forms["login"]["address"].value.trim();
            let role = document.querySelector('input[name="role"]:checked');

            if (fname === "") {
                alert("First Name is required");
                return false;
            }
            if (lname === "") {
                alert("Last Name is required");
                return false;
            }
            if (contact === "" || !/^[0-9]{10}$/.test(contact)) {
                alert("Enter a valid 10-digit contact number");
                return false;
            }
            if (email === "" || !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                alert("Enter a valid email");
                return false;
            }
            if (password === "" || password.length < 6) {
                alert("Password must be at least 6 characters long");
                return false;
            }
            if (address === "") {
                alert("Address is required");
                return false;
            }
            if (!role) {
                alert("Please select a role");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div class="bottom">
        <h1><?= $editMode ? "Edit" : "Add" ?> Subject</h1>
        <div class="box">
            <form name="subject" method="post" class="form">
                <select name="institution_id" id="institution_id" required>
                    <option value="">Select Institution</option>
                    <?php foreach ($institutions as $inst) : ?>
                        <option value="<?= $inst['id'] ?>" <?= ($inst['id'] == $subjectData['institution_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($inst['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>
                <!-- Department Dropdown (Populated via AJAX) -->
                <select name="department_id" id="department_id" required>
                    <option value="">Select Department</option>
                </select><br>

                <input type="text" name="name" placeholder="Subject Name" value="<?= htmlspecialchars($subjectData['name']) ?>" required><br>
                <input type="text" name="subject_code" placeholder="Subject Code" value="<?= htmlspecialchars($subjectData['subject_code']) ?>"><br>

                <div class="buttons">
                    <input id="submit" type="submit" value="<?= $editMode ? "Update" : "Submit" ?>" />
                    <input id="reset" type="reset" value="Reset" />
                </div>
            </form>
        </div><br>
    </div>
    </div>
    <div class="foot">
        Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
    </div>

    <script>
        $(document).ready(function() {
            function loadDepartments(institutionId, selectedDepartment = '') {
                if (institutionId) {
                    $.ajax({
                        url: "subject.class.php",
                        type: "GET",
                        data: {
                            institution_id: institutionId
                        },
                        dataType: "json",
                        success: function(departments) {
                            let departmentSelect = $("#department_id");
                            departmentSelect.empty().append('<option value="">Select Department</option>');

                            $.each(departments, function(index, department) {
                                let selected = (department.id == selectedDepartment) ? 'selected' : '';
                                departmentSelect.append(`<option value="${department.id}" ${selected}>${department.name}</option>`);
                            });
                        }
                    });
                } else {
                    $("#department_id").empty().append('<option value="">Select Department</option>');
                }
            }

            // Load departments when institution is selected
            $("#institution_id").change(function() {
                let institutionId = $(this).val();
                loadDepartments(institutionId);
            });

            // If editing, pre-load departments
            <?php if ($editMode && !empty($subjectData['institution_id'])) : ?>
                loadDepartments(<?= $subjectData['institution_id'] ?>, <?= $subjectData['department_id'] ?>);
            <?php endif; ?>
        });
    </script>
</body>

</html>