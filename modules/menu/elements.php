<?php

// menu functions of the "menu" module

function get_menu($id, $submenu_id, $submenu_contents)
{
	debug (" === menu: get_menu ===");
	global $user;
	global $config;
	$content = array(
		'elements' => array()
	);
	debug ("id: ".$id);
	debug ("submenu id: ".$submenu_id);

	debug ("getting category");
	$sql_query = "SELECT * FROM `ksh_menu_categories` WHERE `id` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$cat = mysql_fetch_array($result);
	mysql_free_result($result);
	$category['list_template'] = stripslashes($cat['list_template']);
	debug ("category list template: ".$category['list_template']);

	debug ("getting menu entries");
	$sql_query = "SELECT * FROM `ksh_menu` WHERE `category` = '".mysql_real_escape_string($id)."'
		ORDER BY `".mysql_real_escape_string($config['menu']['sort_list_by'])."` ".mysql_real_escape_string($config['menu']['sort_list_mode']);
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		dump($row);
		$id = stripslashes($row['id']);
		debug ("entry ".$id);
		$content['left_elements'][$id]['id'] = stripslashes($row['id']);
		$content['left_elements'][$id]['title'] = stripslashes($row['title']);
		$content['left_elements'][$id]['category'] = stripslashes($row['category']);
		$content['left_elements'][$id]['position'] = stripslashes($row['position']);
		$url = stripslashes($row['url']);
		debug ("element url: ".$url);
		$content['left_elements'][$id]['url'] = htmlspecialchars($url);
		$content['left_elements'][$id]['if_new_window'] = htmlspecialchars($row['if_new_window']);
		$content['left_elements'][$id]['new_window_name'] = uniqid(rand());
		
		debug("current URL: ".$_SERVER["REQUEST_URI"]);
		$submenu = stripslashes($row['submenu']);

		if ($_SERVER['REQUEST_URI'] == $url)
			$content['left_elements'][$id]['active'] = "yes";
		
		if ($submenu_id && $submenu_id == stripslashes($row['submenu']))
		{
			debug ("inserting submenu");
			$content['left_elements'][$id]['submenu'] = $submenu_contents;
		}
		else
			$content['left_elements'][$id]['submenu'] = "";
		
	}
	mysql_free_result($result);
	$cnt = gen_content("menu", $category['list_template'], $content);

	debug ("=== end: menu: get_menu ===");
	return $cnt;
}


function menu_hook($type, $id)
{
    debug("=== menu_hook ===");
    global $user;
    global $config;
    $content = array(
		'elements' => array()
	);

	debug ("type: ".$type);
	debug ("id: ".$id);

	switch ($type)
	{
		default: break;

		case "category":
			$submenu_id = 0;
			while ($id > 0)
			{	
				debug ("getting category ".$id);
				$sql_query = "SELECT * FROM `ksh_menu_categories` WHERE `id` = '".mysql_real_escape_string($id)."'";
				$result = exec_query($sql_query);
				$cat = mysql_fetch_array($result);
				mysql_free_result($result);
				$parent = stripslashes($cat['parent']);
				debug ("title: ".stripslashes($cat['title']));
				debug ("parent: ".$parent);

				$cnt = get_menu($id, $submenu_id, $cnt);
				
				$submenu_id = $id;
				$id = $parent;
			}
		break;

		case "element":
		break;
	}
	
	debug ("content: ".$content);
    debug("=== end: menu_hook ===");
    return $cnt;
}



function menu_add()
{
    debug ("*** menu_add ***");
    global $config;
    global $user;
    $content = array(
    	'content' => ''
    );

	if (isset($_GET['category']))
		$category_id = $_GET['category'];
	else
		$category_id = 0;
	
	$content['category_id'] = $category_id;

	$cat = new Category();
	$content['categories_select'] = $cat -> get_select("ksh_menu_categories", $category_id);

    if (isset($_POST['do_add']))
    {
        debug ("have data to insert into DB");
        unset ($_POST['do_add']);
        exec_query("INSERT INTO `ksh_menu` (`category`, `title`, `position`, `url`, `if_new_window`) values (
			'".mysql_real_escape_string($_POST['category'])."',
			'".mysql_real_escape_string($_POST['title'])."',
			'".mysql_real_escape_string($_POST['position'])."',
			'".mysql_real_escape_string($_POST['url'])."',
			'".mysql_real_escape_string($_POST['if_new_window'])."'
			)");
    }
    else
        debug ("don't have data to insert into DB");


    return $content;
    debug ("*** end: menu_add ***");
}

