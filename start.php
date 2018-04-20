
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName="library_management";
// Create connection
$conn = mysqli_connect($servername, $username, $password);
mysqli_select_db($conn,"library_management")or die("Cannot connect to the database.");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$query="SELECT * from bookdetails GROUP by author";
$sql=mysqli_query($conn,$query)or die("Cannot");
		while($rs = mysqli_fetch_array($sql))
		{
			echo'<option>'.$rs["Author"].'</option>';
		}
?>