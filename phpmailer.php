<?php
/* 
handlers fields  any custom forms from ajax, include this file in begin index.php
to use CMS parametrs
*/

header('Content-Type: text/html; charset=utf-8');

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
/*
// if( (bool)$_GET['dev'] ) {
echo '- entry point: '.$_SERVER["SCRIPT_FILENAME"].'<br>';
echo '- absolut path: '.__FILE__.'<br>';
// }
*/






/* ************ send mail *********** */
function back_call(){
	
	// if($_POST['name']) $data['name'] = trim($_POST['name']);			
	// if($_POST['email']) $data['email'] = trim($_POST['email']);					
	// if($_POST['message']) $data['message'] = trim($_POST['message']);	
	$errors = array();
	$data = array();

	foreach ($_POST as $k=>$item) {
		$item = trim( strip_tags($item) );
		// if( empty( $item )  ) $errors['errors'][$k] .= 'не заполнено';
		if( empty( $item )  ) $errors['errors'][$k] .= 'empty';
		else $data[$k] = $item;
	}		
		// if( !empty($data['name']) and !empty($data['email']) and !empty($data['message'])) {

	if( empty($errors) ){

		if( preg_match("/([a-z0-9_]+|[a-z0-9_]+\.[a-z0-9_]+)@(([a-z0-9]|[a-z0-9]+\.[a-z0-9]+)+\.([a-z]{2,4}))/i", $data['email']) )
		{

			// use PHPMailer\PHPMailer\PHPMailer;
			// use PHPMailer\PHPMailer\Exception;
			// require 'PHPMailer-master/src/Exception.php';
			// require 'PHPMailer-master/src/PHPMailer.php';
				// require 'PHPMailer-master/src/SMTP.php';

				//Create a new PHPMailer instance
			$mail = new PHPMailer;

			// print_r($mail);
			// exit;
			


				//Set who the message is to be sent from ( IMORTRANT LINE)
				// $mail->setFrom('from@example.com', 'First Last');
			// $mail->setFrom('admin@site.com', 'First Last');
			$mail->setFrom('admin@'.$_SERVER['HTTP_HOST'], 'Message');
			// $mail->setFrom('acclaim2@vmcp57.digitalpacific.com.au', 'First Last');
			// $mail->setFrom('condront@iinet.net.au', 'Message');

				//Set an alternative reply-to address

				// $mail->addReplyTo('replyto@example.com', 'First Last');
			// $mail->addReplyTo('freerun-2012@yandex.ru', 'First Last');

				//Set who the message is to be sent to
				// $mail->addAddress('whoto@example.com', 'John Doe');
			// $mail->addAddress('condront@iinet.net.au', 'John Doe');
			$mail->addAddress('alexey@webyourway.com.au', 'John Doe');
			$mail->addAddress('freerun-2012@yandex.ru', 'John M');
			// $mail->addAddress('rafael2013santi@gmail.com', 'John Doe');
				//Read an HTML message body from an external file, convert referenced images to embedded,
				//convert HTML into a basic plain-text alternative body
				// $mail->msgHTML(file_get_contents('contents.html'), __DIR__);

				//Attach an image file
				// $mail->addAttachment('attachment.png');

				//Content


				$mail->isHTML(true);                                  // Set email format to HTML
				
				// $mail->Body    = "First Name: " .$data['fname'].  "\r\nLast Name: " .$data['lname'].  "\r\nE-mail: " .$data['email'].  "\r\nMessage: \r\n" . $data['message'];
				// $mail->Body    = "First Name: " .$data['fname'].  "<br>Last Name: " .$data['lname'].  "<br>E-mail: " .$data['email'].  "<br>Message: <br>" . $data['message'].
				if($data['form_name'] == "as21-form-get-quote") 	{
					$mail->Subject = 'Free get a quote';

					$mail->Body = "Name: " .$data['name'].  "<br>Phone: " .$data['phone'].  "<br>E-mail: " .$data['email'].  "<br>Message: <br>" . $data['message'];
				}
				if($data['form_name'] == "as21-contact-form") {
					$mail->Subject = 'Contact form';

					$mail->Body  = "First Name: " .$data['fname'].  "<br>Last Name: " .$data['lname'].  "<br>E-mail: " .$data['email'].  "<br>Message: <br>" . $data['message'];
				}

				$mail->Body  .= '<hr><br> From: '.$_SERVER['HTTP_HOST'];

				/* 
				if use Joomla,give different params (e)
				$config = JFactory::getConfig();
				$mail->Body  .= ' temp: '.$config->get( 'sitename' );	
				$mail->Body  .= ' temp: '.$config->get( 'mailfrom' );	
				*/

				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

					// send the message, check for errors
				if (!$mail->send()) {
						// echo "Mailer Error: " . $mail->ErrorInfo;
					$data['error'] = $mail->ErrorInfo;
					echo json_encode($data); 
				} else {
						// echo "Message sent!";
					$data['res'] = 'success';
					echo json_encode($data); 
				}


			}else{
				// $errors['errors']['email'] = "некорректный !";
				$errors['errors']['email'] = "wrong !";
				echo json_encode($errors);
			}

		}else{
		// $data['res'] = 'error'; 
			echo json_encode($errors);
		}
		exit;

	}
	if( !empty($_POST['form_name']) && (bool)$_POST['as21-ajax']) back_call();
	else return false;

	?>