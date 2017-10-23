<?php

// Base functions of the auth module

include_once ($config['modules']['location']."auth/config.php");

$config_file = $config['base']['doc_root']."/config/auth.php";
if (file_exists($config_file))
	include($config_file);

include_once ($config['modules']['location']."auth/db.php");
include_once ($config['modules']['location']."auth/functions.php");
include_once ($config['modules']['location']."auth/old_func.php");

include_once ($config['modules']['location']."files/index.php"); // to upload pictures

debug ("auth module included", 2);

function auth_admin()
{
        $content['content'] = "";
        return $content;
}

function auth_show_login_form()
{
	global $user;
	global $config;
    $content = array(
		'content' => '',
		'if_show_register_link' => '',
		'inst_root' => $config['base']['inst_root']
	);

	if ("yes" == $config['auth']['allow_registration'])
		$content['if_show_register_link'] = "yes";

    return $content;
}

function auth_show_register_form()
{
	global $user;
	global $config;
    $content = array(
		'content' => '',
		'if_show_register_link' => '',
		'if_deny' => ''
	);

	if ("yes" == $config['auth']['allow_registration'])
		$content['if_show_register_form'] = "yes";
	else
		$content['if_deny'] = "yes";

    return $content;
}


function auth_default_action()
{
    global $user;
	global $config;

    debug("=== mod: auth; fn: mod_action ===");

	if (isset($config['base']['inst_root']))
		$module_data['inst_root'] = $config['base']['inst_root'];
	else
		$module_data['inst_root'] = "";

    $content = "";
    if (isset($_GET['action']))
    {
		debug ("action: ".$_GET['action']);

		if (in_array($_GET['action'], $config['auth']['admin_actions']))
			$config['themes']['admin'] = "yes";

        switch ($_GET['action'])
        {
            default:
				$content = gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case ("admin"):
				$content = gen_content("auth", "admin", auth_admin());
			break;

            case("logout"):
                //$content .= logout();
                $content = gen_content("auth", "logout", auth_logout());
            break;

			case("change_password"):
				$content = gen_content("auth", "change_password", array_merge($module_data, auth_change_password()));
			break;

            case("psw_change"):
                $content = "<p>Пароль успешно изменён</p>";
            break;

            case("show_login_form"):
                $content = gen_content("auth", "show_login_form", array_merge($module_data, auth_show_login_form()));
            break;

            case("login"):
                $content = gen_content("auth", "login", auth_login());
            break;

            case("show_register_form"):
                $content = gen_content("auth", "show_register_form", auth_show_register_form());
            break;

            case("register"):
                $content = gen_content("auth", "register", auth_register());
            break;

            case("install_tables"):
                $content = gen_content("auth", "install_tables", auth_install_tables());
            break;
        }
    }

    else
    {
        debug ("default action");
        if (auth_enticate())
            $content = gen_content("auth", "show_login_form", auth_show_login_form());
        else
			$content = gen_content("auth", "show_login_form", auth_show_login_form());
    }
    debug("=== end: mod: auth; fn: mod_action ===");
    return $content;
}

?>
