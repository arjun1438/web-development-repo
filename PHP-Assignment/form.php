<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdb";


$data = array(); 

if (empty($_POST['name'])) { 
    $data['message'] = 'name cannot be blank';
    $data['success'] = false;
}

if (empty($_POST['email'])) { 
    $data['message'] = 'email cannot be blank';
    $data['success'] = false;
}
if (empty($_POST['zipcode'])) { 
    $data['message'] = 'zipcode cannot be blank';
    $data['success'] = false;
}
if (empty($_POST['country'])) { //Name cannot be empty
    $data['message'] = 'country cannot be blank';
    $data['success'] = false;
}

if (!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['zipcode']) && !empty($_POST['country']) )  {
 
  $name = $_POST['name'];
  $email = $_POST['email'];
  $zipcode = $_POST['zipcode'];
  $country = $_POST['country'];
  
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  } 
 
  $sql = "insert into student_details(name, email, zipcode, country) values ('$name', '$email', '$zipcode','$country')";

  if ($conn->query($sql) === TRUE) {
    $data['message'] = "New record created successfully";
  } else {
     $data['message'] = "Error: " . $sql . "<br>" . $conn->error;
  }

$conn->close();
if(isset($query))
 { 
    $data['success'] = true;
    $data['message'] = 'Form submitted and stored Successfully';
 }
  
}
echo json_encode($data);  
?>
