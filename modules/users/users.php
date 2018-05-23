<?php

function users_users_list()
{
	debug ("*** users_users_list ***");
	global $config;
	global $user;
	$i = 0;
	$result = exec_query ("SELECT * FROM `ksh_users` ORDER BY `id`");
	while ($user = mysqli_fetch_array($result))
	{

			$users[$i]['id'] = stripslashes($user['id']);
			$users[$i]['login'] = stripslashes($user['login']);
			$users[$i]['name'] = stripslashes($user['name']);
			$users[$i]['email'] = stripslashes($user['email']);
			$users[$i]['password'] = stripslashes($user['password']);
			$users[$i]['first_name'] = stripslashes($user['first_name']);
			$users[$i]['second_name'] = stripslashes($user['second_name']);
			$users[$i]['sur_name'] = stripslashes($user['sur_name']);
			$users[$i]['country'] = stripslashes($user['country']);
			$users[$i]['post_code'] = stripslashes($user['post_code']);
			$users[$i]['area'] = stripslashes($user['area']);
			$users[$i]['city'] = stripslashes($user['city']);
			$users[$i]['address'] = stripslashes($user['address']);
			$users[$i]['group'] = users_get_group_title(stripslashes($user['group']));
		$i++;
	}
	mysqli_free_result($result);
	debug ("*** end: users_users_list ***");
	return $users;
}

function users_add()
{
	global $user;
	global $config;
	debug("*** users_add ***");

	$content = array(
		'result' => '',
		'show_add_form' => '',
		'group' => ''
	);

	if (isset($_POST['group']))
		$group = $_POST['group'];
	else if (isset($_GET['element']))
		$group = $_GET['element'];
	else
		$group = 0;

	$content['group'] = $group;
	
	$priv = new Privileges();

	if ($priv -> has("users", "add", "write"))
	{
		debug("user has rights");
		$content['show_add_form'] = "yes";
		if (isset($_POST['do_add']))
		{
			debug("have data to add");
			$sql_query = "INSERT INTO `ksh_users` (`login`, `name`, `email`, `group`, `password`) VALUES (
				'".db_escape($_POST['login'])."',
				'".db_escape($_POST['name'])."',
				'".db_escape($_POST['email'])."',
				'".db_escape($_POST['group'])."',
				'".db_escape(md5($_POST['login']."\n".$_POST['password']))."'
			)";
			exec_query($sql_query);
			$content['result'] = "Пользователь добавлен";
		}
	}
	else
		$content['result'] = "Недостаточно прав";

	debug("*** end: users_add ***");
	return $content;
}

function users_view_users()
{
	global $user;
	global $config;
	debug ("*** users_view_users ***");
	$content = array(
		'result' => '',
		'content' => '',
		'users' => '',
		'show_admin_link' => ''
	);

	$priv = new Privileges();

	if ($priv -> has("users", "view_users", "write"))
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";

		if (isset($_POST['do_del']))
		{
			$sql_query = "DELETE FROM ksh_users WHERE id='".db_escape($_POST['id'])."'";
			exec_query($sql_query);
			$content['result'] .= "Пользователь удалён.";
		}

		$content['users'] = users_users_list();
	}
	else
	{
		debug ("user isn't admin");
		$content['content'] = "Пожалуйста, войдите как администратор";
	}

	debug ("*** end:users_view_users ***");
	return $content;
}

function users_profile_edit()
{
	debug ("*** users_profile_edit ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => ''
	);

	$priv = new Privileges();
	if ($priv -> has("users", "profile_edit", "write") || $_POST['id'] == $user['id'])
	{
		debug ("user is admin");

		if (isset($_POST['do_change']))
	    {
	        debug ("writing to DB");
	        unset ($_POST['do_change']);

	        $sql_query = "UPDATE `ksh_users` SET ";
	        foreach ($_POST as $k => $v)
				$sql_query .= "`".$k."` = '".db_escape($v)."', ";
			$sql_query = rtrim($sql_query, ", ");
	        $sql_query .= " WHERE `id` = '".$user['id']."'";

	        exec_query ($sql_query);
	        $content['result'] .= "Ваши данные обновлены.";
	    }

		$result = exec_query("SELECT * FROM ksh_users WHERE id='".db_escape($user['id'])."'");
	    $user_data = mysqli_fetch_array($result);
	    mysqli_free_result($result);

		$content['first_name'] = stripslashes($user_data['first_name']);
		$content['second_name'] = stripslashes($user_data['second_name']);
		$content['sur_name'] = stripslashes($user_data['sur_name']);
		$content['country'] = stripslashes($user_data['country']);
		$content['post_code'] = stripslashes($user_data['post_code']);
		$content['area'] = stripslashes($user_data['area']);
		$content['city'] = stripslashes($user_data['city']);
		$content['address'] = stripslashes($user_data['address']);
	}
	else
		$result = "Недостаточно прав";

	debug ("*** end:users_profile_edit ***");
	return $content;
}

