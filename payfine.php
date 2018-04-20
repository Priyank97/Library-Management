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
$paybutton="YES";
$count=0;
if($pass)
{
	
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(!empty($_POST['student_cid']))
		{
			if($_POST['student_cid']=="All")
			{
				$query="SELECT sum(Fine) AS totalfine FROM finedetails";
				$sql=mysqli_query($conn,$query) or die("Something went wrong or not found.");
				$row=mysqli_fetch_array($sql);
				$totalfine=$row["totalfine"];
				$query="SELECT Title, Fine, f.Bid, f.Cid FROM bookdetails b, finedetails f WHERE b.Bid=f.Bid ORDER BY Cid";
				$sql=mysqli_query($conn,$query) or die("Something went wrong or not found.");
				$count++;
				$paybutton="NO";
			}
			else
			{
				$bid="";
				$fine="";
				$student_cid=$_POST["student_cid"];
				echo $student_cid;
				$query="SELECT sum(Fine) AS totalfine FROM finedetails WHERE Cid='$student_cid'";
				$sql=mysqli_query($conn,$query) or die("Something went wrong or not found.");
				$row=mysqli_fetch_array($sql);
				$totalfine=$row["totalfine"];
				$query="SELECT Title, Fine, f.Bid, f.Cid FROM bookdetails b, finedetails f WHERE b.Bid=f.Bid AND f.Cid='$student_cid' ORDER BY Bid";
				$sql=mysqli_query($conn,$query) or die("Something went wrong or not found.");
				$count++;
			}
			
		}
	}
	
	else if($_SERVER["REQUEST_METHOD"]=="GET")
	{
		if(!empty($_GET['pay']))
		{
				$student_cid=$_GET['pay'];
				$query="DELETE FROM finedetails WHERE Cid='$student_cid'";
				mysqli_query($conn,$query) or die("Something went wrong or not found.");			
		}		
		
	}
	
	echo $count;
}
else
{
	header("Location:home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="styl1.css?version=6">
</head>
<body>

<div id="heading">
Library Management
</div>
<span  id="setting_span" style="margin-left:1000px"><?php echo "Welcome $name, $cid";?></span>
<a href="home.php"><button class="Login">Sign Out</button></a>
 
	<ul>
		<li class="A"><a href="adminhome.php">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="adminnews.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="addbook.php">Add Book</a></li>
		<li class="B"><a href="payfine.php"  class="active">Pay Fine</a></li>
	</ul>
<br>


<table id="hometable">
<tr>
	<th>Student Id</th>
	<th>Book Id</th>
	<th>Title</th>
	<th>Fine</th>
</tr>

<?php
if($count==1)
{
	while($row=mysqli_fetch_array($sql))
	{
		$student_cid=$row['Cid'];
		$bid=$row['Bid'];
		$title=$row['Title'];
		$fine=$row['Fine'];
	echo '<tr>';
		echo '<td>'.$student_cid.'</td>';
		echo '<td>'.$bid.'</td>';
		echo '<td>'.$title.'</td>';
		echo '<td>'.$fine.'</td>';
	echo '</tr>';
	}
	echo '<tr>';
		echo '<th colspan=3 style="text-allign:center">Total</th>';
		echo '<th>₹ '.$totalfine.'</th>';
	echo '</tr>';
	echo '<tr>';
	echo '<form method="get">';
	if($paybutton=="YES")
		echo '<th colspan=4 id="pay"><button type="submit" class="pay" value='.$student_cid.' name="pay">Pay</button></th>';
	echo '</form>';
	echo '</tr>';
}
?>
</table>

<form id="forms" method="POST">
<?php 
	$sql=mysqli_query($conn,"SELECT Cid from finedetails GROUP by Cid")or die("No Database");	
?>
	<select id="student_cid" name="student_cid">
		<option selected disabled>Select ID</option>
		<option>All</option>
		<?php while($rs=mysqli_fetch_array($sql))
		echo '<option>'.$rs["Cid"].'</option>'
		?>
	</select><br>
  <button type="submit" class="search">Search</button>
</form>

</body>
</html>