<?php

// portfolio administration functions of the portfolio module

include_once ($config['modules']['location']."files/index.php"); // to upload pictures

function portfolio($category)
{
    debug("*** portfolio_portfolio ***");
    global $user;
    $content = "";
    $portfolio = 2;

    debug ("category name: ".$category);
    $category_id = mysql_result(exec_query("SELECT id FROM ksh_portfolio_categories WHERE name='".mysql_real_escape_string($category)."'"), 0, 0);
    debug ("category id: ".$category_id);
    $result = exec_query("SELECT * FROM ksh_portfolio WHERE category='".mysql_real_escape_string($category_id)."' ORDER BY id DESC LIMIT ".mysql_real_escape_string($portfolio)."");

    $content .= "<table>";
    while ($row = mysql_fetch_array($result))
    {
        debug("show portfolio ".$row['id']);
        $content .= "<tr><td>
        ";

        if ("" != $row['descr_image']) $content .= "<img src=\"".$row['descr_image']."\" style=\"clear: right; float: left; margin-right: 5px\">";

        $content .= "
                    <a href=\"/index.php?module=portfolio&action=view&portfolio=".$row['id']."\">".$row['date']."</a><br>
                    <a href=\"index.php?module=portfolio&action=view&portfolio=".$row['id']."\">".$row['name']."</a><br>
        ";

        if ("" != $row['descr']) $content .= stripslashes($row['descr']);
        else $content .= substr(stripslashes($row['full_text'], 0, 200))."...";

        $content .= "<br>
                    <span class=\"more\"><a href=\"/index.php?module=portfolio&action=view&portfolio=".$row['id']."\">Подробнее...</a></span>
                </td></tr>
        ";
    }
    mysql_free_result($result);
    $content .= "</table>";

    if (1 == $user['id']) $content .= "<p><a href=\"/index.php?module=portfolio&action=admin\">Администрирование</a></p>";

    return $content;
    debug("*** end: portfolio_portfolio ***");
}

function lastportfolio($category)
{
    debug("*** lastportfolio ***");
    global $user;
    $content = "";
    $portfolio = 3;

    debug ("category name: ".$category);
    $result = exec_query("SELECT * FROM ksh_portfolio ORDER BY id DESC LIMIT ".mysql_real_escape_string($portfolio)."");

    $content .= "<table>";
    while ($row = mysql_fetch_array($result))
    {
        debug("show portfolio ".$row['id']);
        $content .= "<tr><td>
        ";

        if ("" != $row['descr_image']) $content .= "<img src=\"".$row['descr_image']."\" style=\"clear: right; float: left; margin-right: 5px\">";

        $content .= "
                    <a href=\"/index.php?module=portfolio&action=view&portfolio=".$row['id']."\">".$row['date']."</a><br>
                    <a href=\"index.php?module=portfolio&action=view&portfolio=".$row['id']."\">".$row['name']."</a><br>
        ";

        if ("" != $row['descr']) $content .= stripslashes($row['descr']);
        else $content .= substr(stripslashes($row['full_text']), 0, 200)."...";

        $content .= "<br>
                    <span class=\"more\"><a href=\"/index.php?module=portfolio&action=view&portfolio=".$row['id']."\">Подробнее...</a></span>
                </td></tr>
        ";
    }
    mysql_free_result($result);
    $content .= "</table>";

    if (1 == $user['id']) $content .= "<p><a href=\"/index.php?module=portfolio&action=admin\">Администрирование</a></p>";

    return $content;
    debug("*** end: lastportfolio ***");
}

