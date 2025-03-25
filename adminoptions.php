<!DOCTYPE html>
<?php
// session_start();
?>
<html>

<head>
  <title>Admin options page</title>
  <script src="jquery-2.0.3.js">
  </script>
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

    /* referred */
  </style>

</head>

<body>
  <?php
  include('header.php');

  ?>

  <div class="bottom">
    <h4>Welcom To Adinistrator Panel</h4>
    <div class="menubar">
      <div class="dropdown">
        <button class="dropbtn">Users</button>
        <div class="dropdown-content" style="left:0;">
          <a href="users.php">All Users</a>
          <a href="Signup.php">Add New User</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Institutes</button>
        <div class="dropdown-content" style="left:0;">
          <a href="institutions.php">All Institutions</a>
          <a href="addOrUpdateInstitution.php">Add New Institute</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Departments</button>
        <div class="dropdown-content" style="left:0;">
          <a href="departments.php">All Departments</a>
          <a href="addOrUpdateDepartment.php">Add New Departments</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Subject</button>
        <div class="dropdown-content" style="left:0;">
          <a href="allSubjects.php">All Subjects</a>
          <a href="subject.php">Add New Subject</a>
        </div>
      </div>
      <div class="dropdown">
        <button class="dropbtn">Questions</button>
        <div class="dropdown-content" style="left:0;">
          <a href="allQuestions.php">View all questions</a>
          <a href="question.php">Add new question</a>
        </div>
      </div>
    </div>
    <hr>
  </div>

  <div class="foot">
    Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
  </div>

</body>

</html>