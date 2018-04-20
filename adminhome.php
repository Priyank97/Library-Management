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
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$bid=$_POST["bid"];
		$query="DELETE FROM `bookdetails` WHERE Bid='$bid'";
		$sql=mysqli_query($conn,$query) or die("Cannot delete right Now");		
	}
}
else
{
	header("Location:home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl1.css?version=2">
</head>
<body>

<div id="heading">
Library Management
</div>
<span  id="setting_span" style="margin-left:1000px"><?php echo "Welcome $name, $cid";?></span>
<a href="home.php"><button class="Login">Sign Out</button></a>
 
	<ul>
		<li class="A"><a href="adminhome.php" class="active">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="adminnews.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="addbook.php">Add Book</a></li>
		<li class="B"><a href="payfine.php">Pay Fine</a></li>
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
	<th>Remove Book</th>
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
		echo '<form method="post">';
		echo '<td><button value='.$bid.' name="bid" type="submit" class="issue">>></button></td>';
		echo '</form>';
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
  <button type="search" class="search">Search</button>
</form>

</body>
</html>