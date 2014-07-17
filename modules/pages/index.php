<?php

// Base functions of the "pages" module


include_once ("db.php");
include_once ("pages.php");

include_once ($config['modules']['location']."files/index.php"); // to upload pictures

function pages_admin()
{
	debug ("*** pages_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
    	'heading' => ''
    );
    $content['heading'] = "Администрирование страниц сайта";
	debug ("*** end: pages_admin ***");
    return $content;
}

function pages_help()
{
	debug ("*** pages_help ***");
	global $config;
	global $user;
	$content['content'] = "";

	debug ("*** end: pages_help ***");
	return $content;
}

function pages_frontpage()
{
        debug ("*** pages_frontpage ***");
        global $config;
        $content = array(
        	'content' => '',
			'if_show_admin_link' => ''
        );
		$priv = new Privileges();
		if ($priv -> has("pages", "admin", "write"))
			$content['if_show_admin_link'] = "yes";

        debug ("*** end: pages_frontpage ***");
        return $content;
}

function pages_get_actions_list()
{
	debug ("*** pages_get_actions_list ***");
	global $user;
	global $debug;
	
	$actions_list = array(
		'help',
		'create_tables',
		'drop_tables',
		'update_tables',
		'categories_view',
		'categories_add',
		'categories_del',
		'categories_edit',
		'view_by_category',
		'add',
		'del',
		'edit',
		'admin',
		'view',
		'list_view',
		'transfer'
	);

	debug ("*** end: pages_get_actions_list ***");
	return $actions_list;
}

function pages_default_action()
{
        global $user;
        global $config;

        $content = "";

		if(isset($_GET['element']) && !isset($_GET['page']))
			$_GET['page'] = rtrim($_GET['element'], "/");

		$module_data = array (
			'module_name' => "pages",
			'module_title' => "Страницы"
		);
		$config['pages']['page_title'] = $module_data['module_title'];
		$config['themes']['page_title']['module'] = "Страницы";

		$priv = new Privileges();

        debug("<br>=== mod: pages ===");

        if (isset($_GET['action']))
        {
			if (isset($_POST['do_del_category']))
			{
				if ($priv -> has("pages", "admin", "write"))
				{
					debug ("deleting category");
					$cat = new Category();
					$result = $cat -> del("ksh_pages_categories", "ksh_pages", $_POST['category']);
				}
			}
			
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
							$config['themes']['page_title']['action'] = "";
							$content .= gen_content("pages", "frontpage", pages_frontpage());
							$content .= gen_content("pages", "view", pages_view("frontpage"));
                        break;

                        case "help":
							$config['themes']['page_title']['action'] = "Справка";
                            $content .= gen_content("pages", "help", pages_help());
                        break;

                        case "create_tables":
							$config['themes']['page_title']['action'] = "Создание таблиц БД";
							if ($priv -> has("pages", "admin", "write"))
	                            $content .= gen_content("pages", "tables_create", pages_tables_create());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "drop_tables":
							$config['themes']['page_title']['action'] = "Удаление таблиц БД";
							if ($priv -> has("pages", "admin", "write"))
	                            $content .= gen_content("pages", "drop_tables", pages_tables_drop());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "update_tables":
							$config['themes']['page_title']['action'] = "Обновление таблиц БД";
							if ($priv -> has("pages", "admin", "write"))
						        $content .= gen_content("pages", "tables_update", pages_tables_update());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "categories_view":
							$config['themes']['page_title']['action'] = "Категории";
							$config['pages']['page_title'] .= " - Категории";
							$cat = new Category();
							$cnt = $cat -> view("ksh_pages_categories");
							$content .= gen_content("pages", "categories_view", array_merge($module_data, $cnt));
						break;

                        case "categories_add":
							$config['themes']['page_title']['action'] = "Добавление категории";
							$config['pages']['page_title'] .= " - Добавление категории";
							if ($priv -> has("pages", "admin", "write"))
							{
								$cat = new Category();
								$cnt = $cat -> add("ksh_pages_categories");
    	                        $content .= gen_content("pages", "categories_add", array_merge($module_data, $cnt));
							}
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "categories_del":
							$config['themes']['page_title']['action'] = "Удаление категории";
							$config['pages']['page_title'] .= " - Удаление категории";
							if ($priv -> has("pages", "admin", "write"))
							{
								$cat = new Category();
								$cnt = $cat -> del("ksh_pages_categories", "ksh_pages", $_GET['category']);
                	            $content .= gen_content("pages", "categories_del", array_merge($module_data, $cnt));
							}
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "categories_edit":
							$config['themes']['page_title']['action'] = "Редактирование категории";
							$config['pages']['page_title'] .= " - Редактирование категории";
							if ($priv -> has("pages", "admin", "write"))
							{
								$cat = new Category();
								$cnt = $cat -> edit("ksh_pages_categories", $_GET['category']);
		                        $content .= gen_content("pages", "categories_edit", array_merge($module_data, $cnt));
							}
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;


						case "view_by_category":
							$config['themes']['page_title']['action'] = "Просмотр страниц в категории";
							$content_data = pages_view_by_category();
                            $content .= gen_content("pages", "view_by_category", $content_data);
                        break;

                        case "add":
							$config['themes']['page_title']['action'] = "Добавление страницы";
							$config['themes']['admin'] = "yes";
							if ($priv -> has("pages", "admin", "write"))
                            	$content .= gen_content("pages", "add", pages_add());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "del":
							$config['themes']['page_title']['action'] = "Удаление страницы";
							$config['themes']['admin'] = "yes";
							if ($priv -> has("pages", "admin", "write"))
                            	$content .= gen_content("pages", "del", pages_del());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "edit":
							$config['themes']['page_title']['action'] = "Редактирование страницы";
							$config['themes']['admin'] = "yes";
							if ($priv -> has("pages", "admin", "write"))
	                            $content .= gen_content("pages", "edit", pages_edit());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "admin":
							$config['themes']['page_title']['action'] = "Администрирование";
							if ($priv -> has("pages", "admin", "write"))
                            	$content .= gen_content("pages", "admin", pages_admin());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "view":
							$config['themes']['page_title']['action'] = "Просмотр страницы";
//                                $content .= gen_content("pages", "view_".$_GET['page'], pages_view($_GET['page']));
							$_GET['module'] = "pages";
							$_GET['action'] = "view";
							// $_GET['page'] = "glued_logs";
							$content .= gen_content("pages", "view", pages_view($_GET['page']));
                        break;

                        case "list_view":
							$config['themes']['page_title']['action'] = "Список страниц";
                            $content .= gen_content("pages", "list_view", pages_list_view());
                        break;

                        case "transfer":
							$config['themes']['page_title']['action'] = "Перенос страниц";
							if ($priv -> has("pages", "admin", "write"))
	                            $content .= gen_content("pages", "transfer", pages_transfer());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                }
        }

        else
        {
                debug ("*** action: default");
				$config['themes']['page_title']['action'] = "";
                $content = gen_content("pages", "frontpage", pages_frontpage());
				$content .= gen_content("pages", "view", pages_view("frontpage"));
        }

        debug("=== end: mod: pages ===<br>");
        return $content;

}

?>
