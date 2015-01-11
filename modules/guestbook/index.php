<?php

// Base functions of the "guestbook" module


include_once ("db.php");
include_once ("guestbook.php");

function guestbook_admin()
{
	debug ("*** guestbook_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
    	'heading' => ''
    );
    $content['heading'] = "Администрирование гостевых книг";
	debug ("*** end: guestbook_admin ***");
    return $content;
}

function guestbook_help()
{
	debug ("*** guestbook_help ***");
	global $config;
	global $user;
	$content['content'] = "";

	debug ("*** end: guestbook_help ***");
	return $content;
}


function guestbook_default_action()
{
        global $user;
        global $config;
		global $template;

        $content = "";

		$descr_file_path = $config['modules']['location']."guestbook/description.ini";
		debug ("descr_file_path: ".$descr_file_path);
		$module_data = parse_ini_file($descr_file_path);
		$module_data['module_name'] = $module_data['name']; // added to compatibility with base categories
		$module_data['module_title'] = $module_data['title']; // added to compatibility with base categories
		dump($module_data);

		if (isset($config['guestbook']))
			array_merge($module_data, $config['guestbook']);
		else
			$config['guestbook'] = $module_data;
		dump($config['guestbook']);

		$config['themes']['page_title'] .= " - ".$module_data['title'];
		$config['modules']['current_module'] = "guestbook";

        debug("<br>=== mod: guestbook ===");

		if (isset($_POST['do_del']))
		{
			$priv = new Privileges();
			debug ("have message to delete");
			if ($priv -> has("guestbook", "del", "write"))
			{
				debug ("user has admin rights, deleting message");
				$sql_query = "DELETE FROM `ksh_guestbook` WHERE `id` = '".mysql_real_escape_string($_POST['id'])."'";
				exec_query($sql_query);
			}
			else
				debug ("user doesn't have admin rights");
		}

        if (isset($_GET['action']))
        {
			$_GET['action'] = rtrim($_GET['action'], "/");
			
			if (isset($_GET['element']))
				$_GET['element'] = rtrim($_GET['element'], "/");
			
			if (isset($_GET['page']))
				$_GET['page'] = rtrim($_GET['page'], "/");

			if (isset($_POST['do_del_category']))
			{
				debug ("deleting category");
				$cat = new Category();
				$result = $cat -> del("ksh_guestbook_categories", "ksh_guestbook", $_POST['category']);
			}
			
			
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
							$config['themes']['page_title'] .= " - Просмотр гостевой книги";
							$gb = new Guestbook();
							$_GET['category'] = 1;
							$cnt = $gb -> view_by_category();
            			    $content .= gen_content("guestbook", "view_by_category", array_merge($module_data, $cnt));
                        break;

                        case "admin":
                                $content .= gen_content("guestbook", "admin", guestbook_admin());
                        break;

                        case "help":
							$config['themes']['page_title'] .= " - Справка";
                            $content .= gen_content("guestbook", "help", guestbook_help());
                        break;

                        case "create_tables":
                                $content .= gen_content("guestbook", "tables_create", guestbook_tables_create());
                        break;

                        case "drop_tables":
                                $content .= gen_content("guestbook", "drop_tables", guestbook_tables_drop());
                        break;

                        case "update_tables":
                                $content .= gen_content("guestbook", "tables_update", guestbook_tables_update());
                        break;

						case "categories_view":
							$config['themes']['page_title'] .= " - Гостевые книги";
							$cat = new Category();
							$cnt = $cat -> view("ksh_guestbook_categories");
							$content .= gen_content("guestbook", "categories_view", array_merge($module_data, $cnt));
						break;

                        case "categories_add":
							$config['themes']['page_title'] .= " - Добавление гостевой книги";
							$cat = new Category();
							$cnt = $cat -> add("ksh_guestbook_categories");
                            $content .= gen_content("guestbook", "categories_add", array_merge($module_data, $cnt));
                        break;

                        case "categories_del":
							if (isset($_GET['element']))
								$_GET['category'] = $_GET['element'];
							$config['themes']['page_title'] .= " - Удаление гостевой книги";
							$cat = new Category();
							$cnt = $cat -> del("ksh_guestbook_categories", "ksh_guestbook", $_GET['category']);
							$content .= gen_content("guestbook", "categories_del", array_merge($module_data, $cnt));
                        break;

						case "categories_edit":
							if (isset($_GET['element']))
								$_GET['category'] = $_GET['element'];
							$config['themes']['page_title'] .= " - Редактирование описания гостевой книги";
							$cat = new Category();
							$cnt = $cat -> edit("ksh_guestbook_categories", $_GET['category']);
	                        $content .= gen_content("guestbook", "categories_edit", array_merge($module_data, $cnt));
                        break;


						case "view_by_category":
							if (isset($_GET['element']))
								$_GET['category'] = $_GET['element'];
							$config['themes']['page_title'] .= " - Просмотр сообщений";
							$template['title'] .= " - Просмотр сообщений";
							$gb = new Guestbook();
							$cnt = $gb -> view_by_category();
                            $content .= gen_content("guestbook", "view_by_category", array_merge($module_data, $cnt));
                        break;

                        case "add":
							if (isset($_GET['element']))
								$_GET['category'] = $_GET['element'];
							$config['themes']['page_title'] .= " - Добавление сообщения";
							$gb = new Guestbook();
							$cnt = $gb -> add();
                            $content .= gen_content("guestbook", "add", array_merge($module_data, $cnt));
                        break;

                        case "del":
							if (isset($_GET['element']))
								$_GET['bill'] = $_GET['element'];
							$config['themes']['page_title'] .= " - Удаление сообщения";
							$gb = new Guestbook();
							$cnt = $gb -> del();
                            $content .= gen_content("guestbook", "del", array_merge($module_data, $cnt));
                        break;


                        case "edit":
							if (isset($_GET['element']))
								$_GET['bill'] = $_GET['element'];
							$config['themes']['page_title'] .= " - Редактирование сообщения";
							$gb = new Guestbook();
							$cnt = $gb -> edit();
                            $content .= gen_content("guestbook", "edit", array_merge($module_data, $cnt));
                        break;
                }
        }

        else
        {
                debug ("*** action: default");
				$config['themes']['page_title'] .= " - Просмотр гостевой книги";
				$gb = new Guestbook();
				$_GET['category'] = 1;
				$cnt = $gb -> view_by_category(); 
                $content .= gen_content("guestbook", "view_by_category", array_merge($module_data, $cnt));
        }


		debug("=== end: mod: guestbook ===<br>");
        return $content;

}

?>
