<?php
header('Content-Type: text/html; charset=utf-8');

echo 'test work mail()';
$to = 'freerun-2012@yandex.ru'; 
$to2 = 'alexey@webyourway.com.au'; 
$sitename = $_SERVER['HTTP_HOST'];
$subject = "Subject";
$message = "test work mail: SUCCESS ! \r\n";
$headers = "From: {$sitename} <admin@".$sitename.">\r\nContent-type:text/plain; charset=utf-8\r\n";
if( mail($to2,$subject,$message,$headers) ) echo 'Success! mail send!';


$_POST['t'] = '';
$_POST['t2'] = '';
	foreach ($_POST as $k=>$item) {
		$item = trim( strip_tags($item) );
		if( empty( $item )  ) $error[$k] .= 'не заполнено';
		else $data[$k] = $item;
	}	

var_dump($error);
var_dump(empty($error));
var_dump($data);
exit;

/* ************ send mail *********** */
function back_call(){
	
	// if($_POST['name']) $data['name'] = trim($_POST['name']);			
	// if($_POST['email']) $data['email'] = trim($_POST['email']);					
	// if($_POST['message']) $data['message'] = trim($_POST['message']);	
	$errors = array();
	$data = array();

	foreach ($_POST as $k=>$item) {
		$item = trim( strip_tags($item) );
		if( empty( $item )  ) $errors['errors'][$k] .= 'не заполнено';
		else $data[$k] = $item;
	}		
		// if( !empty($data['name']) and !empty($data['email']) and !empty($data['message'])) {
	if( empty($errors) ){

		if( preg_match("/([a-z0-9_]+|[a-z0-9_]+\.[a-z0-9_]+)@(([a-z0-9]|[a-z0-9]+\.[a-z0-9]+)+\.([a-z]{2,4}))/i", $data['email']) )
		{

			$to = 'freerun-2012@yandex.ru'; 
			$to2 = 'alexey@webyourway.com.au'; 
			$sitename = $_SERVER['HTTP_HOST'];
			$subject = "Subject";
			// foreach ($item as $k => $v) {
			// 	$fields_val .= $field
			// }
			$message = "First Name: " .$data['fname'].  "\r\nLast Name: " .$data['lname'].  "\r\nE-mail: " .$data['email'].  "\r\nMessage: \r\n" . $data['message'];
			// если почта отправителя и домен не совпадают то письмо не доходит!
			$headers = "From: {$sitename} <no-replay@".$sitename. ">\r\nContent-type:text/plain; charset=utf-8\r\n";
			if( mail($to2,$subject,$message,$headers) ){
				// $data['res'] = 'success'.$message.$sitename.$headers;
				$data['res'] = 'success';
				echo json_encode($data); 
			}
			else{
				$data['error'] = 'функци mail не сработала!';
				echo json_encode($data); 
			}
		}else{
			$errors['errors']['email'] = "некорректный !";
			echo json_encode($errors);
		}
	}
	else{
		// $data['res'] = 'error'; 
		echo json_encode($errors);
	}
}
if( !empty($_POST['form_name']) ) back_call();
else return false;

?>