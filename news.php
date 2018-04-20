<?php
session_start();
session_destroy();
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
<a href="login.php"><button class="Login">Login</button></a>
<a href="signup.php"><button class="signup">Sign Up</button></a>
	<ul>
		<li class="A"><a href="home.php">Home</a></li>
		<li class="A"><a  href="#">Books</a></li>
		<li class="A"><a  href="#">Magazines</a></li>
		<li class="A"><a  href="news.php" class="active">News</a></li>
		<li class="A"><a  href="#">Contact Us</a></li>
		<li class="A"><a href="#">About</a></li>
	</ul>
	</ul>
<br>

<iframe align="right-buttom" width="450" height="450" allowFullScreen="allowFullScreen" src="https://www.youtube.com/embed/E9QXO5m_iS0">
	</iframe>


</body>
</html>
