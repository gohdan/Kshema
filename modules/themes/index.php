<?php

// Base functions of the "themes" module


include_once ("db.php");
include_once ("xmlrpcserver.php");


function themes_admin()
{
	debug ("*** themes_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
    	'heading' => '',
		'show_admin_link' => ''
    );
    $content['heading'] = "Темы оформления";

	$priv = new Privileges();
	if ($priv -> has("themes", "admin", "write"))
		$content['show_admin_link'] = "yes";
	if ($priv -> has("themes", "create_tables", "write"))
		$content['show_create_tables_link'] = "yes";
	if ($priv -> has("themes", "drop_tables", "write"))
		$content['show_drop_tables_link'] = "yes";
	if ($priv -> has("themes", "update_tables", "write"))
		$content['show_update_tables_link'] = "yes";


	debug ("*** end: themes_admin ***");
    return $content;
}

function themes_default_action()
{
        global $user;
        global $config;

        $content = "";

		$descr_file_path = $config['modules']['location']."themes/description.ini";
		debug ("descr_file_path: ".$descr_file_path);
		$module_data = parse_ini_file($descr_file_path);
		$module_data['module_name'] = $module_data['name']; // added to compatibility with base categories
		$module_data['module_title'] = $module_data['title']; // added to compatibility with base categories
		dump($module_data);

		if (isset($config['themes']))
			array_merge($module_data, $config['themes']);
		else
			$config['themes'] = $module_data;
		dump($config['themes']);

		$config['themes']['page_title'] .= " - ".$module_data['title'];
		$config['modules']['current_module'] = "themes";

        debug("<br>=== mod: themes ===");

        if (isset($_GET['action']))
        {
			$_GET['action'] = rtrim($_GET['action'], "/");
			
			debug ("*** action: ".$_GET['action']);
			switch ($_GET['action'])
			{
				default:
					$content .= gen_content("themes", "admin", themes_admin());
				break;

				case "admin":
					$content .= gen_content("themes", "admin", themes_admin());
				break;

				case "create_tables":
					$content .= gen_content("themes", "tables_create", themes_tables_create());
				break;

				case "drop_tables":
					$content .= gen_content("themes", "drop_tables", themes_tables_drop());
				break;

				case "update_tables":
					$content .= gen_content("themes", "tables_update", themes_tables_update());
				break;
			}
        }
        else
        {
			debug ("*** action: default");
			$content .= gen_content("themes", "admin", themes_admin());
        }

		debug("=== end: mod: themes ===<br>");
        return $content;

}

?>
