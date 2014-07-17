<?php

// Base functions of the "files" modules

include_once ("db.php");
include_once ("files.php");
include_once ("upload.php");


function files_admin()
{
	global $config;
	global $user;
	$content['content'] = "";
	return $content;
}


function files_frontpage()
{
	global $config;
	global $user;
	$content = array(
		'content' => '',
		'if_show_admin_link' => ''
	);

	$priv = new Privileges;
	if ($priv -> has("files", "admin", "write"))
		$content['if_show_admin_link'] = "yes";

	return $content;
}

function files_default_action()
{
	global $config;
	global $user;
	$content = "";

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;
	
	debug("<br>=== mod: files ===");

	if(isset($_GET['element']) && !isset($_GET['page']))
		$_GET['page'] = rtrim($_GET['element'], "/");

	$module_data = array (
		'module' => "files",
		'module_name' => "files",
		'module_title' => "Файлы"
	);
	$config['files']['page_title'] = $module_data['module_title'];
	$config['themes']['page_title']['module'] = "Файлы";

	$config['modules']['current_module'] = "files";

	$priv = new Privileges();

	if (isset($_GET['action']))
	{
		debug ("*** action: ".$_GET['action']);

		if (isset($_POST['do_del_category']) && $priv -> has("files", "admin", "write"))
		{
			debug ("deleting category");
			$cat = new Category();

			$cat_name = $cat -> get_name("ksh_files_categories", $_POST['category']);
			$parent = $cat -> get_parent("ksh_files_categories", $_POST['category']);

			$fl = new File();
			$path = $fl -> path_determine ($config['files']['files_dir'], "ksh_files_categories", $parent);
			$fl -> dir_del($cat_name, $path);

			$result = $cat -> del("ksh_files_categories", "ksh_files", $_POST['category']);
		}

		if (isset($_POST['do_del']) && $priv -> has("files", "admin", "write"))
		{
			debug("deleting file");
			$dob = new DataObject();
			$dob -> table = "ksh_files";
			$dob -> categories_table = "ksh_files_categories";

			$file_2del = $dob -> get($_GET['element']);

			debug("category: ".$file_2del['category']);

			$fl = new File();
			$fl -> del($file_2del['file'], $config['base']['doc_root']);

		}

		switch ($_GET['action'])
		{
			default:
				$config['themes']['page_title']['action'] = "Категории";
				$config['files']['page_title'] .= " - Категории";
				$cat = new Category();
				$cnt = $cat -> view("ksh_files_categories");
				$content .= gen_content("files", "categories_view", array_merge($module_data, $cnt));
			break;

            case "admin":
				if ($priv -> has("files", "admin", "write"))
		            $content .= gen_content("files", "admin", files_admin());
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());				
            break;

			case "install_tables":
				if ($priv -> has("files", "admin", "write"))
					$content .= gen_content("files", "install_tables", files_install_tables());
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());				
			break;

			case "drop_tables":
				if ($priv -> has("files", "admin", "write"))
					$content .= gen_content("files", "drop_tables", files_drop_tables());
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());				
			break;

			case "update_tables":
				if ($priv -> has("files", "admin", "write"))
					$content .= gen_content("files", "update_tables", files_update_tables());
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());				
			break;						
						
			case "config_edit":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$cnf = new Config;
					$cnf -> table = "ksh_files_config";
					$cnt = $cnf -> edit();
					$content .= gen_content("files", "config_edit", array_merge($module_data, $cnt));
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "categories_view":
				$config['themes']['page_title']['action'] = "Категории";
				$config['files']['page_title'] .= " - Категории";
				$cat = new Category();
				$cnt = $cat -> view("ksh_files_categories");
				$content .= gen_content("files", "categories_view", array_merge($module_data, $cnt));
			break;

			case "categories_add":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$config['themes']['page_title']['action'] = "Добавление категории";
					$config['files']['page_title'] .= " - Добавление категории";
					$cat = new Category();
					$cnt = $cat -> add("ksh_files_categories");

					$fl = new File();
					$path = $fl -> path_determine ($config['files']['files_dir'], "ksh_files_categories", $_POST['parent']);
					$fl -> dir_create($_POST['name'], $path);

					$content .= gen_content("files", "categories_add", array_merge($module_data, $cnt));
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "categories_del":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$config['themes']['page_title']['action'] = "Удаление категории";
					$config['files']['page_title'] .= " - Удаление категории";
					$cat = new Category();
					$cnt = $cat -> del("ksh_files_categories", "ksh_files", $_GET['category']);
					$content .= gen_content("files", "categories_del", array_merge($module_data, $cnt));
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "categories_edit":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$config['themes']['page_title']['action'] = "Редактирование категории";
					$config['files']['page_title'] .= " - Редактирование категории";
					$cat = new Category();

					$old_name = $cat -> get_name("ksh_files_categories", $_GET['category']);

					$cnt = $cat -> edit("ksh_files_categories", $_GET['category']);

					$parent = $cat -> get_parent("ksh_files_categories", $_GET['category']);

					$fl = new File();
					$path = $fl -> path_determine ($config['files']['files_dir'], "ksh_files_categories", $parent);
					$fl -> dir_edit($old_name, $_POST['name'], $path);

					$content .= gen_content("files", "categories_edit", array_merge($module_data, $cnt));
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "view_by_category":
					if(isset($_GET['category']))
						$category = $_GET['category'];
					else if (isset($_GET['element']))
						$category = $_GET['element'];
					else
						$category = 0;

					$config['modules']['current_category'] = $category;
	
					if ("" == $module_data['module'])
						$module_data['inst_root'] = rtrim($module_data['inst_root'], "/");

					$dbo = new DataObject;
					$dbo -> categories_table = "ksh_files_categories";
					$dbo -> elements_table = "ksh_files";
					$dbo -> elements_on_page = $config['files']['elements_on_page'];
					$cnt = $dbo -> view_by_category($category);

					$fl = new File();

					foreach($cnt['elements'] as $k => $v)
					{
						$cnt['elements'][$k]['size'] = $fl -> get_size($v['file'], 1);
						$cnt['elements'][$k]['thumb'] = $fl -> get_thumbnail($v['file']); 
					}

					if ($priv -> has("files", "add", "write"))
						$cnt['show_add_link'] = "yes";

					$cat = new Category();
					$categories = $cat -> view("ksh_files_categories");
					if ($priv -> has("files", "admin", "write"))
						$categories['show_admin_link'] = "yes";
					$categories['module_name'] = $module_data['module_name'];
					$categories['module_title'] = $module_data['module_title'];
					$cnt['categories_list'] = gen_content("files", "categories_view", $categories);
							
                    $content .= gen_content("files", "view_by_category", array_merge($module_data, $cnt));
			break;

			case "add":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$config['themes']['page_title']['action'] = "Добавление файла";

					if (isset($_FILES['file']))
					{
						$fl = new File;

						$file = $_FILES['file'];
					    $if_file_exists = 0;
					    $file_path = "";
	                    debug ("there is a file to upload");

						$path = $fl -> path_determine ("", "ksh_files_categories", $_POST['category']);
						debug("determined path: ".$path);

	                    if (file_exists($config['files']['files_dir'].$path.$file['name'])) $if_file_exists = 1;

	                    $file_path = $fl -> stow($file['name'],$file['tmp_name'],$config['files']['files_dir'],$path,$if_file_exists);
	                    debug ("size: ".filesize($config['files']['files_dir'].$file_path));

	                    if (filesize($config['files']['files_dir'].$file_path) > $max_file_size)
	                    {
	                        debug ("file size > max file size!");
	                        $content .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
	                        if (unlink ($config['files']['files_dir'].$file_path)) debug ("file deleted");
	                        else debug ("can't delete file!");
	                        $file_path = "";
	                    }

	                    $_POST['file'] = "/".$config['files']['upl_dir']."files/".$file_path;
	                }
	                else
   	    		        debug ("no file to upload");

					$dob = new DataObject();
					$dob -> table = "ksh_files";
					$dob -> categories_table = "ksh_files_categories";
					$cnt = $dob -> add();
                    $content .= gen_content("files", "add", array_merge($module_data, $cnt));						
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "edit":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$config['themes']['page_title']['action'] = "Редактирование файла";
					$element = 0;
					if (isset($_GET['element']))
						$element = $_GET['element'];
					if (isset($_POST['id']))
						$element = $_POST['id'];

					$dob = new DataObject();
					$dob -> table = "ksh_files";
					$dob -> categories_table = "ksh_files_categories";
					$cnt = $dob -> edit($element);
					if (is_numeric($cnt['category']) && !isset($cnt['category_name']))
					{
						$cat = new Category();
						$cnt['category_name'] = $cat -> get_name("ksh_files_categories", $cnt['category']);
					}
					$content .= gen_content("files", "edit", array_merge($module_data, $cnt));
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "del":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$config['themes']['page_title']['action'] = "Удаление файла";
					$dob = new DataObject();
					$dob -> table = "ksh_files";
					$cnt = $dob -> del($_GET['element']);
					$content .= gen_content("files", "del", array_merge($module_data, $cnt));						
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "view":
				$content_data = files_view();
				$content .= gen_content("files", $config['files']['files_template'], $content_data);
            break;

			case "privileges_edit":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$priv = new Privileges();
					$cnt = $priv -> edit("files");
					$content .= gen_content("files", "privileges_edit", $cnt);
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;

			case "access_edit":
				if ($priv -> has("files", "config_edit", "write"))
				{
					$acc = new Access();
					$cnt = $acc -> edit("files");
					debug("content:", 2);
					dump($cnt);
					$content .= gen_content("files", "access_edit", $cnt);
				}
				else
					$content .= gen_content("auth", "show_login_form", auth_show_login_form());
			break;
		}
	}
	else
	{
		debug ("*** action: default");
		$config['themes']['page_title']['action'] = "Категории";
		$config['files']['page_title'] .= " - Категории";
		$cat = new Category();
		$cnt = $cat -> view("ksh_files_categories");
		$content .= gen_content("files", "categories_view", array_merge($module_data, $cnt));
	}

	debug("=== end: mod: files ===<br>");
	return $content;
}

?>
