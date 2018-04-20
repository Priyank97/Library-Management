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
$result="";
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
		$query="SELECT Cid, Bid, Status FROM issue WHERE Cid='$cid' and Bid='$bid' AND Status='Not Returned'";
		$sql=mysqli_query($conn,$query) or die("Something went Wrong");
		$row=mysqli_fetch_array($sql);
		if(empty($row['Cid']))
		{
			$query="Select No_of_copies from bookdetails where Bid='$bid'";
			$sql=mysqli_query($conn,$query) or die("Something went Wrong");
			$row=mysqli_fetch_array($sql);
			if($row['No_of_copies']>0)
			{
				$query="INSERT INTO issue(Cid, Bid,Status,Date_of_return) VALUES ('$cid','$bid','Not Returned','Null')";
				$sql=mysqli_query($conn,$query) or die("Cannot Issue");
				$query="Update bookdetails SET No_of_copies=No_of_copies-1 WHERE Bid='$bid'";
				mysqli_query($conn,$query) or die("fffff");
				$result="Book Issued";
			}
			else
			{
				$result="Cannot be issued";
			}
		}
		else
		{
			$result="You have already Issued this Book";
		}
	
	
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
	<link rel="stylesheet" href="styl1.css?version=3">
</head>
<body>

<div id="heading">
Library Management
</div>
<span  id="setting_span" style="margin-left:1000px"><?php echo "Welcome $name, $cid";?></span>
<a href="home.php"><button class="Login">Sign Out</button></a>
 
	<ul>
		<li class="A"><a href="home1.php" class="active">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="news1.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="account.php">Account</a></li>
		<li class="B"><a href="settings.php">Settings</a></li>
	</ul>
<br>
<table id="hometable">
<caption><?php echo $result ?></caption>
<tr>
	<th>Book Id</th>
	<th>Title</th>
	<th>Author</th>
	<th>Edition</th>
	<th>Category</th>
	<th>No_of_copies</th>
	<th>Price</th>
	<th>Issue</th>
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