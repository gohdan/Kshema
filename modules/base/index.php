<?php

// Base functions of "base" module

include_once($config['modules']['location']."/base/functions.php");
debug ("! base module included");
include_once("category.php");
include_once("dataobject.php");
include_once("privileges.php");
include_once("access.php");
include_once("file.php");
include_once("templater.php");
include_once($config['modules']['location']."/base/config.php");
include_once($config['modules']['location']."/base/log.php");

if ("yes" == $config['satellite']['use'])
	include_once("satellite.php");

function base_admin()
{
        $content['content'] = "";
        return $content;
}

function base_frontpage()
{
        global $user;
        global $debug;
        $content['content'] = "";

        debug ("*** base_frontpage ***");
        debug ("*** end: base_frontpage");

        return $content;
}

function base_help()
{
	debug ("*** base_help ***");
	global $user;
	global $config;

	$content = "";

	debug ("*** end: base_help ***");
	return $content;
}

function base_developer_guide()
{
	debug ("*** base_developer_guide ***");
	global $user;
	global $config;

	$content = "";

	debug ("*** end: base_developer_guide ***");
	return $content;
}


function base_install()
{
	global $user;
	global $config;
	debug ("*** base_install");
	include_once ($config['modules']['location']."/users/index.php");
	$content = users_install_tables();

	$priv = new Privileges();
	$priv -> create_table("ksh_base_privileges");

	debug("content: ");
	dump($content);
	debug ("*** end: base_install");
	return $content;
}


function base_update()
{
	global $user;
	global $config;
	debug ("*** base_update ***");

	$tables = array();
	$sql_query = "SHOW TABLES";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$tables[] = stripslashes($row['Tables_in_'.$db_name]);
	mysql_free_result($result);

	debug("tables:", 2);
	dump($tables);

	if (!in_array("ksh_base_privileges", $tables))
	{
		$priv = new Privileges();
		$priv -> create_table("ksh_base_privileges");
	}

	debug ("*** end: base_update ***");
	return $content;
}

function base_default_action()
{
        global $user;
		global $config;
        $content = "";
        $nav_string = "
        ";

        $content .= $nav_string;

        debug("<br>=== mod: base ===");

		$priv = new Privileges;

		if (isset($config['base']['inst_root']))
			$module_data['inst_root'] = $config['base']['inst_root'];
		else
			$module_data['inst_root'] = "";

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("base" ,"frontpage", base_frontpage());
                        break;

                        case "admin":
							if ($priv -> has("base", "admin", "write"))
                                $content .= gen_content("base", "admin", base_admin());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "install":
								$content .= gen_content("base", "install", array_merge($module_data, base_install()));
						break;

						case "update":
								$content .= gen_content("base", "update", base_update());
						break;

						case "help":
							$content .= gen_content("base", "help", base_help());
						break;

						case "developer_guide":
							$content .= gen_content("base", "developer_guide", base_developer_guide());
						break;

						case "privileges_admin":
							$priv = new Privileges();
							$content .= gen_content("base", "privileges_admin", $priv -> admin());
						break;

						case "log_event_hide":
							$log = new Log();
							$log -> hide($_GET['mod'], $_GET['id']);
						break;
                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("base_frontpage", base_frontpage());
        }

        debug("=== end: mod: base ===<br>");
        return $content;

}


?>
