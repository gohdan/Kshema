<?php
/*  Изыдите, демоны тупости!  */

session_start();

foreach (glob("config/*.php") as $config_file)
	include ($config_file);

ini_set('error_reporting', $config['base']['error_reporting']);
error_reporting($config['base']['error_reporting']);
if ($config['base']['error_reporting'])
	ini_set('display_errors', 1);
else
	ini_set('display_errors', 0);

if (isset($config['performance']['use']) && ("yes" == $config['performance']['use']))
{
	include_once ($mods_dir."/performance/index.php");
    startTimer();
}

foreach($config['modules']['core'] as $module)
	include_once($config['modules']['location'].$module."/index.php");

connect_2db ($config['db']['db_user'], $config['db']['db_password'], $config['db']['db_host'], $config['db']['db_name']);
base_process_request();

date_default_timezone_set($config['base']['timezone']);

debug ("authenticating...");
if (ini_get('register_globals'))
{
	debug ("globals on");
	unset($user);
}
if (auth_enticate())
{
	debug("successful");
	debug ("user id: ".$user['id']);
	debug ("user role: ".$user['role']);
}
else
	debug("unsuccessful!");

if (isset($config['counter']['use']) && ("yes" == $config['counter']['use']))
{
	include_once ($mods_dir."/counter/index.php");
	counter_add();
}

if (isset($_GET['module']) && ("" != $_GET['module']))
{
	debug ("have module name in GET: ".$_GET['module']);
	if (module_exists($_GET['module']))
	{
		$config['modules']['current_module'] = $_GET['module'];
		debug ("current module: ".$config['modules']['current_module']);
		include_once ($mods_dir."/".$_GET['module']."/index.php");
		$mod_action = $_GET['module']."_default_action";
		debug ("calling: ".$mod_action);
		$content = $mod_action();
	}
	else
		$content = "<p>Извините, такого модуля нет.</p>";
}
else
{
	debug ("don't have module name in GET");
	if (module_exists($config['modules']['default_module']))
	{
		$config['modules']['current_module'] = $config['modules']['default_module'];
		include_once ($mods_dir."/".$config['modules']['default_module']."/index.php");
		$mod_action = $config['modules']['default_module']."_default_action";
		debug ("calling: ".$mod_action);
		$content = $mod_action();
	}
	else
		$content = "<p>Извините, назначенного по умолчанию модуля <b>".$config['modules']['default_module']."</b> не существует.</p>";
}

output ($content);

if (isset($config['performance']['use']) && ("yes" == $config['performance']['use']))
	debug ("page created approximately in [".endTimer()."] seconds");

?>

