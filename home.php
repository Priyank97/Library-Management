<?php
//******************
session_start();
session_destroy();
//******************

//*****************************************************************************************************
$servername = "localhost";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password) or die("Cannot connect to the server.");
mysqli_select_db($conn,"library_management");
//******************************************************************************************************
$count=0;
if($_SERVER["REQUEST_METHOD"]=="GET")
{
	if(empty($_GET["category"]))
		$categoryErr="";
	else
	{
		$category=$_GET["category"];
		$query="SELECT  * FROM bookdetails WHERE Category='$category'";
		$sql=mysqli_query($conn,$query) or die("Something went wrong or not found.");
		$count++;
		$bid="";
		$author="";
		$title="";
		$edition="";
		$no_of_copies="";
		$price="";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl1.css?version=3">
</head>
<body>

<div id="heading">
Library Management
</div>
<a href="login.php"><button class="Login">Login</button></a>
<a href="signup.php"><button class="signup">Sign Up</button></a>
	<ul>
		<li class="A"><a href="home.php" class="active">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="news.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
	</ul>
<br>

<table id="hometable">
<tr>
	<th>Book Id</th>
	<th>Title</th>
	<th>Author</th>
	<th>Edition</th>
	<th>Category</th>
	<th>No_of_copies</th>
	<th>Price</th>
</tr>
<?php
if($count==1)
{
	while($row=mysqli_fetch_array($sql))
	{
		$bid=$row['Bid'];
		$author=$row['Author'];
		$title=$row['Title'];
		$edition=$row['Edition'];
		$no_of_copies=$row['No_of_copies'];
		$price=$row['Price'];
	echo '<tr>';
		echo '<td>'.$bid.'</td>';
		echo '<td>'.$title.'</td>';
		echo '<td>'.$author.'</td>';
		echo '<td>'.$edition.'</td>';
		echo '<td>'.$category.'</td>';
		echo '<td>'.$no_of_copies.'</td>';
		echo '<td>'.$price.'</td>';
	echo '</tr>';
	}
}
?>
</table>

<form id="forms" method="get">
	<select id="category" name="category">
	<?php 
	$sql=mysqli_query($conn,"SELECT Category from bookdetails GROUP by Category")or die("No Database");	
	?>
		<option selected disabled>Category</option>
		<?php while($rs=mysqli_fetch_array($sql))
		echo '<option>'.$rs["Category"].'</option>'	
		?>
	</select><br>
  <button type="submit" class="search">Search</button>
</form>

</body>
</html>