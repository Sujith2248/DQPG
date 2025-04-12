<?php
session_start();
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
            margin-bottom: 15px;
        }
        .question-section {
            margin-bottom: 15px;
            text-align: center;
        }
        h3 {
            margin: 10px 0;
            text-decoration: underline;
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

<?php
$institution = $_POST['institution'];
$examName = $_POST['semester'] + " " + $_POST['department'] + " " + $_POST['examName'];
$subject = $_POST['subject'];
$time = $_POST['date'] + "|" + $_POST['time'];
$maxMarks = $_POST['totmarks'];
$noOfSections = $_POST['noofsections'] ?? 0;
$questions = [
    "PART A" => [
        "List the ACID properties of a transaction.",
        "Outline the integrity constraints with example.",
        "Analyze the anomalies in database.",
        "Explain Relational Algebra in detail."
    ],
    "PART B" => [
        "Discuss concurrency control schemes.",
        "What is an ER diagram? Explain with example the reduction of an ER schema to tables.",
        "Explain about the different Normal forms with example."
    ]
];

// Displaying the header
echo "<div class='page'>";
echo "<div class='header'>";
echo "<p>$institution</p>";
echo "<p><strong>$examName</strong></p>";
echo "<p>$subject</p>";
echo "<p>Time: $time | Max Marks: $maxMarks</p>";
echo "</div>";

// Displaying the questions
foreach ($questions as $section => $qs) {
    echo "<div class='question-section'>";
    echo "<h3>$section</h3>";
    echo "<p>Answer the following Questions:</p>";
    echo "<ol>";
    foreach ($qs as $q) {
        echo "<li class='question'>$q</li>";
    }
    echo "</ol>";
    echo "</div>";
}

echo "</div>";
?>

<button id="print-btn" onclick="window.print()">Print</button>

</body>
</html>