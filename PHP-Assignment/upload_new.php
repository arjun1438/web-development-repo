<form enctype="multipart/form-data" action=
"<?=$_SERVER['PHP_SELF'];?>" method="post" target="votar">
 <div class="form-group row">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
	</div>
 <div class="form-group row">
  <div class="col-md-4"><label> Upload your file</label></div>
   <div class="col-md-8"><label class="btn btn-default btn-file btn-block"> Browse<input name="userfile" type="file"  style="display: none;"/></label> </div>
</div>
<br><br><br><br><br>
 <div class="form-group row">
<input type="submit"  id="formbtn" class="btn btn-primary btn-block"value="Submit" />
</form>

<?php
$data = array();

// check if a file was submitted
if(!isset($_FILES['userfile']))
{
    $data['message'] = 'Please upload file first';
    $data['success'] = 'false';
}
else
{
    try {
    $msg= upload();  //this will upload your image
    $data['message'] = $msg;  //Message showing success or failure.
    }
    catch(Exception $e) {
    $msg = $e->getMessage();
    $data['message'] = 'Sorry, could not upload file';
    $data['message'] .= $msg;
    }
}

// the upload function

function upload() {
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdb";
    
$maxsize = 10000000; //set to approx 10 MB

    //check associated error code
    if($_FILES['userfile']['error']==UPLOAD_ERR_OK) {

        //check whether file is uploaded with HTTP POST
        if(is_uploaded_file($_FILES['userfile']['tmp_name'])) {    

            //checks size of uploaded image on server side
            if( $_FILES['userfile']['size'] < $maxsize) {  
  
               //checks whether uploaded file is of image type
              //if(strpos(mime_content_type($_FILES['userfile']['tmp_name']),"image")===0) {
                 $finfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($finfo, $_FILES['userfile']['tmp_name']),"image")===0) {    

                    // prepare the image for insertion
                    $imgData =addslashes (file_get_contents($_FILES['userfile']['tmp_name']));

                    // put the image in the db...
                    // database connection
                     $conn = new mysqli($servername, $username, $password, $dbname); 
			 if ($conn->connect_error) { 
				die("Connection failed: " . $conn->connect_error); 
			}
                    // our sql query
                    $sql = "INSERT INTO test_image
                    (image, name)
                    VALUES
                    ('{$imgData}', '{$_FILES['userfile']['name']}');";
		
		    if ($conn->query($sql) === TRUE) {  
			$data['message'] = "New record created successfully"; 
		} else {
			    $data['message'] = "Error: " . $sql . "<br>" . $conn->error;     
		}
                    // insert the image
                    echo '<p>Image successfully saved in database with id</p>';
			$sql = "SELECT * FROM test_image WHERE id = $mysql_insert_id()";
			$sth = $conn->query($sql);
			$result=mysqli_fetch_array($sth);
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['image'] ).'"/>';

                }
                else
                    $msg="<p>Uploaded file is not an image.</p>";
            }
             else {
                // if the file is not less than the maximum allowed, print an error
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['userfile']['name'].' is '.$_FILES['userfile']['size'].
                ' bytes</div><hr />';
                }
	
        }
        else
            $msg="File not uploaded successfully.";

    }
    else {
        $msg= file_upload_error_message($_FILES['userfile']['error']);
    }
$conn->close();
    return $msg;

}

// Function to return error message based on error code

function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}
?>
