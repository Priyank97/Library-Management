<?php
//*****************************************************************************************************
session_start();
session_destroy();
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password) or die("Cannot connect to the server.");
mysqli_select_db($conn, "library_management") or die("Cannot connect to the database.");
//*****************************************************************************************************

$cid=$pass="";
$count=0;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if(empty($_POST["cid"]))
		$cidErr="Roll Number is required";
	else
	{
		$cid=$_POST["cid"];
		$count++;
	}
	if(empty($_POST["pass"]))
		$passErr="Password is required";
	else
	{
		$pass=$_POST["pass"];
		$count++;
	}
	if($count==2)
	{
		$query="SELECT first_name, password, cid FROM studentdetails WHERE password='$pass' and cid='$cid'";
		$sql=mysqli_query($conn,$query)or die("Something went wrong");
		$confirm=mysqli_fetch_array($sql);
		if($confirm["cid"]=='7599325' && $confirm["password"]==$pass)
		{
			session_start();
			$name=$confirm["first_name"];
			$_SESSION['$name']=$name;
			$_SESSION['$cid']=$cid;
			$_SESSION['$pass']=$pass;
			header("Location:adminhome.php");
		}
		else if($confirm["cid"]==$cid && $confirm["password"]==$pass)
		{
			session_start();
			$name=$confirm["first_name"];
			$_SESSION['$name']=$name;
			$_SESSION['$cid']=$cid;
			$_SESSION['$pass']=$pass;
			header("Location:home1.php");
		}
		else
		{
			die("Roll Number or Password is incorrect. Try Again");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl2.css?version=2">
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="forms">
  <input type="text" name="cid" placeholder="Roll Number (required)" required>
  <input type="password" name="pass" placeholder="Password (required)" required>
  <button type="submit" class="login1">Login</button>
</form>

</body>
</html>