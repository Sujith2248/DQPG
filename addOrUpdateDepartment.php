<?php
include('header.php');
include "department.class.php";

$department = new Department(); // Create an instance of the Department class
$institutions = $department->getInstitutions(); // Fetch institutions

$departmentData = [
    "institution_id" => "", // Ensure this matches the DB column name
    "name" => "",
    "department_code" => "",
    "description" => ""
];

$editMode = false;
$deptId = isset($_GET['id']) ? $_GET['id'] : null;

// Check if editing an existing department
if ($deptId) {
    $editMode = true;
    $departmentInfo = $department->getDepartmentById($deptId);

    if ($departmentInfo) {
        $departmentData = array_merge($departmentData, $departmentInfo);
    } else {
        die("<script>alert('Department not found!'); window.location='register_department.php';</script>");
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        "insId" => $_POST["insId"],
        "depName" => $_POST["depName"],
        "depCode" => $_POST["depCode"],
        "depDescription" => $_POST["depDescription"]
    ];

    if ($editMode) {
        if ($department->updateDepartment($deptId, $data)) {
            echo "<script>alert('Department updated successfully!'); window.location='register_department.php';</script>";
        } else {
            echo "<script>alert('Failed to update department.');</script>";
        }
    } else {
        if ($department->addDepartment($data)) {
            echo "<script>alert('Department added successfully!'); window.location='register_department.php';</script>";
        } else {
            echo "<script>alert('Failed to add department.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $editMode ? "Edit" : "Add" ?> Department</title>

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
        input[type=password],
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
        <h1><?= $editMode ? "Edit" : "Add" ?> Department</h1>
        <div class="box">
            <form name="department" action="" method="post" class="form">
                <select name="insId" required>
                    <option value="">Select Institution</option>
                    <?php foreach ($institutions as $inst): ?>
                        <option value="<?= $inst['id'] ?>" <?= $inst['id'] == $departmentData['institution_id'] ? 'selected' : '' ?>>
                            <?= $inst['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <input type="text" name="depName" placeholder="Department Name" value="<?= htmlspecialchars($departmentData['name']) ?>" required><br>
                <input type="text" name="depCode" placeholder="Department Code" value="<?= htmlspecialchars($departmentData['department_code']) ?>" required><br>
                <input type="text" name="depDescription" placeholder="Description" value="<?= htmlspecialchars($departmentData['description']) ?>"><br>

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
</body>

</html>