function users_user_del()
{
	debug ("*** users_user_del ***");
	global $user;
	global $config;
	$content = array(
		'result' => '',
		'content' => '',
		'id' => '',
		'name' => ''
	);

	$priv = new Privileges();
	if ($priv -> has("users", "del", "write"))
	{
		debug ("user is admin");
		debug ("authed");
		$result = exec_query("SELECT * FROM ksh_users WHERE id='".db_escape($_GET['user'])."'");
		$usr = mysqli_fetch_array($result);
		mysqli_free_result($result);
		foreach ($usr as $k => $v)
			$usr[$k] = stripslashes($v);

		$content['id'] = $usr['id'];
		$content['name'] = $usr['name'];
		$content['login'] = $usr['login'];
		
	}
	else
	{
		debug ("user isn't admin");
		$content['content'] .= "Пожалуйста, войдите как администратор.";
	}


	debug ("*** end: users_user_del ***");
	return $content;
}

function users_get_name($id)
{
	debug ("*** users_get_name ***");

	$user_name = db_get_field("ksh_users", "name", "id='".db_escape($id)."'");
	debug ("user name: ".$user_name);

	debug ("*** end: users_get_name ***");
	return stripslashes($user_name);
}

function users_get_group($user_id = 0)
{
	global $user;
	global $config;
	debug ("*** users_get_group ***");
	
	if ($user_id)
		$group_id = db_get_field("ksh_users", "group", "`id` = '".db_escape($user_id)."'");
	else
		$group_id = $user['group'];

	debug ("*** end: users_get_group ***");
	return $group_id;
}

function users_get_group_title($id)
{
	global $user;
	global $config;
	debug("*** users_get_group_title ***");

	debug("id: ".$id);

	$title = db_get_field("ksh_users_groups", "title", "`id` = '".db_escape($id)."'");

	debug("*** end: users_get_group_title ***");
	return $title;
}

function users_view_by_group()
{
    debug("*** users_view_by_group ***");
    global $user;
	global $page_title;
    global $config;

    $content = array(
    	'content' => '',
        'result' => '',
        'group' => '',
		'group_id' => '',
        'if_show_admin_link' => '',
		'users' => array()
    );	
	$i = 0;

	if (isset($_POST['group']))
		$group = $_POST['group'];
	else if (isset($_GET['group']))
	    $group = $_GET['group'];
	else if (isset($_GET['element']))
	    $group = $_GET['element'];
	else
		$group = 0;

	$content['group_id'] = $group;
    $content['group'] = users_get_group_title($group);	
	$content['users_list_name'] = "group_".$content['group_id'];

	debug("group: ".$content['group']);

	$priv = new Privileges();

    if ($priv->has("users", "admin", "write"))
    {
        debug ("user has admin rights");
        if (isset($_POST['do_del']))
        {
            debug ("have users to delete");
            exec_query("DELETE FROM ksh_users WHERE id='".db_escape($_POST['id'])."'");
            $content['result'] .= "Пользователь успешно удален";
        }
        else
        {
            debug ("don't have users to delete");
        }

        $content['if_show_admin_link'] = "yes";
    }

	// FIXME: Check if there are groups; else user has a warning
    debug ("group name: ".$content['group']);

	$sql_query = "SELECT * FROM `ksh_users` WHERE `group` = '".db_escape($group)."'";

	if (isset($_POST['filter']))
	{
		foreach($_POST['filter'] as $filter_id => $filter_field)
		{
			debug ("filter field: ".$filter_field);
			if (isset($_POST[$filter_field]) && "" != $_POST[$filter_field] && db_field_exists("ksh_users", $filter_field))
			{
				$if_additional_field = 0;
				foreach($config['users']['additional_fields'] as $af_id => $af)
					if ($filter_field == $af['name'])
						$if_additional_field = 1;


				if ($if_additional_field)
					$sql_query .= " AND `".db_escape($filter_field)."` LIKE '%|".db_escape($_POST[$filter_field])."|%'";
				else
					$sql_query .= " AND `".db_escape($filter_field)."` = '".db_escape($_POST[$filter_field])."'";
				$content[$filter_field] = $_POST[$filter_field];
			}
		}
	}	
	
	$sql_query .= " ORDER BY `id` DESC";

    $result = exec_query($sql_query);

    while ($row = mysqli_fetch_array($result))
    {
        debug("show users ".$row['id']);
		foreach($row as $k => $v)
			$content['users'][$i][$k] = stripslashes($v);
		$content['users'][$i]['group_name'] = $content['group'];
		switch($row['city'])
		{
			default:
				$content['users'][$i]['city'] = '';
			break;
			case "1":
				$content['users'][$i]['city'] = 'Москва';
			break;
			case "2":
				$content['users'][$i]['city'] = 'Санкт-Петербург';
			break;
		}
        $i++;
    }
    mysqli_free_result($result);
	$content[$content['users_list_name']] = $content['users'];

    debug("*** end: users_view_by_group ***");
    return $content;
}

