<?php
session_start();
$cid=$_SESSION['$cid'];
$pass=$_SESSION['$pass'];
$name=$_SESSION['$name'];
if(!$pass)
	header("Location:home.php");
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
		<li class="A"><a href="adminhome.php">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="adminnews.php"  class="active">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
		<li class="B"><a href="addbook.php">Add Book</a></li>
		<li class="B"><a href="payfine.php">Pay Fine</a></li>
	</ul>
<br>

<iframe  width="450" height="450" allowFullScreen="allowFullScreen" src="https://www.youtube.com/embed/E9QXO5m_iS0">
	</iframe>


</body>
</html>
