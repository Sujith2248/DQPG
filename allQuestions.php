<!DOCTYPE html>
<?php
include('header.php');
include('questions.class.php');

$question = new Question();
$questions = $question->getAllQuestions();
?>
<html>

<head>
    <title>All Questions page</title>
    <link rel="stylesheet" href="1.css" type="text/css">

    <script src="jquery-2.0.3.js">

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: rgb(51, 150, 153);
            border-radius: 5px;
            color: white;
            padding: 10px;
            font-size: 20px;
            border: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: gainsboro
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: rgb(26, 83, 93);
        }

        .dropdown-content a:link,
        .dropdown-content a:visited {
            text-decoration: none !important;
            color: rgb(26, 83, 93);
        }

        .dropdown:hover>.dropdown-content a:hover {
            color: rgb(26, 83, 93);
        }

        .bottom {
            height: 500px;
            position: inherit;
            background-color: rgb(31, 104, 117);
            color: white;
            padding: 20px;
            padding-left: 60px;
            margin: 10px 0px 0px 0px;
        }

        h4 {
            color: white;
            font-size: 2em;
            margin-left: 0%;
            font-weight: lighter;
        }

        .foot {
            letter-spacing: 1px;
            color: white;
            padding: 20px;
            text-align: center;
            background-color: rgb(26, 83, 93);
        }

        h2 {
            margin-top: 50px;
            font-weight: lighter;
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
            color: black;
        }

        #customers tr:nth-child(odd) {
            background-color: white;
            color: black;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: rgb(26, 83, 93);
            color: white;
        }
    </style>
</head>

<body>
    <?php

    ?>
    <div class="bottom">
        <h4>All Questions</h4>
        <hr>
        <h2>List of All Questions</h2>

        <table id="customers">
            <tr>
                <th>Institution</th>
                <th>Department</th>
                <th>Subject</th>
                <th>Semester</th>
                <th>Question</th>
                <th>Marks</th>
                <th>Difficulty</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($questions as $row) : ?>
                <tr id="row-<?= $row['id'] ?>">
                    <td><?= htmlspecialchars($row['institution_name']) ?></td>
                    <td><?= htmlspecialchars($row['department_name']) ?></td>
                    <td><?= htmlspecialchars($row['subject_name']) ?></td>
                    <td><?= htmlspecialchars($row['semester']) ?></td>
                    <td><?= htmlspecialchars($row['question_text']) ?></td>
                    <td><?= htmlspecialchars($row['marks']) ?></td>
                    <td><?= htmlspecialchars($row['difficulty_level']) ?></td>
                    <td>
                        <a href="question.php?id=<?= $row['id'] ?>" class="action-btn edit-btn">Edit</a> |
                        <a href="#" class="action-btn delete-btn" data-id="<?= $row['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    </div>





    <div class="foot">
        Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
    </div>
    <script>
        $(document).ready(function() {
            $(".delete-btn").click(function() {
                let questionId = $(this).data("id");

                if (confirm("Are you sure you want to delete this question?")) {
                    $.ajax({
                        url: "questions.class.php",
                        type: "POST",
                        data: {
                            delete_id: questionId
                        },
                        success: function(response) {
                            if (response.trim() === "success") {
                                $("#row-" + questionId).fadeOut(500);
                            } else {
                                alert("Failed to delete question.");
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>