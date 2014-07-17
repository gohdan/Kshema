<?php

// Base functions of the "auto_models" module


include_once ("db.php");
include_once ("models.php");
include_once ("characteristics.php");
include_once ("prices.php");
include_once ("equipment.php");
include_once ("images.php");
include_once ("videos.php");
include_once ("colors.php");

function auto_models_frontpage()
{
	debug ("*** auto_models_frontpage ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
		'if_show_admin_link' => ''
    );

	$priv = new Privileges();
	if ($priv -> has ("auto_models", "admin", "write"))
		$content['if_show_admin_link'] = "yes";

	$i = 0;
    $models = auto_models_list();

	if (0 == count($models))
		$content['content'] .= "������� ���";
	else
	{
       	foreach ($models as $k => $v)
       	{
           	$content['models'][$i]['id'] = stripslashes($v['id']);
            $content['models'][$i]['name'] = stripslashes($v['name']);
            $content['models'][$i]['title'] = stripslashes($v['title']);
            $content['models'][$i]['image'] = stripslashes($v['image']);
            if (1 == $user['id'])
            {
	           	$content['models'][$i]['if_show_edit_link'] = "yes";
				$content['models'][$i]['if_show_del_link'] = "yes";
            }
			$i++;
       	}
	}

	debug ("*** end: auto_models_frontpage ***");
    return $content;
}


function auto_models_admin()
{
	debug ("*** auto_models_admin ***");
	global $config;
    global $user;
    $content = array(
    	'content' => ''
    );
	debug ("*** end: auto_models_admin ***");
    return $content;
}



