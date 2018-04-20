<?php
session_start();
session_destroy();
//*****************************************************************************************************
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password) or die("Cannot connect to the server.");
mysqli_select_db($conn, "library_management") or die("Cannot connect to the database.");
//*****************************************************************************************************

//*******************************************************************
$emailErr="";
$fname=$lname=$pass=$email=$cid="";
$count=0;
function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
		$fname=test_input($_POST["fname"]);
		$count++;
	
		$lname=test_input($_POST["lname"]);
		$count++;

		$pass=$_POST["pass"];
		$count++;
	
		$email=test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		$emailErr = "Invalid email format"; 
		else
			$count++;
	
		$cid=test_input($_POST["cid"]);
		$count++;
	
	
	if($count==5)
	{
		$query="Insert Into `studentdetails` Values('$fname','$lname','$pass','$email','$cid')";
			mysqli_query($conn,$query) or die("Cannot be Registered");
	}
	
}

//*******************************************************************
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl2.css?version=3">
</head>
<div id="heading">
Library Management
</div>
<a href="login.php"><button class="Login">Login</button></a>
<a href="signup.php"><button class="signup">Sign Up</button></a>

	<ul>
		<li class="A"><a href="home.php">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="news.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
	</ul>
	</ul>
<br>
<form id="forms" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <input type="text" id="fname" name="fname" placeholder="First Name (required)" required>
  <input type="text" id="lname" name="lname" placeholder="Last Name (required)" required>
  <input type="password" id="pass" name="pass" placeholder="Password (required)" required>
  <input type="text" id="email" name="email" placeholder="Email Id (required)" required>
  <span><?php echo $emailErr?></span><br>
  <input type="text" id="cid" name="cid" placeholder="Roll Number (required)" required>
  <button type="submit" class="signup1">Sign Up</button>
</form>

</body>
</html>