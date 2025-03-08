<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <title>users page</title>
	<link rel="stylesheet" href="1.css" type="text/css">
		
		<script src="jquery-2.0.3.js">

		</script>
	<style>
	  .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropbtn {
      background-color: rgb(51, 150, 153);
      border-radius:5px;
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
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {background-color: gainsboro}

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown:hover .dropbtn {
      background-color: rgb(26, 83, 93);
    }
    .dropdown-content a:link, .dropdown-content a:visited {
      text-decoration: none!important;
      color:rgb(26, 83, 93);
    }
    .dropdown:hover>.dropdown-content a:hover {
      color:rgb(26, 83, 93);
    }

    .bottom {
        height :500px;
        position:  inherit;
        background-color: rgb(31, 104, 117);
        color:white;
        padding: 20px;
        padding-left:60px;
        margin: 10px 0px 0px 0px;
    }
    h4{
        color:white;
        font-size:2em;
        margin-left:0%;
        font-weight:lighter;
    }
    .foot{
        letter-spacing:1px;
        color:white;
        padding:20px;
        text-align:center;
        background-color:rgb(26, 83, 93);
    }

	h2{
		margin-top:50px;
		font-weight:lighter;
	}
	#customers {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	#customers td, #customers th {
		border: 1px solid #ddd;
		padding: 8px;
	}

	#customers tr:nth-child(even){background-color: #f2f2f2;color:black;}
	#customers tr:nth-child(odd){background-color: white;color:black;}

	#customers tr:hover {background-color: #ddd;}

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

 include ('header.php');
?> 
<div class="bottom">
  <h4>Welcome To Adiministrator Panel</h4>
  <div class="menubar">
    <div class="dropdown">
        <button class="dropbtn">Users</button>
        <div class="dropdown-content" style="left:0;">
          <a href ="users.php">Show Users</a>
          <a href="delusers.php">Delete users</a>
        </div>
    </div>
    <div class="dropdown">
      <button class="dropbtn">Papers</button>
      <div class="dropdown-content" style="left:0;">
        <a href ="add1word.php">Add new short question</a>
        <a href ="addbrief.php">Add new brief question</a>
        <a href ="addmcq.php">Add new MCQ</a>
      </div>
    </div>
  </div>
  <hr>
  <?php
	echo "<h2>List of current users..</h2>";
	include ('connection.php');

	$result = mysqli_query($conn, "SELECT id first_name, last_name, phone_number, email, role, address, gender, status FROM users");

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

echo "<table id='customers' border='1' cellspacing='0' cellpadding='10'>
        <tr> 
            <th>First Name</th> 
            <th>Last Name</th> 
            <th>Contact</th>
            <th>Email</th>
            <th>Role</th>
            <th>Address</th>
            <th>Gender</th>
            <th>Status</th>
            <th>Options</th>
        </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['first_name']}</td>
            <td>{$row['last_name']}</td>
            <td>{$row['phone_number']}</td>
            <td>{$row['email']}</td>
            <td>{$row['role']}</td>
            <td>{$row['address']}</td>
            <td>{$row['gender']}</td>
            <td>" . ($row['status'] ? 'Active' : 'Inactive') . "</td>
             <td>
                <a href='' style='color: blue; text-decoration: none;'>Edit</a> | 
                <a href='' style='color: red; text-decoration: none;' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
            </td>
          </tr>";
}

echo "</table>";
	
  ?>
</div>

<div class="foot">
    Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
</div>

</body>
</html>
