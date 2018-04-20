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
$fine="";
if($pass)
{
	$query="SELECT Sum(Fine) AS totalfine FROM finedetails WHERE Cid='$cid'";
	$sql=mysqli_query($conn,$query) or die("Something went Wrong");
	$row=mysqli_fetch_array($sql);
	$fine=$row['totalfine'];
	if(empty($fine))
		$fine=0;
	$query="SELECT b.Bid, Cid , Title, Date_of_issue,Status FROM bookdetails b , issue i where b.Bid=i.Bid AND Cid='$cid' AND Status='Not Returned'";
	$sql=mysqli_query($conn,$query) or die("Something went Wrong");
		
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		$bid="";
		$title="";
		$date_of_issue="";
		$bid=$_POST["bid"];
		//------------------------------------------------------------------------------------
		$query="UPDATE issue SET Status='Returning' WHERE Bid='$bid' AND Cid='$cid' AND Status='Not Returned'";
		mysqli_query($conn,$query) or $result="Cannot be returned right now";
		//------------------------------------------------------------------------------------
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$query="SELECT Extract(Second FROM (Date_of_return-Date_of_issue)) AS FineDays FROM issue WHERE Cid='$cid' AND Bid='$bid' AND Status='Returning'";
		$sql=mysqli_query($conn,$query);
		$row=mysqli_fetch_array($sql);
		$fine=$row['FineDays'];
		if($fine > 7)
		{
			$fine=$fine*10;
			$query="INSERT INTO finedetails(Cid, Bid,Fine) VALUES ('$cid','$bid','$fine')";
			mysqli_query($conn,$query);
		}
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$query="UPDATE issue SET Status='Returned' WHERE Bid='$bid' AND Cid='$cid' AND Status='Returning'";
		mysqli_query($conn,$query) or $result="Cannot be returned right now";
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		$query="UPDATE bookdetails SET No_of_copies=No_of_copies+1 WHERE Bid='$bid'";
		mysqli_query($conn,$query);	
		header("Location:account.php");
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
	<link rel="stylesheet" href="styl1.css?version=6">
</head>
<body>

<div id="heading">
Library Management
</div>
<span  id="setting_span" style="margin-left:1000px"><?php echo "Welcome $name, $cid";?></span>
<a href="home.php"><button class="Login">Sign Out</button></a>
 
	<ul>
		<li class="A"><a href="home1.php">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="news1.php">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="account.php" class="active">Account</a></li>
		<li class="B"><a href="settings.php">Settings</a></li>
	</ul>
<br>
<table id="hometable">
<caption><?php echo $result ?></caption>
<tr>
	<th>Book Id</th>
	<th>Title</th>
	<th>Date_of_issue</th>
	<th>Return</th>
</tr>

<?php

	while($row=mysqli_fetch_array($sql))
	{
		$bid=$row['Bid'];
		$title=$row['Title'];
		$date_of_issue=$row['Date_of_issue'];
	echo '<tr>';
		echo '<td>'.$bid.'</td>';
		echo '<td>'.$title.'</td>';
		echo '<td>'.$date_of_issue.'</td>';
		echo '<form method="post">';
		echo '<td><button value='.$bid.' name="bid" type="submit" class="issue">>></button></td>';
		echo '</form>';
	echo '</tr>';
	}

?>
</table>
<div id="fine">
FINE <br>
₹ <?php echo $fine?>
</div>
</body>
</html>