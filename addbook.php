<?php
//**********************************************************************************************************
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password) or die("Cannot connect to the server.");
mysqli_select_db($conn,"library_management");
session_start();
$cid=$_SESSION['$cid'];
$pass=$_SESSION['$pass'];
$name=$_SESSION['$name'];
//**********************************************************************************************************
$count=0;
if($pass)
{
	function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
			$bid=test_input($_POST["bid"]);
			$count++;

			$author=test_input($_POST["author"]);
			$count++;
	
			$title=$_POST["title"];
			$count++;
	
			$category=test_input($_POST["category"]);
			$count++;
		
			$edition=test_input($_POST["edition"]);
			$count++;
			
			$no_of_copies=test_input($_POST["no_of_copies"]);
			$count++;
	
			$price=test_input($_POST["price"]);
			$count++;
		
		
		if($count==7)
		{
			$query="Insert Into `bookdetails` Values('$bid','$author','$title','$category','$edition','$no_of_copies','$price')";
				mysqli_query($conn,$query) or die("Cannot be Registered");
		}
		
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl2.css?version=7">
</head>
<div id="heading">
Library Management
</div>
<span style="margin-left:1000px" id="setting_span"><?php echo "Welcome $name, $cid";?></span>
<a href="home.php"><button class="Login">Sign Out</button></a>

	<ul>
		<li class="A"><a href="adminhome.php">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="adminnews.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="addbook.php"  class="active">Add Book</a></li>
		<li class="B"><a href="payfine.php">Pay Fine</a></li>
	</ul>
	</ul>
<br>
<form id="forms" method="post" action=" <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
  <input type="text" id="bid" name="bid" placeholder="Book ID (required)" required>
  <input type="text" id="author" name="author" placeholder="Author (required)" required>
  <input type="text" id="title" name="title" placeholder="Title (required)" required>
  <input type="text" id="category" name="category" placeholder="Category (required)" required>
  <input type="text" id="edition" name="edition" placeholder="Edition (required)" required>
  <input type="text" id="no_of_copies" name="no_of_copies" placeholder="No of copies (required)" required>
  <input type="text" id="price" name="price" placeholder="Price (required)" required>
  <button type="submit" class="signup1">Add book</button>
</form>

</body>
</html>