<?php

class Mail
{

var $module = "base";
var $template = "mail";
var $subject = "";
var $to = "";
var $from_name = "";
var $from = "";

function send($params = array())
{
	global $config;
	debug ("=== Mail -> send ===");

	if ("" != $this->subject)
		$subject = $this->subject;
	else
		$subject = $config['mail']['subject'];
	
	if ("" != $this->to)
		$to = $this->to;
	else
		$to = $config['mail']['to'];
	
	if ("" != $this->from_name)
		$from_name = $this->from_name;
	else
		$from_name = $config['mail']['from_name'];
	
	if ("" != $this->from)
		$from = $this->from;
	else
		$from = $config['mail']['from'];

	$subject = '=?utf-8?B?'.base64_encode($subject).'?=';

	$message = gen_content($this->module, $this->template, $params);

	if ("yes" == $config['mail']['direct'])
	{
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain; charset=utf-8\r\n";
		$headers .= "Content-Transfer-Encoding: 8bit \r\n";

		if ("" != $from_name)
			$headers .= "From: ".$from_name." <".$from.">\r\n";
		else
			$headers .= "From: ".$from."\r\n";
		if ("yes" == $config['mail']['bcc_admin'])
			$headers .= "Bcc: ".$config['mail']['admin_email']."\r\n";

		if (is_array($to))
		{
			$to_new = "";
			foreach ($to as $k => $v)
				$to_new .= $v.", ";
			rtrim($to_new, ", ");
			$to = $to_new;
		}

		$message = wordwrap($message, 70, "\r\n");

		if (mail($to, $subject, $message, $headers))
			$result = 1;
		else
			$result = 0;
	}
	else
	{
		include_once ($_SERVER['DOCUMENT_ROOT']."/libs/phpmailer/PHPMailerAutoload.php");

		$mail = new PHPMailer();

		$mail->setLanguage('ru');
		$mail->CharSet = "utf-8";
		$mail->IsSMTP(); // set mailer to use SMTP
		$mail->Host = $config['mail']['host']; // specify main and backup server
		$mail->Port = $config['mail']['port'];
		$mail->SMTPAuth = true; // turn on SMTP authentication
		if ("yes" == $config['mail']['ssl'])
			$mail->SMTPSecure = 'ssl'; // Enable SSL encryption, `tls` also accepted
		$mail->Username = $config['mail']['username']; // SMTP username
		$mail->Password = $config['mail']['password']; // SMTP password

		$mail->From = $from;
		$mail->FromName = $from_name;

		if (is_array($to))
		{
			foreach($to as $k => $v)
				$mail->AddAddress($v);
		}
		else
				$mail->AddAddress($to);

		if ("yes" == $config['mail']['bcc_admin'])
			$mail->addBCC($config['mail']['admin_email']);

		$mail->WordWrap = 70;                                 // set word wrap to 50 characters
		$mail->IsHTML(false);                                  // set email format to HTML

		$mail->Subject = $subject;
		$mail->Body = $message;

		if($mail->Send())
			$result = 1;
		else
		{
			$result = 0;
			$error = $mail->ErrorInfo;
		}
	}

	if ($result)
		debug ("ok");
	else
		debug ($error);

	debug("=== end: Mail -> send ===");
	return $result;
}

}