function portfolio_hook()
{
    debug("*** portfolio_hook ***");
    global $user;
    global $config;
    $content = array(
		'hook' => '',
		'show_admin_link' => ''
	);
    $portfolio = 3;

    $result = exec_query("SELECT * FROM ksh_hooks WHERE hook_module='portfolio' AND to_module='".mysql_real_escape_string($config['modules']['current_module'])."' AND to_id='".mysql_real_escape_string($config['modules']['current_id'])."'");
	while ($hook = mysql_fetch_array($result))
	{
		if ("category" == stripslashes($hook['hook_type']))
		{
		    $category = stripslashes($hook['hook_id']);

	    	$categories = exec_query("SELECT * FROM ksh_portfolio WHERE category='".mysql_real_escape_string($category)."' ORDER BY id DESC LIMIT ".mysql_real_escape_string($portfolio)."");

			$i = 0;
	    	while ($row = mysql_fetch_array($categories))
	    	{
	        	debug("show portfolio ".$row['id']);
				$content['hook'][$i]['id'] = stripslashes($row['id']);
				$content['hook'][$i]['name'] = stripslashes($row['name']);
				$content['hook'][$i]['date'] = stripslashes($row['date']);
				$content['hook'][$i]['page_template'] = $config['themes']['page_tpl'];
				$content['hook'][$i]['image'] = stripslashes($row['descr_image']);
				$content['hook'][$i]['descr'] = stripslashes($row['descr']);
				$content['hook'][$i]['short_descr'] = stripslashes($row['short_descr']);
				$i++;
	    	}
	    	mysql_free_result($categories);
		}
		else if ("portfolio" == stripslashes($hook['hook_type']))
		{
		    $id = stripslashes($hook['hook_id']);

	    	$categories = exec_query("SELECT * FROM ksh_portfolio WHERE id='".mysql_real_escape_string($id)."' ORDER BY id DESC LIMIT ".mysql_real_escape_string($portfolio)."");

			$i = 0;
	    	while ($row = mysql_fetch_array($categories))
	    	{
	        	debug("show portfolio ".$row['id']);
				$content['hook'][$i]['id'] = stripslashes($row['id']);
				$content['hook'][$i]['name'] = stripslashes($row['name']);
				$content['hook'][$i]['date'] = stripslashes($row['date']);
				$content['hook'][$i]['page_template'] = $config['themes']['page_tpl'];
				$content['hook'][$i]['image'] = stripslashes($row['descr_image']);
				$content['hook'][$i]['descr'] = stripslashes($row['descr']);
				$content['hook'][$i]['short_descr'] = stripslashes($row['short_descr']);
				$i++;
	    	}
	    	mysql_free_result($categories);
		}

	}
    mysql_free_result($result);

    if (1 == $user['id'])
		$content['show_admin_link'] = "yes";

    debug("*** end: portfolio_hook ***");
    return $content;
}


