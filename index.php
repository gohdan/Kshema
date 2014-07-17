<?php
/*  Изыдите, демоны тупости!  */

session_start();

include_once("config.php");

ini_set('error_reporting', $config['base']['error_reporting']);
error_reporting($config['base']['error_reporting']);
if ($config['base']['error_reporting'])
	ini_set('display_errors', 1);
else
	ini_set('display_errors', 0);

if ("yes" == $config['performance']['use'])
{
	include_once ($mods_dir."/performance/index.php");
    startTimer();
}

include_once ($mods_dir."/base/index.php");
include_once ($mods_dir."/users/index.php");
include_once ($mods_dir."/auth/index.php");
include_once ($mods_dir."/templater/index.php");
include_once ($mods_dir."/modules/index.php");
include_once ($mods_dir."/db/index.php");

connect_2db ($db_user, $db_password, $db_host, $db_name);
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
else debug("unsuccessful!");


if ("yes" == $config['counter']['use'])
{
	include_once ($mods_dir."/counter/index.php");
	counter_add();
}

        if (isset($_GET['module']) && "" != $_GET['module'])
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

if ("yes" == $config['performance']['use']) debug ("page created approximately in [".endTimer()."] seconds");
?>

