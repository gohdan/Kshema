<?php

// Base functions of the "updater" module


include_once ("db.php");
// include_once ("xmlrpcserver.php");


function updater_admin()
{
	debug ("*** updater_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
    	'heading' => '',
		'show_admin_link' => ''
    );
    $content['heading'] = "Обновление";

	$priv = new Privileges();
	if ($priv -> has("updater", "admin", "write"))
		$content['show_admin_link'] = "yes";
	if ($priv -> has("updater", "all", "write"))
		$content['show_all_link'] = "yes";
	if ($priv -> has("updater", "theme", "write"))
		$content['show_theme_link'] = "yes";
	if ($priv -> has("updater", "create_tables", "write"))
		$content['show_create_tables_link'] = "yes";
	if ($priv -> has("updater", "drop_tables", "write"))
		$content['show_drop_tables_link'] = "yes";
	if ($priv -> has("updater", "update_tables", "write"))
		$content['show_update_tables_link'] = "yes";


	debug ("*** end: updater_admin ***");
    return $content;
}

function updater_check_rights($files)
{
	global $config;
	global $user;
	debug("*** updater_check_rights ***");

	$conn_id = ftp_connect($config['base']['ftp_server']);
	$login_result = ftp_login($conn_id, $config['base']['ftp_username'], $config['base']['ftp_password']);
	debug("login result: ".$login_result);

	$mode_dirs = octdec(str_pad($config['updater']['rights_dirs'],4,'0',STR_PAD_LEFT)); 
	$mode_files = octdec(str_pad($config['updater']['rights_files'],4,'0',STR_PAD_LEFT)); 

	foreach ($files as $k => $v)
	{
		$filename = $config['base']['ftp_root'].$v;
		
		if ("/" == substr($filename, -1))
		{
			$hr_mode = $config['updater']['rights_dirs'];
			$mode = $mode_dirs;
		}
		else
		{
			$hr_mode = $config['updater']['rights_files'];
			$mode = $mode_files;
		}

		debug("setting rights ".$hr_mode." on ".$filename);
		ftp_chmod($conn_id, $mode, $filename);
	}

	ftp_close($conn_id);

	debug("*** end: updater_check_rights ***");
	return 1;
}

function updater_get_update($url, $file, $path)
{
	global $config;
	global $user;
	debug ("*** updater_get_update ***");
	$result = "";
	$filenames = array();

	debug("url: ".$url);
	debug("file: ".$file);
	debug("path: ".$path);

	$f = file_get_contents($url);
	file_put_contents($file, $f); 

	$zip = new ZipArchive;
	if ($zip->open($file) === TRUE)
	{
		debug("zip archive contents: ", 2);
		for($i = 0; $i < $zip->numFiles; $i++)
		{
			$filenames[$i] = $zip->getNameIndex($i);
			debug($filenames[$i], 2);
		}

		updater_check_rights($filenames);

	    $zip->extractTo($path);
	    $zip->close();
	    $result = "Update was successful";
	} else
	    $result = "Update was unsuccessful";

	debug ("*** end: updater_get_update ***");
	return $result;
}

function updater_theme($theme)
{
	global $config;
    global $user;
	debug ("*** updater_theme ***");
	$content = array(
    	'result' => '',
    	'heading' => '',
		'show_admin_link' => '',
		'theme' => $theme,
		'url' => '',
		'doc_root' => '',
		'dl_path' => '',
		'show_update_form' => ''
    );

	$priv = new Privileges();
	if ($priv -> has("updater", "admin", "write"))
		$content['show_admin_link'] = "yes";
	if ($priv -> has("updater", "theme", "write"))
	{
		if (isset($_POST['do_update']))
		{
			$filename = $theme.".zip";
			$content['filename'] = $filename;

			$url = $config['updater']['url']."themes/".$filename;
			$content['url'] = $url;

			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$dl_path = $config['updater']['dl_path'];

			$content['doc_root'] = $doc_root;
			$content['dl_path'] = $dl_path;

			$content['result'] = updater_get_update($url, $dl_path.$filename, $config['themes']['dir']);
		}
		else
			$content['show_update_form'] = "yes";
	}
	else
		$content['result'] .= "Нет прав на обновление темы оформления";


    $content['heading'] = "Обновление темы оформления";
	debug ("*** end: updater_theme ***");
    return $content;
}

function updater_all()
{
	global $config;
    global $user;
	debug ("*** updater_all ***");
	$content = array(
    	'result' => '',
    	'heading' => '',
		'show_admin_link' => '',
		'url' => '',
		'doc_root' => '',
		'dl_path' => '',
		'show_update_form' => ''
    );

	$priv = new Privileges();
	if ($priv -> has("updater", "admin", "write"))
		$content['show_admin_link'] = "yes";
	if ($priv -> has("updater", "all", "write"))
	{
		if (isset($_POST['do_update']))
		{
			$filename = $config['updater']['file_all'];
			$content['filename'] = $filename;

			$url = $config['updater']['url'].$filename;
			$content['url'] = $url;

			$doc_root = $_SERVER['DOCUMENT_ROOT'];
			$dl_path = $config['updater']['dl_path'];

			$content['doc_root'] = $doc_root;
			$content['dl_path'] = $dl_path;

			$content['result'] = updater_get_update($url, $dl_path.$filename, $doc_root);
		}
		else
			$content['show_update_form'] = "yes";
	}
	else
		$content['result'] .= "Нет прав на обновление";


    $content['heading'] = "Обновление всего кода";
	debug ("*** end: updater_all ***");
    return $content;
}

function updater_default_action()
{
        global $user;
        global $config;

        $content = "";

		$descr_file_path = $config['modules']['location']."updater/description.ini";
		debug ("descr_file_path: ".$descr_file_path);
		$module_data = parse_ini_file($descr_file_path);
		$module_data['module_name'] = $module_data['name']; // added to compatibility with base categories
		$module_data['module_title'] = $module_data['title']; // added to compatibility with base categories
		dump($module_data);

		if (isset($config['updater']))
			array_merge($module_data, $config['updater']);
		else
			$config['updater'] = $module_data;
		dump($config['updater']);

		$config['themes']['page_title'] .= " - ".$module_data['title'];
		$config['modules']['current_module'] = "updater";

        debug("<br>=== mod: updater ===");

        if (isset($_GET['action']))
        {
			$_GET['action'] = rtrim($_GET['action'], "/");
			
			debug ("*** action: ".$_GET['action']);
			switch ($_GET['action'])
			{
				default:
					$content .= gen_content("updater", "admin", updater_admin());
				break;

				case "admin":
					$content .= gen_content("updater", "admin", updater_admin());
				break;

				case "create_tables":
					$content .= gen_content("updater", "tables_create", updater_tables_create());
				break;

				case "drop_tables":
					$content .= gen_content("updater", "drop_tables", updater_tables_drop());
				break;

				case "update_tables":
					$content .= gen_content("updater", "tables_update", updater_tables_update());
				break;

				case "theme":
					if (isset($_GET['theme']))
						$theme = $_GET['theme'];
					else if (isset($_POST['theme']))
						$theme = $_POST['theme'];
					else
						$theme = $config['themes']['current'];
					$content .= gen_content("updater", "theme", updater_theme($theme));
				break;

				case "all":
					$content .= gen_content("updater", "all", updater_all());
				break;
			}
        }
        else
        {
			debug ("*** action: default");
			$content .= gen_content("updater", "admin", updater_admin());
        }

		debug("=== end: mod: updater ===<br>");
        return $content;

}

?>