function portfolio_view_by_category()
{
    debug("*** portfolio_view_by_category ***");
    global $user;
	global $page_title;
    global $config;
	
	$i = 0;

    $category = $_GET['category'];

	$config['modules']['current_category'] = $category;
	
	$result = exec_query ("SELECT * FROM ksh_portfolio_categories WHERE id='".mysql_real_escape_string($category)."'");
	$cat = mysql_fetch_array($result);

    $content['category'] = stripslashes($cat['title']);
	if ("" != $cat['template'])
		$config['portfolio']['category_template'] = stripslashes($cat['template']);
	if ("" != $cat['list_template'])
		$config['portfolio']['portfoliolist_template'] = stripslashes($cat['list_template']);
	if ("" != $cat['page_template'])
		$config['themes']['page_tpl'] = stripslashes($cat['page_template']);
	if ("" != $cat['menu_template'])
		$config['themes']['menu_tpl'] = $cat['menu_template'];


	debug ("page template: ".$config['themes']['page_tpl']);
	debug ("category template: ".$config['portfolio']['category_template']);
	debug ("portfolio list template: ".$config['portfolio']['portfoliolist_template']);	
	debug ("menu template: ".$config['themes']['menu_tpl']);	

    $content = array(
    	'content' => '',
        'result' => '',
        'category' => '',
        $config['portfolio']['portfoliolist_template'] => '',
        'admin_link' => '',
        'edit_link' => '',
        'descr' => ''
    );

	
    if (1 == $user['id'])
    {
        debug ("user has admin rights");
        if (isset($_POST['do_del']))
        {
            debug ("have portfolio to delete");
            exec_query("DELETE FROM ksh_portfolio WHERE id='".mysql_real_escape_string($_POST['id'])."'");
            $content['result'] .= "Успешно удалено";
        }
        else
        {
            debug ("don't have portfolio to delete");
        }

        $content['admin_link'] .= "<a href=\"/index.php?module=portfolio&amp;action=admin\">Администрирование</a><br><a href=\"/index.php?module=portfolio&amp;action=view_categories\">Просмотр всех категорий</a><br><a href=\"/index.php?module=portfolio&amp;action=add_portfolio&amp;category=".$category."\">Добавить портфолио</a>";
		
    }

	// FIXME: Check if there are categories; else user has a warning
    debug ("category name: ".$content['category']);
    $result = exec_query("SELECT * FROM ksh_portfolio WHERE category='".mysql_real_escape_string($category)."' ORDER BY date, id DESC");

    while ($row = mysql_fetch_array($result))
    {
        debug("show portfolio ".$row['id']);

		$content['titles'][$i]['id'] = stripslashes($row['id']);
		$content['titles'][$i]['title'] = stripslashes($row['name']);

		if ("" != $row['descr_image'])
//			$content[$config['portfolio']['portfoliolist_template']][$i]['descr_image'] = "<img src=\"".$row['descr_image']."\">";
			$content[$config['portfolio']['portfoliolist_template']][$i]['descr_image'] = $row['descr_image'];
		else
			$content[$config['portfolio']['portfoliolist_template']][$i]['descr_image'] = "";

		if ($i)
	        $content[$config['portfolio']['portfoliolist_template']][$i]['not_first'] = "yes";
		else
	        $content[$config['portfolio']['portfoliolist_template']][$i]['first'] = "yes";

		$dt = explode("-", $row['date']);
        $content[$config['portfolio']['portfoliolist_template']][$i]['date'] = $dt[2].".".$dt[1].".".$dt[0];
        $content[$config['portfolio']['portfoliolist_template']][$i]['descr'] = stripslashes($row['descr']);
		$content[$config['portfolio']['portfoliolist_template']][$i]['full_text'] = stripslashes($row['full_text']);
        $content[$config['portfolio']['portfoliolist_template']][$i]['id'] = $row['id'];
		$content[$config['portfolio']['portfoliolist_template']][$i]['name'] = stripslashes($row['name']);
		if ("" == $row['url'])
			$content[$config['portfolio']['portfoliolist_template']][$i]['url'] = "	/index.php?module=portfolio&amp;action=view&amp;portfolio=".$row['id'];
		else
			$content[$config['portfolio']['portfoliolist_template']][$i]['url'] = stripslashes($row['url']);


        if (1 == $user['id'])
        {
            $content[$config['portfolio']['portfoliolist_template']][$i]['edit_link'] = "ID: ".$row['id'].". <a href=\"/index.php?module=portfolio&amp;action=edit&amp;portfolio=".$row['id']."\">Редактировать</a>&nbsp;<a href=\"/index.php?module=portfolio&amp;action=del&amp;portfolio=".$row['id']."\">Удалить</a>";
        }
        else
        {
        	$content[$config['portfolio']['portfoliolist_template']][$i]['edit_link'] = "";
        }
        $i++;
    }
    mysql_free_result($result);

	$page_title .= " | ".$content['category'];

    return $content;
    debug("*** end: portfolio_view_by_category ***");
}


