<?php
include ('header.php');
include ('connection.php');
session_start();
?>
<html>
<head>
</head>
<body>
<?php
/* @var $_POST type */
$email = $_POST['email'];
$password = $_POST['password'];
// print_r($password );
$select = "SELECT email, role FROM users WHERE email= '$email' AND password ='$password' ";
// print_r($select);
// exit(1)
$queryresult = mysqli_query($conn ,$select);
$result = mysqli_fetch_array($queryresult);
// print($result["role"] );
// exit(1);
// echo "Data: $name";
if($result < 0)
{
Header("Location: login.php");
}
else
{
$_SESSION["currentuser"]=$result["role"];
Header("Location: index.php");
echo "Welcome "." $queryresult";
}
?>
</body>
</html>
