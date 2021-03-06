<?php

// Auth functions of the auth module

function auth_enticate()
{
    global $user;

    debug ("=== mod: auth; fn: auth_enticate ===");

	$result = 0;
	$user['id'] = 0;
	$user['group'] = 0;

    if (isset($_SESSION['authed']))
    {
        debug ("session has auth data");

        if ("1" == $_SESSION['authed'])
        {
			if (isset($_SESSION['id']))
			{
	            debug ("authed from session");
	            $user['id'] = $_SESSION['id'];
				$user['group'] = users_get_group($user['id']);
				$user['role'] = get_user_role($user['id']);
        	    debug ("user role: ".$user['role']);
	            $result = 1;
			}
			else
				unset($_SESSION['authed']);
        }
        else
            debug ("hadn't been authed from session");
    }
    else
    {
        debug ("session doesn't have auth data!");
        $_SESSION['authed'] = 0;
    }

	debug ("user id: ".$user['id']);
	debug ("user group: ".$user['group']);
	
    debug ("=== mod: auth; fn: auth_enticate ===");
    return $result;
}



function auth_login()
{
    global $user;
	global $config;

	debug ("=== mod: auth; fn: login ===");

	$content = array(
		'content' => '',
		'full_text' => '',
		'if_success' => '',
		'if_fail' => '',
		'if_empty_fields' => '',
		'if_user_not_exist' => '',
		'username' => '',
		'if_show_admin_link' => '',
		'if_password_dont_match' => '',
		'if_show_register_link' => '',
		'login' => ''
	);

	if (isset($_POST['login']))
		$login = $_POST['login'];
	else if (isset($_SESSION['login']))
		$login = $_SESSION['login'];
	else
		$login = "";

	if (isset($_POST['password']))
		$password = $_POST['password'];
	else if (isset($_SESSION['password']))
		$password = $_SESSION['password'];
	else
		$password = "";


	if (isset($_POST['do_login']) || isset($_POST['do_login_x']) || isset($_POST['do_login_y']))
		$if_login = 1;
	else if (isset($_SESSION['do_login']))
	{
		$if_login = 1;
		unset($_SESSION['do_login']);
	}
	else
		$if_login = 0;


    if ($if_login)
    {
        debug ("login data are available, trying to login");
		$content['login'] = $login;
		if (("" == $login) || ("" == $password))
		{
			debug("login or password is empty");
			$content['if_empty_fields'] = "yes";
			$result = 0;
		}
		else
		{
			$if_exist = db_get_count("ksh_users", "*", "`login` = '".db_escape($login)."'");
			debug("if exist login: ".$if_exist);
			if ("1" == $if_exist)
				$check_field = "login";
			else
			{
				$if_exist = db_get_count("ksh_users", "*", "`email` = '".db_escape($login)."'");
				debug("if exist email: ".$if_exist);

				if ("1" == $if_exist)
					$check_field = "email";
			}

	        if ("1" == $if_exist)
	        {
	            debug("user exists");
				$psw = db_get_field("ksh_users", "password", "`".$check_field."`= '".db_escape($login)."'");
	            debug("DB passw: ".$psw);
	            debug("given psw: ".md5($login."\n".$password));
	            if ($psw == md5($login."\n".$password))
	            {
	                debug ("password matches");
	                $_SESSION['authed'] = 1;
	                $user['id'] = auth_get_user_id($login);
	                debug("user id: ".$user['id']);
	                $_SESSION['id'] = $user['id'];
	                $result = 1;
	            }
	            else
	            {
	                debug ("password doesn't match!");
					$content['if_password_dont_match'] = "yes";
	                $_SESSION['authed'] = 0;
	                $result = 0;
	            }
	        }
	        else
	        {
	            debug("user doesn't exist!");
				$content['if_user_not_exist'] = "yes";
	            $_SESSION['authed'] = 0;
	            $result = 0;
	        }
		}
    }
    else
    {
        debug("no login data!");
        $result = 0;
    }

    if (1 == $result)
    {
		$sql_query = "UPDATE `ksh_users` SET 
			`last_login_date` = CURDATE(),
			`last_login_time` = CURTIME()
			WHERE `id` = '".db_escape($user['id'])."'";
		exec_query($sql_query);

		$content['if_success'] = "yes";
		$content['username'] = users_get_name($user['id']);
		if (1 == $user['id'])
			$content['if_show_admin_link'] = "yes";
		if (!headers_sent())
		{
			$redirect = users_get_redirect($user['id']);
			if ("/" == substr($redirect, 0, 1))
				$redirect = $config['base']['inst_root'].users_get_redirect($user['id']);
			else
				$redirect = $config['base']['inst_root']."/".users_get_redirect($user['id']);

			header("Location: ".$redirect);
		}
    }
    else
		$content['if_fail'] = "yes";

	if ("yes" == $config['auth']['allow_registration'])
		$content['if_show_register_link'] = "yes";

    debug ("=== end: mod: auth; fn: login ===");

    return $content;
}