function portfolio_view_all()
{
    debug("*** portfolio_view_all ***");
    global $user;
	global $page_title;
    global $config;
	

	debug ("page template: ".$config['themes']['page_tpl']);
	debug ("menu template: ".$config['themes']['menu_tpl']);	

    $content = array(
    	'content' => '',
        'result' => '',
        'category' => '',
        'admin_link' => '',
        'edit_link' => '',
        'descr' => '',
		'categories_titles' => ''
    );
	
    if (1 == $user['id'])
    {
        debug ("user has admin rights");
        if (isset($_POST['do_del']))
        {
            debug ("have portfolio to delete");
            exec_query("DELETE FROM ksh_portfolio WHERE id='".mysql_real_escape_string($_POST['id'])."'");
            $content['result'] .= "Успешно удалено";
        }
        else
            debug ("don't have portfolio to delete");

        $content['admin_link'] .= "<a href=\"/index.php?module=portfolio&amp;action=admin\">Администрирование</a><br><a href=\"/index.php?module=portfolio&amp;action=view_categories\">Просмотр всех категорий</a><br><a href=\"/index.php?module=portfolio&amp;action=add_portfolio&amp;\">Добавить портфолио</a>";
		
	}

	$i = 0;
	   
	$categories = array();
	$sql_query = "SELECT * FROM `ksh_portfolio_categories` ORDER BY `title`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$categories[$i]['id'] = stripslashes($row['id']);
		$categories[$i]['name'] = stripslashes($row['name']);
		$categories[$i]['title'] = stripslashes($row['title']);
		$i++;
	}
	mysql_free_result($result);

	$i = 0;

	foreach($categories as $category_idx => $category)
	{

		$content['categories_titles'][$category_idx]['title'] = $category['title'];
		$content['categories_titles'][$category_idx]['titles'] = "";

		$result = exec_query ("SELECT * FROM ksh_portfolio_categories WHERE id='".mysql_real_escape_string($category['id'])."'");
		$cat = mysql_fetch_array($result);

	    $content['category'] = stripslashes($cat['title']);

	    debug ("category name: ".$content['category']);
	    $result = exec_query("SELECT * FROM ksh_portfolio WHERE category='".mysql_real_escape_string($category['id'])."' ORDER BY date, id DESC");

	    while ($row = mysql_fetch_array($result))
	    {
	        debug("show portfolio ".$row['id']);

			if (isset($title))
				unset($title);
			$title = array(
				'id' => stripslashes($row['id']),
				'title' => stripslashes($row['name'])
			);

			$content['categories_titles'][$category_idx]['titles'] .= gen_content("portfolio", "list_titles", $title);

			

			if ("" != $row['descr_image'])
				$content['portfolio'][$i]['descr_image'] = $row['descr_image'];
			else
				$content['portfolio'][$i]['descr_image'] = "";

			if (isset($_GET['portfolio']))
			{
				if (stripslashes($row['id']) == $_GET['portfolio'])
		        	$content['portfolio'][$i]['first'] = "yes";
				else
		    	    $content['portfolio'][$i]['not_first'] = "yes";
			}
			else
			{
				if (!$i)
			        $content['portfolio'][$i]['first'] = "yes";
				else
		    	    $content['portfolio'][$i]['not_first'] = "yes";
			}

			$dt = explode("-", $row['date']);
	        $content['portfolio'][$i]['date'] = $dt[2].".".$dt[1].".".$dt[0];
	        $content['portfolio'][$i]['descr'] = stripslashes($row['descr']);
			$content['portfolio'][$i]['full_text'] = stripslashes($row['full_text']);
	        $content['portfolio'][$i]['id'] = $row['id'];
			$content['portfolio'][$i]['name'] = stripslashes($row['name']);
			if ("" == $row['url'])
				$content['portfolio'][$i]['url'] = "	/index.php?module=portfolio&amp;action=view&amp;portfolio=".$row['id'];
			else
				$content['portfolio'][$i]['url'] = stripslashes($row['url']);


	        if (1 == $user['id'])
	            $content['portfolio'][$i]['edit_link'] = "ID: ".$row['id'].". <a href=\"/index.php?module=portfolio&amp;action=edit&amp;portfolio=".$row['id']."\">Редактировать</a>&nbsp;<a href=\"/index.php?module=portfolio&amp;action=del&amp;portfolio=".$row['id']."\">Удалить</a>";
	        else
	        	$content[$config['portfolio']['portfoliolist_template']][$i]['edit_link'] = "";
	        $i++;
	    }
	    mysql_free_result($result);
	}

    return $content;
    debug("*** end: portfolio_view_all ***");
}