function auto_models_default_action()
{
        global $user;
        global $config;

        $content = "";

		$module_data = array (
			'module_name' => "auto_models",
			'module_title' => "��������"
		);
		$config['pages']['page_title'] = $module_data['module_title'];
		$config['themes']['page_title']['module'] = "������ �����������";

        debug("<br>=== mod: auto_models ===");
		if (isset($_GET['element']))
			$_GET['model'] = $_GET['element'];

		$config['modules']['current_module'] = "auto_models";
		if (isset($_GET['model']))
			$config['modules']['current_id'] = $_GET['model'];

		$config['themes']['page_title']['module'] = "����������";

		$descr_file_path = $config['modules']['location']."auto_models/description.ini";
		debug ("descr_file_path: ".$descr_file_path);
		$module_data = parse_ini_file($descr_file_path);
		$module_data['module_name'] = $module_data['name']; // added to compatibility with base categories
		$module_data['module_title'] = $module_data['title']; // added to compatibility with base categories
		dump($module_data);

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);
                switch ($_GET['action'])
                {
                        default:
							$config['themes']['page_title']['action'] = "����������";
                            $content .= gen_content("auto_models", "frontpage", auto_models_frontpage());
                        break;

                        case "admin":
							$config['themes']['page_title']['action'] = "�����������������";
                            $content .= gen_content("auto_models", "admin", auto_models_admin());
                        break;

						case "create_tables":
							$config['themes']['page_title']['action'] = "�������� ������ ��";
                            $content .= gen_content("auto_models", "tables_create", auto_models_tables_create());
                        break;

                        case "drop_tables":
							$config['themes']['page_title']['action'] = "�������� ������ ��";
                            $content .= gen_content("auto_models", "drop_tables", auto_models_tables_drop());
                        break;

                        case "update_tables":
							$config['themes']['page_title']['action'] = "���������� ������ ��";
                            $content .= gen_content("auto_models", "tables_update", auto_models_tables_update());
                        break;

						case "privileges_edit":
							$config['themes']['page_title']['action'] .= " - ���������� ����";
							$priv = new Privileges();
							$cnt = $priv -> edit("auto_models");
							$content .= gen_content("auto_models", "privileges_edit", array_merge($module_data, $cnt));
						break;

						case "categories_view":
							$config['themes']['page_title']['action'] = "���������";
							$config['pages']['page_title'] .= " - ���������";
							$cat = new Category();
							$cnt = $cat -> view("ksh_auto_models_categories");
							$content .= gen_content("auto_models", "categories_view", array_merge($module_data, $cnt));
						break;

                        case "categories_add":
							$config['themes']['page_title']['action'] = "���������� ���������";
							$config['pages']['page_title'] .= " - ���������� ���������";
							$cat = new Category();
							$cnt = $cat -> add("ksh_auto_models_categories");
                            $content .= gen_content("auto_models", "categories_add", array_merge($module_data, $cnt));
                        break;

                        case "categories_del":
							$config['themes']['page_title']['action'] = "�������� ���������";
							$config['pages']['page_title'] .= " - �������� ���������";
							$cat = new Category();
							$cnt = $cat -> del("ksh_auto_models_categories", "ksh_auto_models", $_GET['category']);
                            $content .= gen_content("auto_models", "categories_del", array_merge($module_data, $cnt));
                        break;

						case "categories_edit":
							$config['themes']['page_title']['action'] = "�������������� ���������";
							$config['pages']['page_title'] .= " - �������������� ���������";
							$cat = new Category();
							$cnt = $cat -> edit("ksh_auto_models_categories", $_GET['category']);
	                        $content .= gen_content("auto_models", "categories_edit", array_merge($module_data, $cnt));
                        break;

						case "view_by_category":
							$config['themes']['page_title']['action'] = "�������� ������� � ���������";
							$content_data = auto_models_view_by_category();
                            $content .= gen_content("auto_models", "view_by_category", $content_data);
                        break;

                        case "add":
							$config['themes']['page_title']['action'] = "���������� ������";
                            $content .= gen_content("auto_models", "add", auto_models_add());
                        break;

						case "del":
							$config['themes']['page_title']['action'] = "�������� ������";
                            $content .= gen_content("auto_models", "del", auto_models_del());
                        break;

                        case "edit":
							$config['themes']['page_title']['action'] = "�������������� ������";
                            $content .= gen_content("auto_models", "edit", auto_models_edit());
                        break;


                        case "view":
							$config['themes']['page_title']['action'] = "�������� ������";
							$content .= gen_content("auto_models", "view", auto_models_view($_GET['model']));
                        break;

                        case "list_view":
							$config['themes']['page_title']['action'] = "������ �������";
                            $content .= gen_content("auto_models", "list_view", auto_models_list_view());
                        break;

						case "characteristics_view":
							$config['themes']['page_title']['action'] = "����������� ��������������";
							$content .= gen_content("auto_models", "characteristics_view", auto_models_characteristics_view());
						break;

						case "characteristics_edit":
							$config['themes']['page_title']['action'] = "�������������� ����������� �������������";
							$content .= gen_content("auto_models", "characteristics_edit", auto_models_characteristics_edit());
						break;

						case "prices_view":
							$config['themes']['page_title']['action'] = "������������ � ����";
							$content .= gen_content("auto_models", "prices_view", auto_models_prices_view());
						break;

						case "prices_edit":
							$config['themes']['page_title']['action'] = "�������������� ������������ � ���";
							$content .= gen_content("auto_models", "prices_edit", auto_models_prices_edit());
						break;

						case "equipment_view":
							$config['themes']['page_title']['action'] = "�������������� ������������";
							$content .= gen_content("auto_models", "equipment_view", auto_models_equipment_view());
						break;

						case "equipment_add":
							$config['themes']['page_title']['action'] = "���������� ��������������� ������������";
							$content .= gen_content("auto_models", "equipment_add", auto_models_equipment_add());
						break;

						case "equipment_edit":
							$config['themes']['page_title']['action'] = "�������������� ��������������� ������������";
							$content .= gen_content("auto_models", "equipment_edit", auto_models_equipment_edit());
						break;

						case "equipment_del":
							$config['themes']['page_title']['action'] = "�������� ��������������� ������������";
							$content .= gen_content("auto_models", "equipment_del", auto_models_equipment_del());
						break;
						
						case "images_view":
							$config['themes']['page_title']['action'] = "�����������";
							$content .= gen_content("auto_models", "images_view", auto_models_images_view());
						break;

						case "images_add":
							$config['themes']['page_title']['action'] = "���������� ����������";
							$content .= gen_content("auto_models", "images_add", auto_models_images_add());
						break;

						case "images_edit":
							$config['themes']['page_title']['action'] = "�������������� ����������";
							$content .= gen_content("auto_models", "images_edit", auto_models_images_edit());
						break;

						case "images_del":
							$config['themes']['page_title']['action'] = "�������� ����������";
							$content .= gen_content("auto_models", "images_del", auto_models_images_del());
						break;
						
						case "videos_view":
							$config['themes']['page_title']['action'] = "�����������";
							$content .= gen_content("auto_models", "videos_view", auto_models_videos_view());
						break;

						case "videos_add":
							$config['themes']['page_title']['action'] = "���������� ������������";
							$content .= gen_content("auto_models", "videos_add", auto_models_videos_add());
						break;

						case "videos_edit":
							$config['themes']['page_title']['action'] = "�������������� �����������";
							$content .= gen_content("auto_models", "videos_edit", auto_models_videos_edit());
						break;

						case "videos_del":
							$config['themes']['page_title']['action'] = "�������� �����������";
							$content .= gen_content("auto_models", "videos_del", auto_models_videos_del());
						break;

						case "colors_view":
							$config['themes']['page_title']['action'] = "�����";
							$content .= gen_content("auto_models", "colors_view", auto_models_colors_view());
						break;

						case "colors_add":
							$config['themes']['page_title']['action'] = "���������� ������";
							$content .= gen_content("auto_models", "colors_add", auto_models_colors_add());
						break;

						case "colors_edit":
							$config['themes']['page_title']['action'] = "�������������� �����";
							$content .= gen_content("auto_models", "colors_edit", auto_models_colors_edit());
						break;

						case "colors_del":
							$config['themes']['page_title']['action'] = "�������� �����";
							$content .= gen_content("auto_models", "colors_del", auto_models_colors_del());
						break;

						case "present_add":

							$priv = new Privileges;
							if ($priv -> has("auto_models", "present_add", "read"))
							{

								/* image upload funcs */

							    global $upl_pics_dir;
							    global $doc_root;
							    global $max_file_size;
								global $home;

								if (isset($_FILES['image'])) $image = $_FILES['image'];
								$if_file_exists = 0;
								$file_path = "";

								if (isset($_FILES['doc'])) $doc = $_FILES['doc'];
								$if_doc_exists = 0;
								$doc_path = "";

				                if ("" != $image['name'])
				                {
				                    debug ("there is an image to upload");
				                    if (file_exists($doc_root.$upl_pics_dir."auto_models/present/".$image['name'])) $if_file_exists = 1;
				                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."auto_models/present/",$if_file_exists);
				                    debug ("size: ".filesize($home.$file_path));

				                    if (filesize($home.$file_path) > $max_file_size)
				                    {
				                        debug ("file size > max file size!");
				                        $content['result'] .= "��������, �� ������ �������� ���� �������� ������ ".($max_file_size / 1024)." ��������";
				                        if (unlink ($home.$file_path)) debug ("file deleted");
				                        else debug ("can't delete file!");
				                        $file_path = "";
				                    }

				                    $_POST['image'] = $file_path;

				                }
				                else
				                {
				                    debug ("no image to upload");
				                    $file_path = $_POST['image'];
									$_POST['image'] = $_POST['old_image'];
				                }

								/* end: image upload funcs */

								$dob = new DataObject();
								$dob -> table = "ksh_auto_models_present";
								$dob -> categories_table = "";
								$cnt = $dob -> add();
								$cnt['show_form'] = "yes";

								$models = auto_models_list();
								debug("models:");
								dump($models);
								$i = 0;
								foreach ($models as $k => $v)
								{
									$cnt['models_select'][$i]['id'] = $v['id'];
									$cnt['models_select'][$i]['title'] = $v['title'];
									$i++;
								}
								debug("cnt models_select:");
								dump($cnt['models_select']);

							}
							else
								$cnt['result'] = "������������ ����";

							$content .= gen_content("auto_models", "present_add", array_merge($module_data, $cnt));
						break;

                        case "present_view":
							$dbo = new DataObject;
							$dbo -> elements_table = "ksh_auto_models_present";
							$dbo -> elements_on_page = $config['auto_models']['elements_on_page'];
							$cnt = $dbo -> view_by_category(1);
							
							$templ = new Templater();
							$cnt['elements'] = $templ -> colonize($cnt['elements'], $config['auto_models']['present_cols']);

							$cnt['present'] = $cnt['elements'];
							$priv = new Privileges();
							if ($priv -> has("auto_models", "admin", "write"))
								$cnt['show_admin_link'] = "yes";

							$sql_query = "SELECT MAX(`date`) FROM `ksh_auto_models_present`";
							$result = exec_query($sql_query);
							$row = mysql_fetch_array($result);
							mysql_free_result($result);
							
							$date = explode("-", stripslashes($row['MAX(`date`)']));
							$cnt['date'] = $date[2].".".$date[1].".".$date[0];

							debug("cnt: ");
							dump($cnt);
		                    $content .= gen_content("auto_models", "present_view", $cnt);						
                        break;
						
						case "present_edit":

							$priv = new Privileges;
							if ($priv -> has("auto_models", "present_edit", "read"))
							{
								/* image upload funcs */

							    global $upl_pics_dir;
							    global $doc_root;
							    global $max_file_size;
								global $home;

								if (isset($_FILES['image'])) $image = $_FILES['image'];
								$if_file_exists = 0;
								$file_path = "";

								if (isset($_FILES['doc'])) $doc = $_FILES['doc'];
								$if_doc_exists = 0;
								$doc_path = "";

				                if ("" != $image['name'])
				                {
				                    debug ("there is an image to upload");
				                    if (file_exists($doc_root.$upl_pics_dir."auto_models/present/".$image['name'])) $if_file_exists = 1;
				                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."auto_models/present/",$if_file_exists);
				                    debug ("size: ".filesize($home.$file_path));

				                    if (filesize($home.$file_path) > $max_file_size)
				                    {
				                        debug ("file size > max file size!");
				                        $content['result'] .= "��������, �� ������ �������� ���� �������� ������ ".($max_file_size / 1024)." ��������";
				                        if (unlink ($home.$file_path)) debug ("file deleted");
				                        else debug ("can't delete file!");
				                        $file_path = "";
				                    }

				                    $_POST['image'] = $file_path;

				                }
				                else
				                {
				                    debug ("no image to upload");
				                    $file_path = $_POST['image'];
									$_POST['image'] = $_POST['old_image'];
				                }

								/* end: image upload funcs */

								$dob = new DataObject();
								$dob -> table = "ksh_auto_models_present";
								$dob -> categories_table = "";
								$cnt = $dob -> edit($_GET['element']);
								$cnt['show_form'] = "yes";
								debug("cnt: ", 2);
								dump($cnt);
								$el = $dob -> get($_GET['element']);
								debug("el: ", 2);
								dump($el);
								$cnt = array_merge($cnt, $el);

								$models = auto_models_list();
								debug("models:");
								dump($models);
								$i = 0;
								foreach ($models as $k => $v)
								{
									$cnt['models_select'][$i]['id'] = $v['id'];
									$cnt['models_select'][$i]['title'] = $v['title'];
									if ($v['id'] == $el['model'])
										$cnt['models_select'][$i]['selected'] = "yes";
									$i++;
								}
								debug("cnt models_select:");
								dump($cnt['models_select']);


							}
							else
								$cnt['result'] = "������������ ����";

		                    $content .= gen_content("auto_models", "present_edit", array_merge($module_data, $cnt));
						break;

						case "present_del":
							$priv = new Privileges;
							if ($priv -> has("auto_models", "present_del", "read"))
							{
								$dob = new DataObject();
								$dob -> table = "ksh_auto_models_present";
								$dob -> categories_table = "";
								$cnt = $dob -> del($_GET['element']);
							}
							else
								$cnt['result'] = "������������ ����";

							$content .= gen_content("auto_models", "present_del", array_merge($module_data, $cnt));
						break;




						case "preowned_add":

							/* image upload funcs */

						    global $upl_pics_dir;
						    global $doc_root;
						    global $max_file_size;
							global $home;

							if (isset($_FILES['image'])) $image = $_FILES['image'];
							$if_file_exists = 0;
							$file_path = "";

							if (isset($_FILES['doc'])) $doc = $_FILES['doc'];
							$if_doc_exists = 0;
							$doc_path = "";

			                if ("" != $image['name'])
			                {
			                    debug ("there is an image to upload");
			                    if (file_exists($doc_root.$upl_pics_dir."auto_models/preowned/".$image['name'])) $if_file_exists = 1;
			                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."auto_models/preowned/",$if_file_exists);
			                    debug ("size: ".filesize($home.$file_path));

			                    if (filesize($home.$file_path) > $max_file_size)
			                    {
			                        debug ("file size > max file size!");
			                        $content['result'] .= "��������, �� ������ �������� ���� �������� ������ ".($max_file_size / 1024)." ��������";
			                        if (unlink ($home.$file_path)) debug ("file deleted");
			                        else debug ("can't delete file!");
			                        $file_path = "";
			                    }

			                    $_POST['image'] = $file_path;

			                }
			                else
			                {
			                    debug ("no image to upload");
			                    $file_path = $_POST['image'];
								$_POST['image'] = $_POST['old_image'];
			                }

							/* end: image upload funcs */



							$dob = new DataObject();
							$dob -> table = "ksh_auto_models_preowned";
							$dob -> categories_table = "";
							$cnt = $dob -> add();

		                    $content .= gen_content("auto_models", "preowned_add", array_merge($module_data, $cnt));
						break;

                        case "preowned_view":
							$dbo = new DataObject;
							$dbo -> elements_table = "ksh_auto_models_preowned";
							$dbo -> elements_on_page = $config['auto_models']['elements_on_page'];
							$cnt = $dbo -> view_by_category(1);
							$cnt['preowned'] = $cnt['elements'];
							$priv = new Privileges();
							if ($priv -> has("auto_models", "admin", "write"))
								$cnt['show_admin_link'] = "yes";
							debug("cnt: ");
							dump($cnt);
		                    $content .= gen_content("auto_models", "preowned_view", $cnt);						
                        break;
						
						case "preowned_edit":


							/* image upload funcs */

						    global $upl_pics_dir;
						    global $doc_root;
						    global $max_file_size;
							global $home;

							if (isset($_FILES['image'])) $image = $_FILES['image'];
							$if_file_exists = 0;
							$file_path = "";

							if (isset($_FILES['doc'])) $doc = $_FILES['doc'];
							$if_doc_exists = 0;
							$doc_path = "";

			                if ("" != $image['name'])
			                {
			                    debug ("there is an image to upload");
			                    if (file_exists($doc_root.$upl_pics_dir."auto_models/preowned/".$image['name'])) $if_file_exists = 1;
			                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."auto_models/preowned/",$if_file_exists);
			                    debug ("size: ".filesize($home.$file_path));

			                    if (filesize($home.$file_path) > $max_file_size)
			                    {
			                        debug ("file size > max file size!");
			                        $content['result'] .= "��������, �� ������ �������� ���� �������� ������ ".($max_file_size / 1024)." ��������";
			                        if (unlink ($home.$file_path)) debug ("file deleted");
			                        else debug ("can't delete file!");
			                        $file_path = "";
			                    }

			                    $_POST['image'] = $file_path;

			                }
			                else
			                {
			                    debug ("no image to upload");
			                    $file_path = $_POST['image'];
								$_POST['image'] = $_POST['old_image'];
			                }

							/* end: image upload funcs */

							$dob = new DataObject();
							$dob -> table = "ksh_auto_models_preowned";
							$dob -> categories_table = "";
							$cnt = $dob -> edit($_GET['element']);
							debug("cnt: ", 2);
							dump($cnt);
							$el = $dob -> get($_GET['element']);
							debug("el: ", 2);
							dump($el);

		                    $content .= gen_content("auto_models", "preowned_edit", array_merge($cnt, $el));
						break;

						case "preowned_del":
							$dob = new DataObject();
							$dob -> table = "ksh_auto_models_preowned";
							$dob -> categories_table = "";
							$cnt = $dob -> del($_GET['element']);
		                    $content .= gen_content("auto_models", "preowned_del", $cnt);
						break;
                }
        }

        else
        {
                debug ("*** action: default");
				$config['themes']['page_title']['action'] = "����������";
                $content = gen_content("auto_models", "frontpage", auto_models_frontpage());
        }

        debug("=== end: mod: auto_models ===<br>");
        return $content;

}

?>
