<?php
require 'PHPMailer/PHPMailerAutoload.php';
if($_POST['email']) {
	$name = $_POST['uname'];
	$toEmail = 'fernhills.technologies@gmail.com'; //$_POST['email'];
	$message = $_POST['message'];
	try {
		$mail = new PHPMailer;
		$mail->AddAddress($toEmail);
		$mail->From = "admin@webdamn.com";
		$mail->Subject = "From Fernhill Technologies";
		$body = "<table>
			<tr>
			<th colspan='2'>New Mail from Fernhill Website</th>
			</tr>
			<tr>
			<td>Name :</td>
			<td>".$name."</td>
			</tr>
            <tr>
			<td>Email : </td>
			<td>".$toEmail."</td>
			</tr>

			<tr>
			<td>Message : </td>
			<td>".$message."</td>
			</tr>

			<table>";
			$body = preg_replace('/\\\\/','', $body);
			$mail->MsgHTML($body);
			$mail->IsSendmail();
			$mail->AddReplyTo("admin@webdamn.com");
			$mail->AltBody = "To view the message, please use an HTML compatible email viewer!";
			$mail->WordWrap = 80;
			$mail->AddAttachment($_FILES['attachFile']['tmp_name'], $_FILES['attachFile']['name']);
			$mail->IsHTML(true);
			$mail->Send();
			header("Location: index.php?success=1");
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>