function portfolio_add()
{
    debug ("*** portfolio_add ***");
    global $config;
    global $user;

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    if (isset($_FILES['image'])) $image = $_FILES['image'];
    $if_file_exists = 0;
    $file_path = "";

    $content = array (
    	'content' => '',
        'result' => '',
        'categories_select' => '',
        'date' => ''
    );

    $content['date'] = date("Y-m-d");

    $i = 0;
    $result = exec_query("SELECT * FROM ksh_portfolio_categories");
    while ($category = mysql_fetch_array($result))
    {
        debug ("show category ".$category['id']);
        $content['categories_select'][$i]['id'] = $category['id'];
        $content['categories_select'][$i]['name'] = $category['name'];
        $content['categories_select'][$i]['title'] = $category['title'];
        if (((isset($_GET['category'])) && ($category['id'] == $_GET['category'])) || ((isset($_POST['category'])) && ($category['id'] == $_POST['category'])))
			$content['categories_select'][$i]['selected'] = " selected";
        else
			$content['categories_select'][$i]['selected'] = "";
        $i++;
    }
    mysql_free_result($result);

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");

                if ((isset($image)) && ("" != $image['name']))
                {
                    debug ("there is an image to upload");
                    if (file_exists($doc_root.$upl_pics_dir."portfolio/".$image['name'])) $if_file_exists = 1;
                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."portfolio/",$if_file_exists);
                    debug ("size: ".filesize($home.$file_path));

                    if (filesize($home.$file_path) > $max_file_size)
                    {
                        debug ("file size > max file size!");
                        $content .= "<p>Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт</p>";
                        if (unlink ($home.$file_path)) debug ("file deleted");
                        else debug ("can't delete file!");
                        $file_path = "";
                    }

                    $_POST['image'] = $file_path;

                }
                else
                {
                    debug ("no image to upload");
                    if (isset($_POST['image']))
                    	$file_path = $_POST['image'];
                    else
                    	$file_path = "";
                }


        if (isset($_POST['do_add']))
        {
            debug ("have data to add");
            if ("" != $_POST['name'])
            {
                debug ("portfolio name isn't empty");
                exec_query("INSERT INTO ksh_portfolio (name, category, short_descr, descr, descr_image, full_text, date) VALUES ('".mysql_real_escape_string($_POST['name'])."','".mysql_real_escape_string($_POST['category'])."','".mysql_real_escape_string($_POST['short_descr'])."','".mysql_real_escape_string($_POST['descr'])."','".mysql_real_escape_string($file_path)."','".mysql_real_escape_string($_POST['full_text'])."', '".mysql_real_escape_string($_POST['date'])."')");
                $content['result'] .= "Добавлено";
            }
            else
            {
                debug ("portfolio name is empty");
                $content['result'] .= "Пожалуйста, задайте название";
            }
        }
        else
        {
            debug ("no data to add");
        }
    }
    else
    {
        debug ("user isn't admin");
        $content['content'] = "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: portfolio_add ***");
    return $content;
}

