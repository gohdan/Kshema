<?php

// Base functions of "modules" module

debug ("modules module included", 2);

include_once ($config['modules']['location']."modules/config.php");

$config_file = $config['base']['doc_root']."/config/modules.php";
if (file_exists($config_file))
	include($config_file);


function module_exists($module)
{
	global $user;
	global $config;
	debug("*** module_exists ***", 2);
	$modules = array();
	$result = 0;

	debug("module: ".$module, 2);

	$dirlist = scandir($config['modules']['location']);
	foreach($dirlist as $k => $v)
		if (modules_is_module($v))
			$modules[] = $v;

	debug("modules list:", 2);
	dump($modules);

    if (in_array($module, $modules))
		$result = 1;
    else
		$result = 0;
	debug ("result: ".$result, 2);
	if ($result)
		debug("module exists");

	debug("*** end: module_exists ***", 2);
	return $result;
}

function modules_is_module($name)
{
	global $user;
	global $config;
	debug ("*** modules_is_module ***", 2);

	$result = 0;
	debug("name: ".$name, 2);
	$module_dir = $config['modules']['location'].$name;
	debug("dir: ".$module_dir, 2);

	if ("." != $name && ".." != $name && is_dir($module_dir))
		$result = 1;

	debug ("result: ".$result, 2);
	if ($result)
		debug("is module", 2);
	debug ("*** end: modules_is_module ***", 2);
	return $result;
}

function modules_get_title($module_name)
{
	global $user;
	global $config;
	debug ("*** modules_get_title ***");

	if (module_exists($module_name))
	{
		debug ("module exists");
		$file_path = $config['modules']['location'].$module_name."/description.ini";
		debug ("descr file path: ".$file_path);
		$mod_info = parse_ini_file($file_path);
		foreach ($mod_info as $idx => $nme) debug ($idx.":".$nme);
		if (isset($mod_info['title']))
			$title = $mod_info['title'];
		else
			$title = $module_name;
	}
	else
	{
		debug ("module doesn't exist");
		$title = $module_name;
	}

	debug ("*** end: modules_get_title ***");
	return $title;
}

function modules_get_version($module_name)
{
	global $user;
	global $config;
	debug ("*** modules_get_version ***");

	$version = 0;

	if (module_exists($module_name))
	{
		debug ("module exists");
		$file_path = $config['modules']['location'].$module_name."/description.ini";
		debug ("descr file path: ".$file_path);
		$mod_info = parse_ini_file($file_path);
		foreach ($mod_info as $idx => $nme) debug ($idx.":".$nme);
		if (isset($mod_info['version']))
			$version = $mod_info['version'];
	}
	else
		debug ("module doesn't exist");

	debug ("*** end: modules_get_version ***");
	return $version;
}

function modules_admin()
{
	debug ("*** modules_admin ***");
	global $config;
	global $debug;
	$content = array(
		'content' => '',
		'core_modules' => '',
		'installed_modules' => ''
	);

	foreach ($config['modules']['core'] as $k => $v)
	{
		debug ("executing module ".$k.": ".$v);
		$content['core_modules'][$k]['name'] = $v;
		$content['core_modules'][$k]['title'] = modules_get_title($v);
	}

	foreach ($config['modules']['installed'] as $k => $v)
	{
		debug ("executing module ".$k.": ".$v);
		$content['installed_modules'][$k]['name'] = $v;
		$content['installed_modules'][$k]['title'] = modules_get_title($v);
	}


	debug ("*** end: modules_admin ***");
	return $content;
}

function modules_frontpage()
{
    debug ("*** modules_frontpage ***");
	global $config;
    global $user;
	$content = array(
		'content' => ''
	);
    debug ("*** end: modules_frontpage");
    return $content;
}


function modules_default_action()
{
	global $config;
        global $user;
        $content = "";
        $nav_string = "";

        $content .= $nav_string;

        debug("=== mod: modules ===");

		$priv = new Privileges();

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                $content .= gen_content("modules", "frontpage", modules_frontpage());
                        break;

                        case "admin":
							if ($priv -> has("base", "admin", "write"))
                                $content .= gen_content("modules", "admin", modules_admin());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;
                }
        }

        else
        {
                debug ("*** action: default");
                $content = gen_content("modules", "frontpage", modules_frontpage());
        }

        debug("=== end: mod: modules ===");
        return $content;

}


?>