function auth_logout()
{
    global $user;
	global $config;

    debug ("*** fn: logout");

    $content['content'] = "";

    $_SESSION['authed'] = 0;
    $user['id'] = 0;
    $user['role'] = 0;

    debug ("user id: ".$user['id']);
    debug ("user role: ".$user['role']);

    //$content = gen_auth_form();
    $content['content'] .= "<p>Выход выполнен успешено.</p>";

	if (isset($config['base']['inst_root']) && "" != $config['base']['inst_root'])
		$redirect_url = $config['base']['inst_root'];
	else
		$redirect_url = "/";

	if (!headers_sent())
		header("Location:".$redirect_url);

    debug ("*** end: fn: logout");
    return $content;
}


function auth_change_password()
{
	debug ("*** fn: change_password");
	global $user;
	$content = array(
		'result' => '',
		'if_show_change_form' => '',
		'if_show_login_link' => '',
		'res_wrong_old_psw' => '',
		'res_new_psw_not_eq' => '',
		'res_success' => ''
	);

	debug ("user id: ".$user['id']);

	if (!isset($user['id']))
	{
		$content['if_show_login_link'] = "yes";
	}
	else
	{
		if (isset($_POST['do_change']))
		{
			$row = db_get_row("ksh_users", "`id` = '".$user['id']."'");
			$login = stripslashes($row['login']);
			$db_old_password = $row['password'];
			debug ("DB old password hash: ".$db_old_password);
			$old_password = md5($login."\n".$_POST['old_password']);
			debug ("in old password hash: ".$old_password);
			if ($old_password != $db_old_password)
			{
				debug ("old password != DB old password");
				$content['res_wrong_old_psw'] = "yes";
				$content['if_show_change_form'] = "yes";
			}
			else if ($_POST['new_password_1'] != $_POST['new_password_2'])
			{
				debug("new passwords are not equal");
				$content['res_new_psw_not_eq'] = "yes";
				$content['if_show_change_form'] = "yes";
			}
			else
			{
				debug ("all OK, changing");
				$new_password = md5($login."\n".$_POST['new_password_1']);
				debug ("new password hash: ".$new_password);
				$sql_query = "UPDATE `ksh_users` SET `password` = '".db_escape($new_password)."' WHERE `id` = '".db_escape($user['id'])."'";
				$result = exec_query($sql_query);
				if (0 == mysqli_errno($config['db']['conn_id']))
				{
					debug ("OK");
					$content['res_success'] = "yes";
					auth_logout();
				}
				else
				{
					debug ("Error ".mysqli_errno($config['db']['conn_id']) . ": " . mysqli_error($config['db']['conn_id']));
					$content['res_db_error'] = "yes";
				}
			}
		}
		else
		{
			$content['if_show_change_form'] = "yes";
		}
	}

	debug ("*** end: fn: change_password");
	return ($content);
}


function auth_register()
{
    debug ("*** auth_register ***");
    global $user;
	global $config;

    $content = array(
		'content' => '',
		'if_email_exists' => '',
		'if_success' => '',
		'if_use_registration_form' => ''
	);

	if (isset($_POST))
		foreach($_POST as $k => $v)
		{
			$content[$k] = htmlspecialchars($v);
			if ("" == $v)
				$content['if_'.$k.'_empty'] = "yes";
		}

	$if_register = 1;

    if (isset($_POST['do_register']))
    {
        debug ("have POST data");

		$qty = db_get_count("ksh_users", "*", "`email`='".db_escape($_POST['email'])."'");
		if ("0" != $qty)
		{
            debug ("email already exists!");
			$if_register = 0;
			$content['if_email_exists'] = "yes";
		}

        if (1 == $if_register)
        {

            debug ("trying to register");

			debug ("POST email: ".$_POST['email']);

			$password = auth_gen_password();

			$db_password = auth_crypt_password($_POST['email'], $password);

			debug ("DB passwd: ".$db_password);

			$fields = "`email`, `name`, `login`, `password`, `group`";
			$values = "'".db_escape($_POST['email'])."',
				'".db_escape($_POST['email'])."',
				'".db_escape($_POST['email'])."',
				'".db_escape($db_password)."',
				'2'";


			debug("fields: ".$fields);
			debug("values: ".$values);

			$sql_query = "INSERT INTO `ksh_users` (".$fields.") VALUES (".$values.")";
            exec_query($sql_query);

            $content['if_success'] = "yes";

			$_SESSION['do_login'] = "yes";
			$_SESSION['login'] = $_POST['email'];
			$_SESSION['reg_password'] = $password;
			$_SESSION['POST'] = $_POST;
			$_SESSION['id'] = db_get_field("ksh_users", "id", "`email` = '".db_escape($_POST['email'])."'");
			$_SESSION['authed'] = 1;

			/* Mail block */

			$mail_params = array(
				'login' => $_SESSION['login'],
				'email' => $_POST['email'],
				'password' => $_SESSION['reg_password'],
				'site_name' => $config['base']['site_name'],
				'site_url' => $config['base']['site_url']
			);

			$mail = new Mail();
			$mail -> to = $config['base']['admin_email'];
			$mail -> subject = gen_content("auth", "mail_register_admin_subject", $mail_params);
			$mail -> module = "auth";
			$mail -> template = "mail_register_admin_message";
			$mail -> send($mail_params);

			$mail = new Mail();
			$mail -> to = $_POST['email'];
			$mail -> subject = gen_content("auth", "mail_register_user_subject", $mail_params);
			$mail -> module = "auth";
			$mail -> template = "mail_register_user_message";
			$mail -> send($mail_params);

			/* end: Mail block */

			if (!headers_sent())
				header("Location: /users/profile_view/");
        }

    }
    else
    {
        debug ("doesn't have POST data!");
		$content['if_use_registration_form'] = "yes";
    }

    if (0 == $if_register)
	{
		$tpl_name = "show_register_form";
		$content['content'] .= gen_content("auth", $tpl_name, array_merge(auth_show_register_form(), $content));
	}

    debug ("*** auth_register ***");
    return $content;
}