function users_change_group()
{
    debug("*** users_change_group ***");
    global $user;
    global $config;
	
    $content = array(
    	'content' => '',
        'result' => '',
		'name' => '',
		'groups_select' => array()
    );

	$priv = new Privileges();

    if ($priv->has("users", "admin", "write"))
	{
        debug ("user has admin rights");
        if (isset($_POST['do_change']))
        {
            debug ("have users to change");
            exec_query("UPDATE `ksh_users` SET `group` = '".db_escape($_POST['group'])."' WHERE `id` = '".db_escape($_POST['id'])."'");
            $content['result'] .= "Группа изменена";
        }
        else
        {
            debug ("don't have users to delete");
        }

        $content['if_show_admin_link'] = "yes";

		$sql_query = "SELECT * FROM `ksh_users` WHERE id='".db_escape($_GET['user'])."'"; 
		$result = exec_query($sql_query);
		$usr = mysqli_fetch_array($result);
		mysqli_free_result($result);

		$content['id'] = stripslashes($usr['id']);
		$content['name'] = stripslashes($usr['name']);

		$sql_query = "SELECT * FROM `ksh_users_groups`";
		$result = exec_query($sql_query);
		$i = 0;
		while ($row = mysqli_fetch_array($result))
		{
			debug ("show group ".$i);
			$content['groups_select'][$i]['id'] = stripslashes($row['id']);
			$content['groups_select'][$i]['title'] = stripslashes($row['title']);
			if ($usr['group'] == $row['id'])
				$content['groups_select'][$i]['if_selected'] = "selected";
			$i++;
		}
		mysqli_free_result($result);
    }
	else
		$content['content'] .= "Пожалуйста, войдите как администратор";

    debug("*** end: users_change_group ***");
	return $content;
}


function users_profile_view()
{
	global $user;
	global $config;
	debug ("*** users_profile_view ***");

	$content = array(
		'name' => '',
		'modules' => '',
		'show_logout_link' => '',
		'show_change_password_link' => '',
		'show_profile_edit_link' => '',
		'show_admin_link' => '',
		'id' => '',
		'login' => '',
		'name' => '',
		'password' => '',
		'first_name' => '',
		'second_name' => '',
		'sur_name' => '',
		'country' => '',
		'post_code' => '',
		'area' => '',
		'city' => '',
		'address' => '',
		'group' => ''
	);

	if (isset($_GET['element']) && is_numeric($_GET['element']))
		$id = $_GET['element'];
	else
		$id = $user['id'];
	debug("id: ".$id);

	if ($id) // user exists
	{
		$priv = new Privileges();
	
		if ($priv -> has("users", "profile_edit", "write"))
		{
			$content['show_admin_link'] = "yes";
			$content['show_profile_edit_link'] = "yes";
		}

		if ($id == $user['id'])
		{
			$content['show_logout_link'] = "yes";
			$content['show_change_password_link'] = "yes";

			$i = 0;
			$modules = array_merge($config['modules']['core'], $config['modules']['installed']);
			$content['modules'] = array();
			foreach ($modules as $k => $v)
				if ($priv -> has($v, "default", "read") || $priv -> has("base", "default", "write"))
				{
					$content['modules'][$i]['inst_root'] = $config['base']['inst_root'];
					$content['modules'][$i]['name'] = $v;
					$content['modules'][$i]['title'] = modules_get_title($v);
					if ($priv -> has($v, "admin", "write"))
						$content['modules'][$i]['admin'] = "yes";
					$i++;
				}
		}

		$row = db_get_row_by_query("SELECT * FROM `ksh_users` WHERE `id` = '".db_escape($id)."'");
		foreach($row as $k => $v)
			$content[$k] = stripslashes($v);

		if (!isset($content['last_login_date']) || "" == $content['last_login_date'] || "NULL" == $content['last_login_date'] || NULL == $content['last_login_date'])
		{
			if (isset($content['last_login_date']))
				unset($content['last_login_date']);
			if (isset($last_login_time))
				unset($content['last_login_time']);
			$content['last_login_date_never'] = "yes";
		}
		else
			$content['last_login_date'] = format_date($content['last_login_date'], "ru");


		$content['group'] = users_get_group_title(stripslashes($row['group']));

		if (isset($_SESSION['reg_password']))
		{
			$content['reg_password'] = $_SESSION['reg_password'];
			unset($_SESSION['reg_password']);
		}
	}
	else
		$content['user_not_exists'] = "yes";

	debug ("*** end: users_profile_view ***");
	return $content;
}

function users_get_redirect($id)
{
	global $user;
	global $config;
	debug("*** users_get_redirect ***");

	$group_id = users_get_group($id);

	$redirect = db_get_field("ksh_users_groups", "redirect", "`id` = '".$group_id."'");
	debug ("redirect: ".$redirect);
	debug ("referer: ".$_SERVER['HTTP_REFERER']);
	debug ("strpos: ".strpos($_SERVER['HTTP_REFERER'], "auth/login"));
	if ("" == $redirect && NULL == $redirect)
		$redirect = "/users/profile_view/";

	debug("*** end: users_get_redirect ***");
	return $redirect;
}

?>
