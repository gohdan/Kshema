<?php

// Base functions of the users module

include_once ($config['modules']['location']."users/config.php");

$config_file = $config['base']['doc_root']."/config/users.php";
if (file_exists($config_file))
	include($config_file);

include_once($config['modules']['location']."users/db.php");
include_once($config['modules']['location']."users/groups.php");
include_once($config['modules']['location']."users/users.php");
include_once($config['modules']['location']."users/old_functions.php");
include_once($config['modules']['location']."users/user.php");

// XMLRPC functionality class
if ($config['users']['xmlrpc_use'])
{
	include_once($config['base']['doc_root']."/libs/xmlrpc/xmlrpc.inc");
	include_once($config['base']['doc_root']."/libs/xmlrpc/xmlrpc_wrappers.inc");
	include_once($config['base']['doc_root']."/libs/xmlrpc/xmlrpcs.inc");
}


function users_admin()
{
	global $user;
	global $config;
	debug ("*** users_admin ***");
	$content['content'] = "";
	debug ("*** end: users_admin ***");
	return $content;
}

function users_admin_satellite($id)
{
	global $user;
	global $config;
	debug ("*** users_admin_satellite ***");
	$content = array(
		'id' => $id
	);
	debug ("*** end: users_admin_satellite ***");
	return $content;
}


function users_help()
{
	global $user;
	global $config;
	debug ("*** users_help ***");
	$content['content'] = "";
	debug ("*** end: users_help ***");
	return $content;
}

function users_frontpage()
{
	global $user;
	global $config;
	debug ("*** users_frontpage ***");

	$content = array(
		'show_admin_link' => '',
		'show_profile_link' => '',
		'login_form' => '',
		'show_heading' => ''
	);
	$priv = new Privileges();

	if ($priv -> has("users", "admin", "write"))
		$content['show_admin_link'] = "yes";

	if ($user['id'])
	{
		$content['show_profile_link'] = "yes";
		$content['show_heading'] = "yes";
	}
	else
		$content['login_form'] = gen_content("auth", "show_login_form", auth_show_login_form());



	debug ("*** end: users_frontpage ***");
	return $content;
}


function users_default_action()
{
        global $user;
		global $config;
        debug ("<br>=== mod: users ===");

		if (isset($config['base']['inst_root']))
			$module_data['inst_root'] = $config['base']['inst_root'];
		else
			$module_data['inst_root'] = "";

        $content = "";
        $nav_string = "<p>
                <a href=\"/index.php?module=users&action=view_users\">Список пользователей</a>
                <a href=\"/index.php?module=users&action=add_user\">Добавить пользователя</a>
                <a href=\"/index.php?module=users&action=create_users_table\">Создать таблицу пользователей</a>
                <a href=\"/index.php?module=users&action=view_roles\">Список ролей</a>
                <a href=\"/index.php?module=users&action=create_roles\">Создать роли</a>
                <a href=\"/index.php?module=users&action=delete_roles\">Удалить все роли</a>
        </p>";

        //$content .= $nav_string;

        if (isset($_GET['action']))
        {
			$_GET['action'] = rtrim($_GET['action'], "/");
                debug ("action: ".$_GET['action']);

			if (in_array($_GET['action'], $config['users']['admin_actions']))
				$config['themes']['admin'] = "yes";

			if (isset($_GET['element']))
				$_GET['element'] = rtrim($_GET['element'], "/");

                switch ($_GET['action'])
                {
						default:
                                $content .= gen_content("users", "frontpage", users_frontpage());
                        break;

						case "install_tables":
                                $content .= gen_content("users", "install_tables", users_install_tables());
                        break;

                        case "drop_tables":
                                $content .= gen_content("users", "drop_tables", users_drop_tables());
                        break;

                        case "update_tables":
                                $content .= gen_content("users", "update_tables", users_update_tables());
                        break;

                        case "admin":
                                $content .= gen_content("users", "admin", users_admin());
                        break;

						case "admin_satellite":
							if (isset($_GET['element']))
								$sat_id = $_GET['element'];
							else
								$sat_id = 0;
							$content .= gen_content("users", "admin_satellite", users_admin_satellite($sat_id));
						break;

                        case "help":
                                $content .= gen_content("users", "help", users_help());
                        break;

						case "groups_view":
							$content .= gen_content("users", "groups_view", users_groups_view());
						break;

						case "group_edit":
							$content .= gen_content("users", "group_edit", users_group_edit());
						break;

						case "groups_add":
							$content .= gen_content("users", "groups_add", users_groups_add());
						break;

						case "group_del":
							$content .= gen_content("users", "group_del", users_group_del());
						break;

                        case "view_users":
							//$content .= view_users($user);
							$content .= gen_content("users", "view_users", users_view_users());
						break;

                        case "view_by_group":
							$content .= gen_content("users", "view_by_group", users_view_by_group());
						break;

						case "change_group":
							if (isset($_GET['element']))
								$_GET['user'] = $_GET['element'];
							$content .= gen_content("users", "change_group", users_change_group());
						break;

						case "add":
							$cnt = array(
								'action' => "add"
							);
							$content .= gen_content("users", "add", array_merge($cnt, users_add()));
						break;

						case "add_satellite":
							if (isset($_POST['satellite_id']))
								$sat_id = $_POST['satellite_id'];
							else if (isset($_GET['satellite']))
								$sat_id = $_GET['satellite'];
							else
								$sat_id = 0;
							$cnt = array(
								'action' => "add_satellite"
							);
							$usr = new User;
							$usr -> satellite_id = $sat_id;
							$content .= gen_content("users", "add_satellite", array_merge($cnt, $usr -> add()));
						break;

						case "user_del":
							if (isset($_GET['element']))
								$_GET['user'] = $_GET['element'];
							$content .= gen_content("users", "user_del", users_user_del());
						break;

                        case "view_roles": $content .= view_roles($user); break;
                        case "create_roles": $content .= create_roles($user); break;
                        case "delete_roles": $content .= delete_roles($user); break;
                        case "create_users_table": $content .= create_users_table($user); break;
                        case "profile_edit":
                            $content = gen_content("users", "profile_edit", users_profile_edit());
                        break;

						case "profile_view":
							$content = gen_content("users", "profile_view", array_merge($module_data, users_profile_view()));
						break;
                }
        }
        else
        {
            debug ("action: default");
			$content .= gen_content("users", "frontpage", users_frontpage());
        }

/*
		// Updating data on the billboards
		if(in_array("bbcpanel", $config['modules']['installed']) && 
			(
				isset($_POST['do_add']) ||
				isset($_POST['do_update']) ||
				isset($_POST['do_del'])
			)
		  )
		{
			include_once($config['modules']['location']."bbcpanel/index.php");
			$bb = new BB();
			$bb -> users_update_all();
		}
*/
        debug ("<br>=== end: mod: users ===");

        return $content;
}

?>
