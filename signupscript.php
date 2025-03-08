<html>
<head>
  <title>Users Signed</title>
    <style>
    .bottom {
        height :300px;
        position:  inherit;
        background-color: rgb(31, 104, 117);
        color:white;
        padding: 20px;
        padding-left:60px;
        margin: 10px 0px 0px 0px;
    }
    .p{
        font-size:1.2em;
        font-weight:lighter;
        letter-spacing:1px;
        border:1px solid white;
        text-align:center;
        padding:20px;
        color:white;
        border-radius:5px;
        width:33%;
        margin-left:33%;
    }
    .foot{
        letter-spacing:1px;
        color:white;
        padding:20px;
        text-align:center;
        background-color:rgb(26, 83, 93);
    }
	</style>
  </head>
<body>

<?php

 include ('header.php');
 include ('connection.php');
 echo "<div class='bottom'>";
 
 $Fname=$_POST["Fname"];
 $Lname=$_POST["Lname"];
 $contact=$_POST["contact"];
 $email=$_POST["email"];
 $passwd=$_POST["password"];
 $address=$_POST["address"];
 $type=$_POST["role"];
 $gender=$_POST["gender"];
 
 // $query="SELECT uid FROM tbuser";
 // $result = mysql_query($query,$conn);

// while($row = mysql_fetch_array($result))
  // {
  // $uidvar= $row['uid'] ;
  // }
  // $uidvar=$uidvar+1;
  $check_email = "SELECT email FROM users WHERE email = '$email'";
  print_r( $check_email);
  $result = mysqli_query($conn, $check_email);
  $num = mysqli_fetch_assoc($result);
  print_r( $num );
  // exit(1);
  if ($num > 0){
    echo "<p class='p'>Sign up failed "."$email"."  is exist try new email..!!</p>";
    exit(1);
  }
 
  $query = "INSERT INTO users (first_name, last_name, email, phone_number, password, role, address, gender) 
          VALUES ('$Fname', '$Lname', '$email', '$contact', '$passwd', '$type', '$address', '$gender')";
          // print_r($query);
          // exit(1);
 if (mysqli_query($conn,$query))
 {
 echo "<p class='p'>Congrats "."$Fname"." "."$Lname"."  Now you are the registred user..!!</p>";
 }
 else
 {
  die(mysqli_error($conn));
 }
mysqli_close($conn);
echo "</div>";
?>
</body>
<div class="foot">
    Made With <img src="Vector.svg"> By CSE Techies Of KIET-W
</div>

</html>
