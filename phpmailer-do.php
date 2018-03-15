<?php
header('Content-Type: text/html; charset=utf-8');
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// if( (bool)$_GET['dev'] ) {
echo '- entry point: '.$_SERVER["SCRIPT_FILENAME"].'<br>';
echo '- absolut path: '.__FILE__.'<br>';
// }
*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
// require 'PHPMailer-master/src/SMTP.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

// print_r($mail);
// exit;

//Set who the message is to be sent from
// $mail->setFrom('from@example.com', 'First Last');
$mail->setFrom('admin@site.com', 'First Last');
//Set an alternative reply-to address

// $mail->addReplyTo('replyto@example.com', 'First Last');
$mail->addReplyTo('freerun-2012@yandex.ru', 'First Last');

//Set who the message is to be sent to
// $mail->addAddress('whoto@example.com', 'John Doe');
$mail->addAddress('alexey@webyourway.com.au', 'John Doe');
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
// $mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//Attach an image file
// $mail->addAttachment('attachment.png');

//Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//send the message, check for errors
// if (!$mail->send()) {
// 	echo "Mailer Error: " . $mail->ErrorInfo;
// } else {
// 	echo "Message sent!";
// }




/**
 * PHPMailer simple file upload and send example.
 */
//Import the PHPMailer class into the global namespace
// use PHPMailer\PHPMailer\PHPMailer;

$msg = '';
if (array_key_exists('userfile', $_FILES)) {
	print_r($_FILES);


    // First handle the upload
    // Don't trust provided filename - same goes for MIME types
    // See http://php.net/manual/en/features.file-upload.php#114004 for more thorough upload validation
    // $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name']));
	$uploadfile =  $_FILES['userfile']['name'];
	// 10 mb
	if( $_FILES['userfile']['size'] > 10000000 ) echo 'file size large 10 mb'; 
	// if( $_FILES['userfile']['size'] > 1000000 ) $error = 'file size large 1 mb'; 



	// $blacklist = array(".php", ".phtml", ".php3", ".php4");
	$ext_allow = false;
	$whitelist = array(".jpg", ".jpeg", ".gif", ".png", ".docx", ".doc", ".pdf", ".xlsx");
	foreach ($whitelist as $item) {
		// if(!preg_match("/$item\$/i",$uploadfile)) {
		if(preg_match("/{$item}$/i",$uploadfile)) {
			$ext_allow = true; break;
		}
	}

	if( !$ext_allow) $error = "We do not allow you to upload a file with this extension. Try another \n";
	if(!empty($error)) { echo $error; exit; }


/*
// no correct mine for pdf, xlsx
	echo '<hr>';
		$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime-type extension
		echo finfo_file($finfo, $uploadfile);
		finfo_close($finfo);
		echo '<hr>';
/*
.docx application/vnd.openxmlformats-officedocument.wordprocessingml.document
.xls application/vnd.ms-excel
.xlsx application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
.png image/png
*/

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        // Upload handled successfully
        // Now create a message
        // require '../vendor/autoload.php';
        // $mail = new PHPMailer;
        // $mail->setFrom('from@example.com', 'First Last');
        // $mail->addAddress('whoto@example.com', 'John Doe');
        // $mail->Subject = 'PHPMailer file sender';
        // $mail->Body = 'My message body';
        // Attach the uploaded file
	$mail->addAttachment($uploadfile, 'My uploaded file');
	if (!$mail->send()) {
		$msg .= "Mailer Error: " . $mail->ErrorInfo;
	} else {
		$msg .= "Message sent! ".$uploadfile;
	}
} else {
	$msg .= 'Failed to move file to ' . $uploadfile;
}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>PHPMailer Upload</title>
</head>
<body>
	<?php if (empty($msg)) { ?>
	<form method="post" enctype="multipart/form-data">
		<!-- 1e7-10mb -->
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input name="userfile" type="file">
		<input type="submit" value="Send">
	</form>
	<?php } else {
		echo $msg;
	} ?>
</body>
</html>


