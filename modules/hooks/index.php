<?php

// Base functions of the "hooks" module


include_once ("db.php");
include_once ("hooks.php");

function hooks_admin()
{
	debug ("*** hooks_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => ''
    );
	debug ("*** end: hooks_admin ***");
    return $content;
}

function hooks_help()
{
	debug ("*** hooks_help ***");
	global $config;
    global $user;
    $content = array(
    	'content' => ''
    );
	debug ("*** end: hooks_help ***");
    return $content;
}

function hooks_frontpage()
{
        debug ("*** hooks_frontpage ***");
        global $config;
        $content = array(
        	'content' => ''
        );
        $content['content'] = "";
        debug ("*** end: hooks_frontpage ***");
        return $content;
}


function hooks_default_action()
{
        global $user;
        global $config;

        debug("<br>=== mod: hooks ===");

        $content = "";

		$module_data = array (
			'module_name' => "hooks",
			'module_title' => "Привязки динамического контента"
		);
		$config['pages']['page_title'] = $module_data['module_title'];

		$priv = new Privileges();

        if (isset($_GET['action']))
        {
			if (1 == $user['id'])
			{
				if (isset($_POST['do_del_category']))
				{
					debug ("deleting category");
					$cat = new Category();
					$result = $cat -> del("ksh_hooks_categories", "ksh_hooks", $_POST['category']);
				}
				if (isset($_POST['do_del']))
				{
					debug ("deleting element");
					$sql_query = "DELETE FROM `ksh_hooks` WHERE `id` = '".stripslashes($_POST['id'])."'";
					exec_query($sql_query);
				}
			}

                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
							if ($priv -> has("hooks", "admin", "write"))
                                //$content .= gen_content("hooks", "frontpage", hooks_frontpage());
                                $content .= gen_content("hooks", "admin", hooks_admin());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "create_tables":
							$config['pages']['page_title'] .= " - Создание таблиц";
                            $content .= gen_content("hooks", "tables_create", hooks_tables_create());
                        break;

                        case "drop_tables":
							$config['pages']['page_title'] .= " - Удаление таблиц";
							if ($priv -> has("hooks", "admin", "write"))
                                $content .= gen_content("hooks", "drop_tables", hooks_tables_drop());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "update_tables":
							$config['pages']['page_title'] .= " - Обновление таблиц";

							if (!in_array("ksh_hooks_privileges", db_tables_list()))
								$priv -> create_table("ksh_hooks_privileges");

							if ($priv -> has("hooks", "admin", "write"))
                                $content .= gen_content("hooks", "tables_update", hooks_tables_update());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "add":
							$config['pages']['page_title'] .= " - Добавление привязки";
							if ($priv -> has("hooks", "admin", "write"))
                                $content .= gen_content("hooks", "add", hooks_add());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "del":
							$config['pages']['page_title'] .= " - Удаление привязки";
							if ($priv -> has("hooks", "admin", "write"))
                                $content .= gen_content("hooks", "del", hooks_del());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "edit":
							$config['pages']['page_title'] .= " - Редактирование привязки";
							if ($priv -> has("hooks", "admin", "write"))
                                $content .= gen_content("hooks", "edit", hooks_edit());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "admin":
							$config['pages']['page_title'] .= " - Администрирование";
							if ($priv -> has("hooks", "admin", "write"))
                                $content .= gen_content("hooks", "admin", hooks_admin());
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "help":
							$config['pages']['page_title'] .= " - Справка";
                                $content .= gen_content("hooks", "help", hooks_help());
                        break;

                        case "list_view":
							$config['pages']['page_title'] .= " - Список всех привязок";
                                $content .= gen_content("hooks", "list_view", hooks_list_view());
                        break;

						case "categories_view":
							$config['pages']['page_title'] .= " - Категории";
							$cat = new Category();
							$cnt = $cat -> view("ksh_hooks_categories");
							$content .= gen_content("hooks", "categories_view", array_merge($module_data, $cnt));
						break;

                        case "categories_add":
							$config['pages']['page_title'] .= " - Добавление категории";
							if ($priv -> has("hooks", "admin", "write"))
							{
								$cat = new Category();
								$cnt = $cat -> add("ksh_hooks_categories");
        	                    $content .= gen_content("hooks", "categories_add", array_merge($module_data, $cnt));
							}
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

                        case "categories_del":
							$config['pages']['page_title'] .= " - Удаление категории";
							if ($priv -> has("hooks", "admin", "write"))
							{
								$cat = new Category();
								$cnt = $cat -> del("ksh_hooks_categories", "ksh_hooks", $_GET['category']);
	                            $content .= gen_content("hooks", "categories_del", array_merge($module_data, $cnt));
							}
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "categories_edit":
							$config['pages']['page_title'] .= " - Редактирование категории";
							if ($priv -> has("hooks", "admin", "write"))
							{
								$cat = new Category();
								$cnt = $cat -> edit("ksh_hooks_categories", $_GET['category']);
		                        $content .= gen_content("hooks", "categories_edit", array_merge($module_data, $cnt));
							}
							else
								$content .= gen_content("auth", "show_login_form", auth_show_login_form());
                        break;

						case "view_by_category":
							$config['pages']['page_title'] .= " - Просмотр категории";
							if (!isset($_GET['category']) && isset($_GET['element']))
								$_GET['category'] = $_GET['element'];
							$dobj = new DataObject();
							$dobj -> categories_table = "ksh_hooks_categories";
							$dobj -> elements_table = "ksh_hooks";
							$dobj -> elements_on_page = $config['hooks']['elements_on_page'];
							$dobj -> order_field = "id";
							$cnt = $dobj -> view_by_category($_GET['category']);
	                        $content .= gen_content("hooks", "view_by_category", array_merge($module_data, $cnt));
						break;
                }
        }

        else
        {
            debug ("*** action: default");
            // $content = gen_content("hooks", "frontpage", hooks_frontpage());
			if ($priv -> has("hooks", "admin", "write"))
                $content = gen_content("hooks", "admin", hooks_admin());
			else
				$content .= gen_content("auth", "show_login_form", auth_show_login_form());
        }

        debug("=== end: mod: hooks ===<br>");
        return $content;

}

?>