function menu_del()
{
    debug ("*** menu_del ***");
    global $config;
    global $user;

    $content = array(
    	'content' => '',
        'id' => '',
		'title' => ''
    );

    if (1 == $user['id'])
    {
        debug ("user has admin rights");
        $result = exec_query("SELECT * FROM ksh_menu WHERE id='".mysql_real_escape_string($_GET['page'])."'");
        $page = mysql_fetch_array($result);
        mysql_free_result($result);

        $content['id'] = stripslashes($page['id']);
		$content['title'] = stripslashes($page['title']);
		$content['category_id'] = stripslashes($page['category']);
    }
    else
    {
        debug ("user doesn't have admin rights!");
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: menu_del ***");
    return $content;
}

function menu_edit()
{
    debug ("*** menu_edit ***");
    global $user;
    global $config;
    $content = array(
    	'content' => '',
        'id' => '',
        'name' => '',
        'title' => '',
        'full_text' => '',
        'template' => ''
    );

    if (1 == $user['id'])
    {

        if (isset($_POST['id'])) $page_id = $_POST['id'];
        else if (isset($_GET['page'])) $page_id = $_GET['page'];
        else $page_id = 0;

        if (isset($_POST['do_update']))
        {
            debug ("have data to insert into DB");
            unset ($_POST['do_update']);
            exec_query("UPDATE `ksh_menu` set 
				`category` = '".mysql_real_escape_string($_POST['category'])."',
				`title` = '".mysql_real_escape_string($_POST['title'])."',
				`position` = '".mysql_real_escape_string($_POST['position'])."',
				`url` = '".mysql_real_escape_string($_POST['url'])."',
				`submenu` = '".mysql_real_escape_string($_POST['submenu'])."',
				`if_new_window` = '".mysql_real_escape_string($_POST['if_new_window'])."'
				WHERE `id`='".$page_id."'");
        }
        else
        {
            debug ("don't have data to insert into DB");
        }

        $result = exec_query("SELECT * FROM ksh_menu WHERE id='".mysql_real_escape_string($page_id)."'");
        $page = mysql_fetch_array($result);
        mysql_free_result($result);
        $content['id'] .= stripslashes($page['id']);
        $content['category'] .= stripslashes($page['category']);
        $content['title'] .= htmlspecialchars(stripslashes($page['title']));
        $content['position'] .= htmlspecialchars(stripslashes($page['position']));
        $content['url'] .= htmlspecialchars(stripslashes($page['url']));
        $content['if_new_window'] .= htmlspecialchars(stripslashes($page['if_new_window']));
        $content['submenu'] .= htmlspecialchars(stripslashes($page['submenu']));

		$cat = new Category();
		debug ("getting categories select");
		$content['categories_select'] = $cat -> get_select("ksh_menu_categories", stripslashes($page['category']));
		debug ("getting subcategories select");
		$content['subcategories_select'] = $cat -> get_select("ksh_menu_categories", stripslashes($page['submenu']));

    }
    else
    {
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    return $content;
    debug ("*** end: menu_edit ***");
}

function menu_list()
{
	debug ("*** menu_list ***");
    global $config;
    $menu = array();

    $result = exec_query("SELECT * FROM ksh_menu ORDER BY ".mysql_real_escape_string($config['menu']['sort_list_by'])." ASC");
    while ($row = mysql_fetch_array($result))
        $menu[] = $row;
    mysql_free_result($result);
    debug ("*** end: menu_list ***");
    return $menu;
}

function menu_view_by_category()
{
    debug("*** menu_view_by_category ***");
    global $user;
	global $page_title;
    global $config;
	
    $content = array(
    	'content' => '',
        'result' => '',
        'category' => '',
        'show_admin_link' => '',
        'menu' => ''
    );

	$i = 0;

    $category = $_GET['category'];
	
	$result = exec_query ("SELECT * FROM ksh_menu_categories WHERE id='".mysql_real_escape_string($category)."'");
	$cat = mysql_fetch_array($result);
    $content['category'] = stripslashes($cat['title']);	
	$content['category_id'] = $category;
	mysql_free_result($result);

    if (1 == $user['id'])
    {
        debug ("user has admin rights");
		$content['show_admin_link'] = "yes";

        if (isset($_POST['do_del']))
        {
            debug ("have menu to delete");
            exec_query("DELETE FROM ksh_menu WHERE id='".mysql_real_escape_string($_POST['id'])."'");
            $content['result'] .= "Страница успешно удалена";
        }
        else
        {
            debug ("don't have menu to delete");
        }


    }

	// FIXME: Check if there are categories; else user has a warning
    debug ("category title: ".$content['category']);
    $sql_query = "SELECT * FROM ksh_menu 
		WHERE category='".mysql_real_escape_string($category)."'
		ORDER BY `".mysql_real_escape_string($config['menu']['sort_list_by'])."` ".mysql_real_escape_string($config['menu']['sort_list_mode']);
	$result = exec_query($sql_query);
	$i = 0;
    while ($row = mysql_fetch_array($result))
    {
        debug("show menu ".$row['id']);
        $content['elements'][$i]['id'] = $row['id'];
		$content['elements'][$i]['title'] = stripslashes($row['title']);
		$content['elements'][$i]['position'] = stripslashes($row['position']);
		$content['elements'][$i]['url'] = stripslashes($row['url']);
		$content['elements'][$i]['submenu_id'] = stripslashes($row['submenu']);

		$sql_query = "SELECT `title` FROM `ksh_menu_categories` WHERE `id` = '".$row['submenu']."'";
		$res_title = exec_query($sql_query);
		$submenu = mysql_fetch_array($res_title);
		mysql_free_result($res_title);
		$content['elements'][$i]['submenu_title'] = stripslashes($submenu['title']);

		if (1 == $user['id'])
		{
			$content['elements'][$i]['show_admin_link'] = "yes";
		}
		else
		{
			$content['elements'][$i]['show_admin_link'] = "";
		}

        $i++;
    }
    mysql_free_result($result);

    return $content;
    debug("*** end: menu_view_by_category ***");
}



?>
