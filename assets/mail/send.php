<?php
error_reporting('ALL^NOTICE');
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')){

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

require 'class.phpmailer.php';
//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->SMTPDebug = 0;
$mail->do_debug = 0;
//Set who the message is to be sent from
$mail->setFrom($email, $name);
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress('contact@mohankhadka.com.np', 'Mohan Khadka');
//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($message);
//Replace the plain text body with one created manually
//$mail->AltBody = $_POST['message'];

$replyTo = new PHPMailer();
$replyTo->SMTPDebug = 0;
$replyTo->do_debug = 0;
$replyTo->setFrom('contact@mohankhadka.com.np', 'Mohan Khadka');
$replyTo->addAddress($email, $name);
$replyTo->Subject = 'Thank You For Mailing';
$replyTo->msgHTML("Howdy <b>".$name."</b>,<br><br>Thank you so much for your valuable message.<br><br><b>Warm Regards</b><br>Mohan Khadka<br>Web: www.mohankhadka.com.np<br>Email: contact@mohankhadka.com.np");

if(empty($name)){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Please enter your name.</span>';
	exit();
}
elseif (strlen($name) > 64 || strlen($name) < 4){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Name must be (4 - 64) characters.</span>';
	exit();
}
elseif (empty($email)){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> E-mail cannot be blank! fill out.</span>';
	exit();
}
elseif (strlen($email) > 64) {
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Email cannot be longer than 64 characters.</span>';
	exit();
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Not a valid format email address.</span>';
	exit();
}
elseif (empty($subject)){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Please enter your subject.</span>';
	exit();
}
elseif (empty($message)){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Please enter your message.</span>';
	exit();
}
elseif (strlen($message) < 10){
	echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Message length min 10 character.</span>';
	exit();
}
//send the message, check for errors
if (!$mail->send()) {
    echo '<span class="failure"><i class="icon-remove-sign icon-large"></i> Mailer Error: ' . $mail->ErrorInfo.'</span>';
} else {
	$replyTo->send();
    echo '<span class="success"><i class="icon-ok-sign icon-large"></i> Thank you!! Message has been sent!</span><p>clear</p>';
}
//denied
} else {
?>
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL <?php echo $_SERVER[PHP_SELF]?> was not found on this server.</p>
<p>Additionally, a 404 Not Found
error was encountered while trying to use an ErrorDocument to handle the request.</p>
</body></html>
<?php
}
?>