<?php
//This is a page url you are redirect to when you click the submit button.
$formurl = "http://www.ckdigital.com/project/cakefication/development/store/index.php?route=information/contact/success" ;
// Set the "To" email address
$to="angela.okonkwo@ckdigital.net, ancokonkwo@yahoo.com";
//Subject of the mail
$subject="Message from cakefication";
// Get all the values from input
$contact_person= $_POST['fullName'];
$cake_message = $_POST['cake_message'];
$contact_email = $_POST['contact_email'];
$contact_phone = $_POST['contact_phone'];
$delivery_date = $_POST['delivery_date'];
$others = $_POST['others'];
// Check the email address
if (!eregi( "^[_a-z0-9-]+(.[_a-z0-9-]+)@[a-z0-9-]+(.[a-z0-9-]+)(.[a-z]{2,3})$", $email_address))
{
$errors .= "\n Error: Invalid email address";
}
// Now Generate a random string to be used as the boundary marker
$mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";
// Now Store the file information to a variables for easier access
$tmp_name = $_FILES['file_upload']['tmp_name'];
$type = $_FILES['file_upload']['type'];
$file_name = $_FILES['file_upload']['name'];
$size = $_FILES['file_upload']['size'];
$from = $email;
// Now here we setting up the message of the mail
$message = "
Full Name: $contact_person \n
Phone Number: $contact_phone \n
Email Address: $contact_email \n\n
delivery Date: $delivery_date \n
Cake Message: $cake_message \n
";
// Check if the upload succeded, the file will exist
if (file_exists($tmp_name)){
// Check to make sure that it is an uploaded file and not a system file
if(is_uploaded_file($tmp_name)){

 // Now Open the file for a binary read
 $file = fopen($tmp_name,'rb');

 // Now read the file content into a variable
 $data = fread($file,filesize($tmp_name));

 // close the file
 fclose($file);

 // Now we need to encode it and split it into acceptable length lines
 $data = chunk_split(base64_encode($data));

}

// Now we'll build the message headers
$headers = "From: $from\r\n" .
"MIME-Version: 1.0\r\n" .
"Content-Type: multipart/mixed;\r\n" .
" boundary=\"{$mime_boundary}\"";

// Next, we'll build the message body note that we insert two dashes in front of the MIME boundary when we use it
$message = "This is a multi-part message in MIME format.\n\n" .
"--{$mime_boundary}\n" .
"Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
"Content-Transfer-Encoding: 7bit\n\n" .
$message . "\n\n";

// Now we'll insert a boundary to indicate we're starting the attachment we have to specify the content type, file name, and disposition as an attachment, then add the file content and set another boundary to indicate that the end of the file has been reached
$message .= "--{$mime_boundary}\n" .
"Content-Type: {$type};\n" .
" name=\"{$file_name}\"\n" .
//"Content-Disposition: attachment;\n" .
//" select_image=\"{$fileatt_name}\"\n" .
"Content-Transfer-Encoding: base64\n\n" .
$data . "\n\n" .
"--{$mime_boundary}--\n";

// Thats all.. Now we need to send this mail... :)

if (@mail($to, $subject, $message, $headers)){
header( "Location: $formurl" );

}else{
header( "Location: $formurl" );
}
}
?>
