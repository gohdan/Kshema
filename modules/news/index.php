<?php

// Base functions of the "news" module


include_once ("db.php");
include_once ("categories.php");
include_once ("news.php");

/* Import RSS */
include_once ($config['base']['doc_root']."/libs/lastrss/lastRSS.php");
include_once ("import_rss.php");

function news_admin()
{
	debug ("*** news_admin ***");
	global $config;
	global $user;
	$content = array (
		'content' => '',
		'heading' => ''
	);
	$content['heading'] = "����������������� ��������";
	debug ("*** end: news_admin ***");
	return $content;
}

function news_help()
{
	debug ("*** news_help ***");
	global $config;
	global $user;
	$content['content'] = "";
	debug ("*** end: news_help ***");
	return $content;
}

function news_frontpage()
{
    debug ("*** news_frontpage ***");
    global $config;
    global $user;
	global $page_title;
    $content = array(
    	'content' => '',
        'news' => '',
        'admin_link' => '',
        'result' => ''
    );
	$i = 0;

    if (1 == $user['id'])
    {
        debug ("user has admin rights");
        if (isset($_POST['do_del']))
        {
            debug ("have news to delete");
            exec_query("DELETE FROM ksh_news WHERE id='".mysql_real_escape_string($_POST['id'])."'");
            $content['result'] .= "������� ������� �������";
        }
        else
        {
            debug ("don't have news to delete");
        }

        $content['admin_link'] .= "<p><a href=\"/news/admin/\">���������������� �������</a></p>";
    }

    $result = exec_query("SELECT * FROM ksh_news ORDER BY id DESC LIMIT ".mysql_real_escape_string($config['news']['last_news_qty'])."");

    while ($row = mysql_fetch_array($result))
    {
        debug("show news ".$row['id']);
		if ("" != $row['descr_image'])
			$content['news'][$i]['descr_image'] = stripslashes($row['descr_image']);
		else $content['news'][$i]['descr_image'] = "";

	$content['news'][$i]['id'] = stripslashes($row['id']);
	$content['news'][$i]['name'] = stripslashes($row['name']);
        $content['news'][$i]['date'] = format_date(stripslashes($row['date']), "ru");
	$content['news'][$i]['descr'] = stripslashes($row['descr']);
	$content['news'][$i]['full_text'] = stripslashes($row['full_text']);
	if ("" == $row['url'])
		$content['news'][$i]['url'] = "	/news/view/".$row['id'].".html";
	else
		$content['news'][$i]['url'] = stripslashes($row['url']);


        if (1 == $user['id'])
            $content['news'][$i]['edit_link'] = "<a href=\"/news/edit/".$row['id']."\">�������������</a>&nbsp;<a href=\"/news/del/".$row['id']."\">�������</a>";
        else $content['news'][$i]['edit_link'] = "";
		$i++;
    }
    mysql_free_result($result);

    debug ("*** end: news_frontpage");
    return $content;
}


function news_default_action()
{
	global $config;
	global $user;

	debug("<br>=== mod: news ===");

	$content = "";

	if (isset($config['news']['page_tpl']) && "" != $config['news']['page_tpl'])
		$config['themes']['page_tpl'] = $config['news']['page_tpl'];

	if (isset($config['news']['menu_tpl']) && "" != $config['news']['menu_tpl'])
		$config['themes']['menu_tpl'] = $config['news']['menu_tpl'];
	
	$config['themes']['page_title']['module'] = "�������";

        if (isset($_GET['action']))
        {
                debug ("*** action: ".$_GET['action']);

				if (isset($_GET['element']))
					$_GET['news'] = $_GET['element'];

                switch ($_GET['action'])
                {
                        default:
							$config['themes']['page_title']['action'] = "�������";
						    $content .= gen_content("news", "frontpage", news_frontpage());
                        break;

                        case "admin":
							$config['themes']['page_title']['action'] = "�����������������";
                            $content .= gen_content("news", "admin", news_admin());
                        break;

                        case "help":
							$config['themes']['page_title']['action'] = "�������";
                            $content .= gen_content("news", "help", news_help());
                        break;

                        case "install_tables":
							$config['themes']['page_title']['action'] = "�������� ������ ��";
                            $content .= gen_content("news", "install_tables", news_install_tables());
                        break;

                        case "drop_tables":
							$config['themes']['page_title']['action'] = "�������� ������ ��";
                            $content .= gen_content("news", "drop_tables", news_drop_tables());
                        break;

                        case "update_tables":
							$config['themes']['page_title']['action'] = "���������� ������ ��";
                            $content .= gen_content("news", "update_tables", news_update_tables());
                        break;

                        case "view_categories":
							$config['themes']['page_title']['action'] = "�������� ���������";
                            $content .= gen_content("news", "categories_view", news_categories_view());
                        break;

                        case "add_category":
							$config['themes']['page_title']['action'] = "���������� ���������";
                            $content .= gen_content("news", "categories_add", news_categories_add());
                        break;

                        case "del_category":
							$config['themes']['page_title']['action'] = "�������� ���������";
                            $content .= gen_content("news", "categories_del", news_categories_del());
                        break;

                        case "add_news":
							$config['themes']['page_title']['action'] = "���������� �������";
                            $content .= gen_content("news", "add", news_add());
                        break;

                        case "view_by_category":
							if (isset($_GET['element']))
								$_GET['category'] = $_GET['element'];
							$config['themes']['page_title']['action'] = "�������� �������� � ���������";
							$content_data = news_view_by_category();
                            $content .= gen_content("news", $config['news']['category_template'], $content_data);
                        break;

                        case "edit":
							$config['themes']['page_title']['action'] = "�������������� �������";
                            $content .= gen_content("news", "edit", news_edit());
                        break;

                        case "del":
							$config['themes']['page_title']['action'] = "�������� �������";
                            $content .= gen_content("news", "del", news_del());
                        break;

                        case "view":
							$config['themes']['page_title']['action'] = "�������� �������";
							$content_data = news_view();
                            $content .= gen_content("news", $config['news']['news_template'], $content_data);
                        break;

                        case "news_archive":
							$config['themes']['page_title']['action'] = "����� ��������";
                            $content .= gen_content("news", "archive", news_archive());
                        break;

                        case "category_edit":
							$config['themes']['page_title']['action'] = "�������������� ��������";
                            $content .= gen_content("news", "categories_edit", news_categories_edit());
                        break;

						case "import_rss":
							$config['themes']['page_title']['action'] = "������ �������� �� RSS";
							$content .= gen_content("news", "import_rss", news_import_rss());
						break;
						
						case "import_xml":
							$config['themes']['page_title']['action'] = "������ �������� �� XML";
							$content .= gen_content("news", "import_xml", news_import_xml());
						break;
						
						case "rss":
							$config['themes']['page_tpl'] = "rss";
							$content .= gen_content("news", "rss", news_rss());
						break;
                }
        }

        else
        {
                debug ("*** action: default");
				$config['themes']['page_title']['action'] = "�������";
                $content = gen_content("news", "frontpage", news_frontpage());
        }

        debug("=== end: mod: news ===<br>");
        return $content;

}

?>
