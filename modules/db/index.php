<?php

// Base functions of the "db" module
debug ("db module included", 2);

include_once ($config['modules']['location']."db/config.php");

$config_file = $config['base']['doc_root']."/config/db.php";
if (file_exists($config_file))
	include($config_file);

include_once ($config['modules']['location']."db/functions.php");

function db_admin()
{
		$content = array(
			'content' => ''
		);
        return $content;
}

function db_default_action()
{
	global $user;
	$content = "";

	debug ("<br>=== mod: db ===");


	if (isset($_GET['action']))
	{
		debug ("have an action");
		switch ($_GET['action'])
		{
			default: break;
			
			case "admin":
				$content .= gen_content("db", "admin", db_admin());
			break;
			
			case "replace":
				$content .= gen_content("db", "replace", db_replace());
			break;
			
			case "create_db": $content .= create_db(); break;
		}
	}
	else
	{
		debug ("don't have any actions, exec default");
	}
	debug ("=== end: mod: db ===<br>");
	return $content;

}

?>
