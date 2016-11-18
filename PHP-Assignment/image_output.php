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

$sql = "SELECT * from test_image";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row1 = $result->fetch_assoc()) {
	echo '<dt><strong>Image name:  '. $row1["name"]. '</strong></dt><dd>'
     . '<img src="data:image/jpeg;base64,' . base64_encode($row1['image']) . '" width="290" height="290">'
     . '</dd>';
    }
} else {
    echo "0 results";
}
$conn->close();
?> 
