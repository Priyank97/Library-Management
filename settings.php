<?php
//*****************************************************************************************************
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password) or die("Cannot connect to the server.");
mysqli_select_db($conn, "library_management") or die("Cannot connect to the database.");
//*****************************************************************************************************
session_start();
$cid=$_SESSION['$cid'];
$pass=$_SESSION['$pass'];
$name=$_SESSION['$name'];
//*******************************************************************
if($pass)
{
	$query="SELECT last_name, email FROM studentdetails WHERE cid='$cid'";
	$sql=mysqli_query($conn,$query) or die("Cannot be Updated1");
	$confirm=mysqli_fetch_array($sql);
	$emailErr="";
	$lname=$confirm['last_name'];
	$email=$confirm['email'];
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
		$query="UPDATE studentdetails SET first_name='$fname', last_name='$lname', password='$pass', email='$email' WHERE cid='$cid'";
			mysqli_query($conn,$query) or die("Cannot be Updated");
			header("Location:settings.php");
	}
	
	
}
}
else
{
	header("Location:home.php");
}

//*******************************************************************
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl2.css?version=2">
</head>
<div id="heading">
Library Management
</div>
<span  id="setting_span" style="margin-left:1000px"><?php echo "Welcome $name, $cid";?></span>
<a href="home.php"><button class="Login">Sign Out</button></a>

	<ul>
		<li class="A"><a href="home1.php" >Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="news1.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="account.php">Account</a></li>
		<li class="B"><a href="settings.php" class="active">Settings</a></li>
	</ul>
	</ul>
<br>
<form id="forms" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <input type="text" id="fname" name="fname" placeholder="First Name (required)" value="<?php echo $name?>" required>
  <input type="text" id="lname" name="lname" placeholder="Last Name (required)" value="<?php echo $lname?>" required>
  <input type="password" id="pass" name="pass" placeholder="Password (required)" required>
  <input type="text" id="email" name="email" placeholder="Email Id (required)" value="<?php echo $email?>" required>
  <span><?php echo $emailErr;?></span><br>
  <input type="text" id="cid" name="cid" placeholder="Roll Number (required)" value="<?php echo $cid?>" required>
  <button type="submit" class="save">Save Changes</button>  
</form>
<a href="home1.php"><button class="cancel">Cancel</button></a>

</body>
</html>