function portfolio_edit()
{
    debug ("*** portfolio_edit ***");
    global $config;
    global $user;

    global $upl_pics_dir;
    global $doc_root;
    global $max_file_size;
    global $home;

    $content = array(
    	'content' => '',
        'result' => '',
        'categories' => '',
        'id' => '',
        'name' => '',
        'date' => '',
		'short_descr' => '',
        'descr' => '',
        'full_text' => '',
        'image' => ''
    );

    if (isset($_FILES['image']))
    {
        debug ("have an image!");
        $image = $_FILES['image'];
    }
    else debug ("don't have an image!");
    $if_file_exists = 0;
    $file_path = "";

    if (isset($_GET['portfolio'])) $portfolio_id =$_GET['portfolio'];
    else if (isset($_POST['id'])) $portfolio_id =$_POST['id'];
    else $portfolio_id =0;
    debug ("portfolio id: ".$portfolio_id);

    debug ("user id: ".$user['id']);
    if (1 == $user['id'])
    {
        debug ("user is admin");
        if (isset($_POST['do_update']))
        {

                if ("" != $image['name'])
                {
                    debug ("there is an image to upload");
                    if (file_exists($doc_root.$upl_pics_dir."portfolio/".$image['name'])) $if_file_exists = 1;
                    $file_path = upload_file($image['name'],$image['tmp_name'],$home,$upl_pics_dir."portfolio/",$if_file_exists);
                    debug ("size: ".filesize($home.$file_path));

                    if (filesize($home.$file_path) > $max_file_size)
                    {
                        debug ("file size > max file size!");
                        $content['content'] .= "Простите, но нельзя закачать файл размером больше ".($max_file_size / 1024)." килобайт";
                        if (unlink ($home.$file_path)) debug ("file deleted");
                        else debug ("can't delete file!");
                        $file_path = $_POST['old_image'];
                    }

                    $_POST['image'] = $file_path;

                }
                else
                {
                    debug ("no image to upload");
                    $file_path = $_POST['old_image'];
                }

        if (isset($_POST['image'])) debug ("POST image: ".$_POST['image']);
        debug ("file path: ".$file_path);

            debug ("have data to update");
            if ("" != $_POST['name'])
            {
                debug ("portfolio name isn't empty");
                exec_query("UPDATE ksh_portfolio set name='".mysql_real_escape_string($_POST['name'])."', date='".mysql_real_escape_string($_POST['date'])."', category='".mysql_real_escape_string($_POST['category'])."',
				short_descr='".mysql_real_escape_string($_POST['short_descr'])."', descr='".mysql_real_escape_string($_POST['descr'])."', descr_image='".mysql_real_escape_string($file_path)."', full_text='".mysql_real_escape_string($_POST['full_text'])."' WHERE id='".mysql_real_escape_string($portfolio_id)."'");
                $content['result'] .= "Изменения записаны";
            }
            else
            {
                debug ("portfolio name is empty");
                $content['result'] .= "Пожалуйста, задайте название";
            }
        }
        else
        {
            debug ("no data to update");
        }

            $result = exec_query("SELECT * FROM ksh_portfolio WHERE id='".mysql_real_escape_string($portfolio_id)."'");
            $portfolio = mysql_fetch_array($result);
            mysql_free_result($result);
            $content['name'] = stripslashes($portfolio['name']);
            $content['date'] = stripslashes($portfolio['date']);
			$content['short_descr'] = stripslashes($portfolio['short_descr']);
            $content['descr'] = stripslashes($portfolio['descr']);
            $content['image'] = stripslashes($portfolio['descr_image']);
            $content['full_text'] = htmlspecialchars(stripslashes($portfolio['full_text']));
            $content['id'] = stripslashes($portfolio['id']);

            $result = exec_query("SELECT * FROM ksh_portfolio_categories");

            $i = 0;
            while ($category = mysql_fetch_array($result))
            {
		        debug ("show category ".$category['id']);
		        $content['categories_select'][$i]['id'] = $category['id'];
		        $content['categories_select'][$i]['name'] = $category['name'];
		        $content['categories_select'][$i]['title'] = $category['title'];
		        if ($category['id'] == $portfolio['category'])
                	$content['categories_select'][$i]['selected'] = " selected";
		        else
                	$content['categories_select'][$i]['selected'] = "";
		        $i++;
            }
            mysql_free_result($result);

    }
    else
    {
        debug ("user isn't admin");
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: portfolio_edit ***");
    return $content;
}

function portfolio_del()
{
    debug ("*** portfolio_del ***");
    global $config;
    global $user;

    $content = array(
    	'content' => '',
        'id' => '',
        'name' => '',
        'category_id' => ''
    );

    if (1 == $user['id'])
    {
        debug ("user has admin rights");
        $result = exec_query("SELECT * FROM ksh_portfolio WHERE id='".mysql_real_escape_string($_GET['portfolio'])."'");
        $portfolio = mysql_fetch_array($result);
        mysql_free_result($result);

        $content['id'] = stripslashes($portfolio['id']);
        $content['name'] = stripslashes($portfolio['name']);
        $content['category_id'] = stripslashes($portfolio['category']);
    }
    else
    {
        debug ("user doesn't have admin rights!");
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: portfolio_del ***");
    return $content;
}

function portfolio_view()
{
    debug ("*** portfolio_view ***");
	global $user;
	global $config;

    $content = array(
    	'name' => '',
        'date' => '',
        'descr' => '',
        'full_text' => '',
        'category' => '',
        'category_id' => '',
		'show_previous_portfolio_link' => '',
		'show_next_portfolio_link' => '',
		'if_show_admin_link' => ''
    );

	if (1 == $user['id'])
	{
		$content['if_show_admin_link'] = "yes";
	}

    $result = exec_query("SELECT * FROM ksh_portfolio WHERE id='".mysql_real_escape_string($_GET['portfolio'])."'");
    $portfolio = mysql_fetch_array($result);
    mysql_free_result($result);

    $content['portfolio_qty'] = mysql_result(exec_query("SELECT COUNT(*) FROM ksh_portfolio WHERE category='".$portfolio['category']."'"), 0, 0);

    $content['id'] = stripslashes($portfolio['id']);
    $content['name'] = stripslashes($portfolio['name']);
    $content['date'] = stripslashes($portfolio['date']);
    $content['descr_image'] = stripslashes($portfolio['descr_image']);
    $content['descr'] = stripslashes($portfolio['descr']);
    $content['full_text'] = stripslashes($portfolio['full_text']);
    $content['category'] = stripslashes(mysql_result(exec_query("SELECT title FROM ksh_portfolio_categories WHERE id='".mysql_real_escape_string($portfolio['category'])."'"), 0, 0));
    $content['category_id'] = stripslashes($portfolio['category']);
	
	$previous_portfolio_qty = stripslashes(mysql_result(exec_query("SELECT count(*) FROM ksh_portfolio WHERE category='".$portfolio['category']."' and id < '".$portfolio['id']."'"), 0, 0));
	if ($previous_portfolio_qty > 0)
	{
		$content['show_previous_portfolio_link'] = "yes";
		$content['previous_portfolio_id'] = stripslashes(mysql_result(exec_query("SELECT id FROM ksh_portfolio WHERE category='".$portfolio['category']."' and id < '".$portfolio['id']."' ORDER BY id DESC LIMIT 1"), 0, 0));
		
	}
		
	$next_portfolio_qty = stripslashes(mysql_result(exec_query("SELECT count(*) FROM ksh_portfolio WHERE category='".$portfolio['category']."' and id > '".$portfolio['id']."'"), 0, 0));
	if ($next_portfolio_qty > 0)
	{
		$content['show_next_portfolio_link'] = "yes";
		$content['next_portfolio_id'] = stripslashes(mysql_result(exec_query("SELECT id FROM ksh_portfolio WHERE category='".$portfolio['category']."' and id > '".$portfolio['id']."' ORDER BY id ASC LIMIT 1"), 0, 0));
	}

    $config['modules']['current_id'] = $portfolio['id'];
    $config['modules']['current_category'] = $portfolio['category'];
    $config['modules']['current_title'] = $content['name'];
	
	

	$config['pages']['page_title'] = $content['name'];
	
	$result = exec_query("SELECT * FROM ksh_portfolio_categories WHERE id='".$portfolio['category']."'");
	$category = mysql_fetch_array($result);
	$portfolio_template = stripslashes($category['portfolio_template']);
	debug ("portfolio template: ".$config['portfolio']['portfolio_template']);
	if ("" != $category['page_template'])
		$config['themes']['page_tpl'] = stripslashes($category['page_template']);
	debug ("page template: ".$config['themes']['page_tpl']);
	
	if ("" != $category['portfolio_template'])
		$config['portfolio']['portfolio_template'] = stripslashes($category['portfolio_template']);
	debug ("portfolio view template: ".$config['portfolio']['portfolio_template']);

	if ("" != $category['menu_template'])
		$config['themes']['menu_tpl'] = stripslashes($category['menu_template']);
	debug ("portfolio menu template: ".$config['themes']['menu_tpl']);
	
    debug ("*** end: portfolio_view ***");
    return $content;
}

?>
