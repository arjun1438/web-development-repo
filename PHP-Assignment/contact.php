<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$form_data = array(); 

if (empty($_POST['email'])) { //Name cannot be empty
    $form_data['message'] = 'email cannot be blank';
    $form_data['success'] = false;
}

if (!empty($_POST['email']))  {
 
  $headers = "MIME-Version: 1.0" . "\r\n";
 $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
$headers .= "From: asubramnaymvaralakshmi@uh.edu" . "\r\n" .
"Reply-To: arjunsv3691@gmail.com" . "\r\n" .
"X-Mailer: PHP/" . phpversion();
  
  $to_email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = "Hello Everyone";
  
$success =  mail($to_email, "$subject", $message, $headers);
 
if(isset($success))
 { 
    $form_data['success'] = true;
    $form_data['message'] = 'Email Sent Successfully';
 }
  
}
echo json_encode($form_data);  
?>