function auth_check_password_strength($password)
{
    debug ("*** auth_check_password_quality ***");
    global $user;
	global $config;

    $password_complexity = 0;


    if(strlen($password) >= 6)
        $password_complexity++;

    // Numbers
    if(preg_match("/([0-9]+)/", $password))
        $password_complexity++;
    
    // Letters in uppercase
    if((preg_match("/([A-Z]+)/", $password)) || (preg_match("/([А-Я]+)/", $password)))
        $password_complexity++;
    
    // Letters in lowercase
    if((preg_match("/([a-z]+)/", $password)) || (preg_match("/([а-я]+)/", $password)))
        $password_complexity++;

    if($password_complexity == 4)
		$result = 1;
    else
		$result = 0;

	debug ("*** end: auth_check_password_strength ***");
	return $result;
}

function auth_gen_password()
{
	global $config;

	debug ("*** auth_gen_password ***");

	$length = 13;

	$psw="";
	for($i=0; $i < $length; $i++)
	{
		$num = rand(48,122);
		if ((($num > 57) && ($num < 65)) || (($num > 90) && ($num < 97)))
			$num = rand(48, 57);
		$psw.=chr($num);
	}

	debug ("*** end: auth_gen_password ***");
	return $psw;
}

function auth_crypt_password($login, $password)
{
	global $config;

	debug ("*** auth_crypt_password ***");

	$password_new = md5($login."\n".$password);

	debug ("*** end: auth_crypt_password ***");

	return $password_new;
}

function auth_get_user_id($login)
{
    debug ("*** auth_get_user_id ***");

	$id = db_get_field("ksh_users", "id", " `login` = '".db_escape($login)."'");
    debug("user id: ".$id);

    debug ("*** end: auth_get_user_id ***");
    return $id;
}

function auth_reset_password()
{
    global $user;
	global $config;

	debug ("=== mod: auth; fn: reset_password ===");

	$content = array(
		'email' => '',
		'if_show_form' => 'yes',
		'password_changed' => '',
		'empty_email' => '',
		'no_email' => '',
		'if_show_register_link' => ''
	);

	if (isset($_POST['do_reset']))
	{
		if (isset($_POST['email']))
		{
			if ("" == $_POST['email'])
				$content['empty_email'] = "yes";
			else
			{
				$email = $_POST['email'];
				$content['email'] = $email;

				$if_exist = db_get_count("ksh_users", "*", "`email` = '".db_escape($email)."'");
				debug("if exist email: ".$if_exist);
				if ("1" == $if_exist)
				{
					$login = db_get_field("ksh_users", "login", "`email`= '".db_escape($email)."'");
					debug("login: ".$login);

					$password = auth_gen_password();
					debug("new password: ".$password);

					$db_password = auth_crypt_password($login, $password);
					debug ("DB passwd: ".$db_password);

					$sql_query = "UPDATE `ksh_users` SET `password` = '".db_escape($db_password)."' WHERE `login` = '".db_escape($login)."' AND `email` = '".db_escape($email)."'";
					exec_query($sql_query);

					/* Mail block */

					$mail_params = array(
						'login' => $login,
						'email' => $email,
						'password' => $password,
						'site_name' => $config['base']['site_name'],
						'site_url' => $config['base']['site_url']
					);

					$mail = new Mail();
					$mail -> to = $email;
					$mail -> subject = gen_content("auth", "mail_change_password_user_subject", $mail_params);
					$mail -> module = "auth";
					$mail -> template = "mail_change_password_user_message";
					$mail -> send($mail_params);

					/* end: Mail block */

					$content['password_changed'] = "yes";
					$content['if_show_form'] = "";
				}
				else
					$content['no_email'] = "yes";
			}

		}

	}


	if ("yes" == $config['auth']['allow_registration'])
		$content['if_show_register_link'] = "yes";

    debug ("=== end: mod: auth; fn: reset_password ===");

	return $content;
}

?>
