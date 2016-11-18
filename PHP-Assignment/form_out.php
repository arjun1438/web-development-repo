 <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT student_id, name, email, zipcode, country FROM student_details";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	  echo "<br> Student Record: ". $row["student_id"]. "<br>";
	  echo "<br> Name: ". $row["name"]. "<br> Email: " . $row["email"] . " <br>ZipCode:  " . $row["zipcode"] . " <br> Country:" . $row["country"] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?> 
