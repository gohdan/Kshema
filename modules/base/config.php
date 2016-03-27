<?php

global $config;
global $debug;
global $user;
global $upl_pics_dir;
global $doc_root;
global $max_file_size;
global $home;
global $page_title;
global $template;

$mods_dir = "modules";
$upl_pics_dir = "/uploads/"; // must be writable to web server
$max_file_size = 2000 * 1024; // in bytes
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$home = $doc_root;

$page_title = "Kshema";

$config['base']['site_name'] = "Kshema";
$config['base']['site_owner'] = "Goh'Dan";
$config['base']['site_url'] = "http://kshema-test.gohdan.ru";
$config['base']['admin_email'] = "gohdan@gohdan.ru";

$config['base']['version'] = "0.8.5";

$config['base']['debug_level'] = 0; // 0 - no debug, 1 - simple debug, 2 - verbose debug (var dump etc.);
$config['base']['debug_user'] = 0; // set to 0 to show debug to every (even non-authenticated) user
$config['base']['error_reporting'] = 0; // use in production
//$config['base']['error_reporting'] = E_ALL; // use to develop
$config['base']['logs_path'] = $_SERVER['DOCUMENT_ROOT']."/logs/";
$config['base']['logs_write'] = "yes";
$config['base']['debug_echo'] = "no";
$config['base']['debug_file'] = "no";

$config['base']['inst_root'] = ""; // Put here a directory Kshema is installed in; no slash at the end!
$config['base']['domain_dir'] = "";
$config['base']['doc_root'] = $_SERVER['DOCUMENT_ROOT'].$config['base']['inst_root'] ;
$config['base']['output_charset'] = "utf8"; // utf8 or utf8

$config['base']['ftp_server'] = "kshema.handyhosting.ru";
$config['base']['ftp_username'] = "kshema";
$config['base']['ftp_password'] = "kshems";
$config['base']['ftp_root'] = '/home/kshema/www/';

$config['base']['categories']['list_prefix'] = " .";
$config['base']['categories']['chain_divider'] = " / ";

$config['base']['ext_links_redirect'] = "no";
$config['base']['use_captcha'] = "no";

$config['base']['http_redirect'] = array(
	'301' => array(
		// '/query' => 'new location'
	) 
);

$config['base']['url_short'] = array(
	'admin' => 'auth/show_login_form'
);

$config['base']['lang']['default'] = "ru";
$config['base']['lang']['current'] = $config['base']['lang']['default'];
$config['base']['lang']['list'][] = "ru";
$config['base']['lang']['list'][] = "en";
$config['base']['lang']['list'][] = "de";

$config['base']['lang']['titles'] = array(
	"ru" => "Русский",
	"en" => "English",
	"de" => "Deutch"
);

$config['base']['lang']['titles_int'] = array(
	"ru" => "Russian",
	"en" => "English",
	"de" => "German"
);

$config['base']['send_emails'] = "yes"; // set to "yes" to send

$config['base']['mail']['from_address'] = "kshema@handyhosting.ru";
$config['base']['mail']['from_name'] = "Kshema";
$config['base']['mail']['host'] = "handyhosting.ru"; // Host to connect. Default is localhost
$config['base']['mail']['username'] = "kshema"; // The username to use for SMTP authentication.
$config['base']['mail']['password'] = "kshema"; // The password to use for SMTP authentication.
$config['base']['mail']['port'] = "25"; // The port to connect. Default is 25
$config['base']['mail']['backend'] = "smtp"; // mail, sendmail, smtp
$config['base']['mail']['sendmail_path'] = "/usr/bin/sendmail"; // The location of the sendmail program on the filesystem. Default is /usr/bin/sendmail
$config['base']['mail']['sendmail_args'] = "-i"; // Additional parameters to pass to the sendmail. Default is -i
$config['base']['mail']['auth'] = "TRUE"; // Whether or not to use SMTP authentication. Default is FALSE
$config['base']['mail']['localhost'] = "localhost"; // The value to give when sending EHLO or HELO. Default is localhost
$config['base']['mail']['timeout'] = "NULL"; // The SMTP connection timeout. Default is NULL (no timeout)
$config['base']['mail']['verp'] = "FALSE"; // Whether to use VERP or not. Default is FALSE
$config['base']['mail']['debug'] = "TRUE"; // Whether to enable SMTP debug mode or not. Default is FALSE
//$config['base']['mail']['persist'] = "yes"; // Indicates whether or not the SMTP connection should persist over multiple calls to the send() method.
$config['base']['mail']['use_phpmailer'] = "yes"; // Use PHPMailer class to send emails through SMTP

$config['base']['timezone'] = "Europe/Moscow";

$config['libs']['location'] = $_SERVER['DOCUMENT_ROOT']."libs/";

$config['recaptcha']['use'] = "no";
$config['recaptcha']['url'] = "https://www.google.com/recaptcha/api/siteverify";
$config['recaptcha']['secret'] = "";
$config['recaptcha']['sitekey'] = "";

$config['satellite']['use'] = "no";
$config['satellite']['table'] = "ksh_bbcpanel_bbs";
$config['satellite']['id'] = "1";

$config['template']['css'] = array(); // additional CSS file

?>
