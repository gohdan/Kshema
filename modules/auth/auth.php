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
        //$_SESSION['authed'] = 1;
        if ("1" == $_SESSION['authed'])
        {
            debug ("authed from session");
            //$user['id'] = get_user_id();
            $user['id'] = $_SESSION['id'];
			$user['group'] = users_get_group($user['id']);
			$user['role'] = get_user_role($user['id']);
            debug ("user role: ".$user['role']);
            $result = 1;
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
		if ("" == $login && "" == $password)
		{
			$content['if_empty_fields'] = "yes";
			$content['if_empty_login'] = "yes";
			$content['if_empty_password'] = "yes";
			$result = 0;
		}
		else if ("" == $login)
		{
			$content['if_empty_login'] = "yes";
			$result = 0;
		}
		else if ("" == $password)
		{
			$content['if_empty_password'] = "yes";
			$result = 0;
		}
		else
		{
			$sql_query = "SELECT count(*) FROM `ksh_users` WHERE `login` = '".mysql_real_escape_string($login)."'";
	        $result = exec_query($sql_query);
	        $if_exist = mysql_result($result, 0, 0);
	        mysql_free_result($result);

	        if ("1" == $if_exist)
	        {
	            debug("user exists");
				$sql_query = "SELECT `password` FROM `ksh_users` WHERE `login`= '".mysql_real_escape_string($login)."'";
	            $result = exec_query($sql_query);
	            $psw = mysql_result($result, 0, 0);
	            mysql_free_result($result);
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

    debug ("=== end: mod: auth; fn: login ===");

    if (1 == $result)
    {
		$sql_query = "UPDATE `ksh_users` SET 
			`last_login_date` = CURDATE(),
			`last_login_time` = CURTIME()
			WHERE `id` = '".mysql_real_escape_string($user['id'])."'";
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
	{
		$content['if_fail'] = "yes";
	}

	if ("yes" == $config['auth']['allow_registration'])
		$content['if_show_register_link'] = "yes";

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
			$sql_query = "SELECT `login`, `password` FROM `ksh_users` WHERE `id` = '".$user['id']."'";
			$result = exec_query($sql_query);
			$row = mysql_fetch_array($result);
			mysql_free_result($result);
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
				$sql_query = "UPDATE `ksh_users` SET `password` = '".mysql_real_escape_string($new_password)."' WHERE `id` = '".mysql_real_escape_string($user['id'])."'";
				$result = exec_query($sql_query);
				if (0 == mysql_errno())
				{
					debug ("OK");
					$content['res_success'] = "yes";
					auth_logout();
				}
				else
				{
					debug ("Error ".mysql_errno() . ": " . mysql_error());
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

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    $content = array(
		'content' => '',
		'session_name' => session_name(),
		'session_id' => session_id(),
		'if_wrong_captcha' => '',
		'if_passwords_not_equal' => '',
		'if_login_exists' => '',
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

	if(isset($_POST['city']))
		$content['city_selected_'.$_POST['city']] = "yes";

	$if_register = 1;

    if (isset($_POST['do_register']))
    {
        debug ("have POST data");

		if(!isset($_SESSION['captcha_keystring']) || ($_SESSION['captcha_keystring'] !=  $_POST['keystring']))
		{
			$content['if_wrong_captcha'] = "yes";
			$if_register = 0;
		}

		if ("" == $_POST['password1'])
		{
			$content['if_empty_password'] = "yes";
			$if_register = 0;
		}

		if ($_POST['password1'] != $_POST['password2'])
		{
			debug ("passwords are not equal!");
			$content['if_passwords_not_equal'] = "yes";
			$if_register = 0;
		}

		if ("yes" == $config['auth']['strong_passwords'] && !auth_check_password_strength($_POST['password1']))
		{
			$content['if_weak_password'] = "yes";
			$if_register = 0;		
		}

		if (isset($_POST['group']))
		{
			debug ("group is set");
			if (isset($config['auth']['required_fields'][$_POST['group']]))
			{
				debug ("; required fields are set");
				foreach($config['auth']['required_fields'][$_POST['group']] as $k => $v)
				{
					debug ("field: ".$v);
					if (!isset($_POST[$v]) || "" == $_POST[$v])
					{
						debug ("post ".$v.": empty");
						$if_register = 0;
					}
					else
						debug ("post ".$v.": not empty");
				}
			}
			
			if (isset($config['auth']['required_fields_alt'][$_POST['group']]))
			{
				debug ("; alternate required fields are set");
				$if_field_exists = 0;
				foreach($config['auth']['required_fields_alt'][$_POST['group']] as $field_group_id => $field_group)
				{
					debug ("checking field group ".$field_group_id);
					foreach ($field_group as $k => $v)
					{
						debug ("field: ".$v);
						if (isset($_POST[$v]) && "" != $_POST[$v])
						{
							debug ("post ".$v.": set");
							$if_field_exists = 1;
						}
						else
							debug ("post ".$v.": empty");
					}

					if (!$if_field_exists)
					{
						debug ("alternate fields are not set");
						$if_register = 0;
					}
					else
						debug ("alternate fields are set");
				}
			}
		}

		$sql_query = "SELECT count(*) FROM ksh_users WHERE login='".mysql_real_escape_string($_POST['login'])."'";
        $result = exec_query($sql_query);
       	$if_exist = mysql_result($result, 0, 0);
        mysql_free_result($result);
		if ("0" != $if_exist)
		{
            debug ("such login exists!");
			$if_register = 0;
			$content['if_login_exists'] = "yes";
		}

        if (1 == $if_register)
        {

            debug ("trying to register");

			if (isset($_POST['group']) && is_numeric($_POST['group']) && ("1" != $_POST['group']))
				$group = $_POST['group'];
			else
				$group = 2;

			debug ("POST login: ".$_POST['login']);
			debug ("POST passwd: ".md5($_POST['password1']));
			debug ("DB passwd: ".md5($_POST['login']."\n".$_POST['password1']));

			$fields = "`login`, `password`, `group`";
			$values = "'".mysql_real_escape_string($_POST['login'])."',
				'".mysql_real_escape_string(md5($_POST['login']."\n".$_POST['password1']))."',
				'".mysql_real_escape_string($group)."'";

			$reg_fields = array(
				'name', 'first_name', 'sur_name', 'city', 'site', 'url', 'phone', 'phone_mob', 'phone_stat'
			);

			foreach($reg_fields as $k => $v)
				if (isset($_POST[$v]))
				{
					$fields .= ", `".mysql_real_escape_string($v)."`";
					$values .= ", '".mysql_real_escape_string($_POST[$v])."'";
				}



		    if (isset($_FILES['image']))
			{
				$image = $_FILES['image'];
			    $if_file_exists = 0;
			    $file_path = "";

                if ((isset($image)) && ("" != $image['name']))
                {

                    debug ("there is an image to upload");
                    if (file_exists($doc_root.$upl_pics_dir."users/".$image['name'])) $if_file_exists = 1;
                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."users/",$if_file_exists);
                    debug ("size: ".filesize($home.$file_path));

                    if (filesize($home.$file_path) > $max_file_size)
                    {
                        debug ("file size > max file size!");
                        $content .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
                        if (unlink ($home.$file_path)) debug ("file deleted");
                        else debug ("can't delete file!");
                        $file_path = "";
                    }

                    $_POST['image'] = $file_path;

                }
                else
                {
                    debug ("no image to upload");
                    if (isset($_POST['image']))
                    	$file_path = $_POST['image'];
                    else
                    	$file_path = "";
                }

				if ("" != $file_path)
				{
					$fields .= ", `image`";
					$values .= ", '".mysql_real_escape_string($file_path)."'";
				}

			}

			debug("fields: ".$fields);
			debug("values: ".$values);

			if (isset($config['users']['additional_fields']))
				foreach($config['users']['additional_fields'] as $k => $v)
					if ("" != $v['name'])
						if (isset($_POST[$v['name']]))
						{
							$fields .= ", `".mysql_real_escape_string($v['name'])."`";
							if (is_array($_POST[$v['name']]))
							{
								$values .= ", '";
								foreach($_POST[$v['name']] as $af_idx => $af_val)
									$values .= "|".mysql_real_escape_string($af_val);
								$values .= "|'";
							}
							else
							{
								debug($v['name'].": ".$_POST[$v['name']]);
								$values .= ", '".mysql_real_escape_string($_POST[$v['name']])."'";
							}
						}

			$sql_query = "INSERT INTO ksh_users (".$fields.") VALUES (".$values.")";
			echo ($sql_query);


            exec_query($sql_query);

            $content['if_success'] = "yes";

			/* Mail block */

			$cnt['site_url'] = $config['base']['site_url'];	
			$cnt['site_name'] = $config['base']['site_name'];
			if (isset($_POST['name']) && ("" != $_POST['name']))
				$cnt['name'] = $_POST['name'];
			else
				if (isset($_POST['first_name']) && ("" != $_POST['first_name']))
					$cnt['name'] = $_POST['first_name'];

			$cnt['login'] = $_POST['login'];
			$cnt['password'] = $_POST['password1'];
			$cnt['admin_email'] = $config['base']['admin_email'];

			$headers = "Content-type: text/plain; charset=windows-1251 \r\n";
			$to = $_POST['login'];
			$subject = gen_content("auth", "mail_register_user_subject", $cnt);
			$message = gen_content("auth", "mail_register_user_message", $cnt);

			mail ($to, $subject, $message, $headers);

			$to = $config['base']['admin_email'];
			$subject = gen_content("auth", "mail_register_admin_subject", $cnt);
			$message = gen_content("auth", "mail_register_admin_message", $cnt);

			mail ($to, $subject, $message, $headers);

			/* End: Mail block */

			$_SESSION['do_login'] = "yes";
			$_SESSION['login'] = $_POST['login'];
			$_SESSION['password'] = $_POST['password1'];
			$_SESSION['POST'] = $_POST;

			if (!headers_sent())
				header("Location: ".$config['base']['inst_root']."/auth/login/");
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
		if (isset($_GET['group']))
			$tpl_name .= "_".$_GET['group'];
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

?>
