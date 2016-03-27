<?php

// Base functions of the "menu" module

include_once ($config['modules']['location']."menu/config.php");

$config_file = $config['base']['doc_root']."/config/menu.php";
if (file_exists($config_file))
	include($config_file);

include_once ($config['modules']['location']."menu/db.php");
include_once ($config['modules']['location']."menu/elements.php");

function menu_admin()
{
	debug ("*** menu_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
    	'heading' => ''
    );
    $content['heading'] = "Администрирование списков меню";
	debug ("*** end: menu_admin ***");
    return $content;
}

function menu_help()
{
	debug ("*** menu_help ***");
	global $config;
	global $user;
	$content['content'] = "";

	debug ("*** end: menu_help ***");
	return $content;
}

function menu_frontpage()
{
        debug ("*** menu_frontpage ***");
        global $config;
        $content = array(
        	'content' => ''
        );
        $content['content'] = "";
        debug ("*** end: menu_frontpage ***");
        return $content;
}



function menu_default_action()
{
        global $user;
        global $config;

        $content = "";

		$mod_info = parse_ini_file($config['modules']['location']."menu/description.ini");
		if (isset($config['menu']))
			$config['menu'] = array_merge($config['menu'], $mod_info);
		else
			$config['menu'] = $mod_info;
		$config['menu']['module_name'] = "menu";
		$config['menu']['module_title'] = $config['menu']['title'];

		$module_data = $config['menu'];

        debug("<br>=== mod: menu ===");

        if (isset($_GET['action']))
        {
			if (isset($_POST['do_del_category']))
			{
				debug ("deleting category");
				$cat = new Category();
				$result = $cat -> del("ksh_menu_categories", "ksh_menu", $_POST['category']);
			}
			
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
                                // $content .= gen_content("menu", "frontpage", menu_frontpage());
                                $content .= gen_content("menu", "admin", menu_admin());
                        break;

                        case "help":
							$config['menu']['page_title'] .= " - Справка";
                            $content .= gen_content("menu", "help", menu_help());
                        break;

                        case "create_tables":
                                $content .= gen_content("menu", "tables_create", menu_tables_create());
                        break;

                        case "drop_tables":
                                $content .= gen_content("menu", "drop_tables", menu_tables_drop());
                        break;

                        case "update_tables":
                                $content .= gen_content("menu", "tables_update", menu_tables_update());
                        break;

						case "categories_view":
							$config['menu']['page_title'] .= " - Списки";
							$cat = new Category();
							$cnt = $cat -> view("ksh_menu_categories");
							$content .= gen_content("menu", "categories_view", array_merge($module_data, $cnt));
						break;

                        case "categories_add":
							$config['menu']['page_title'] .= " - Добавление списка";
							$cat = new Category();
							$cnt = $cat -> add("ksh_menu_categories");
                            $content .= gen_content("menu", "categories_add", array_merge($module_data, $cnt));
                        break;

                        case "categories_del":
							$config['menu']['page_title'] .= " - Удаление списка";
							$cat = new Category();
							$cnt = $cat -> del("ksh_menu_categories", "ksh_menu", $_GET['category']);
                            $content .= gen_content("menu", "categories_del", array_merge($module_data, $cnt));
                        break;

						case "categories_edit":
							$config['menu']['page_title'] .= " - Редактирование описания списка";
							$cat = new Category();
							$cnt = $cat -> edit("ksh_menu_categories", $_GET['category']);
	                        $content .= gen_content("menu", "categories_edit", array_merge($module_data, $cnt));
                        break;


						case "view_by_category":
								$content_data = menu_view_by_category();
                                $content .= gen_content("menu", "view_by_category", $content_data);
                        break;

                        case "add":
                                $content .= gen_content("menu", "add", menu_add());
                        break;

						case "del":
                                $content .= gen_content("menu", "del", menu_del());
                        break;

                        case "edit":
                                $content .= gen_content("menu", "edit", menu_edit());
                        break;

                        case "admin":
                                $content .= gen_content("menu", "admin", menu_admin());
                        break;
                }
        }

        else
        {
                debug ("*** action: default");
                // $content = gen_content("menu", "frontpage", menu_frontpage());
                $content .= gen_content("menu", "admin", menu_admin());
        }

        debug("=== end: mod: menu ===<br>");
        return $content;

}

?>
