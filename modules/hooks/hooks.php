<?php

function hooks_add()
{
    debug ("*** hooks_add ***");
    global $config;
    global $user;
    $content = array(
    	'content' => '',
        'to_module' => '',
        'to_type' => '',
        'to_id' => '',
        'hook_module' => '',
        'hook_type' => '',
        'hook_id' => '',
		'categories_select' => array(),
		'name' => '',
		'title' => '',
		'category' => ''
    );

    if (isset($_POST['do_add']))
    {
        debug ("have data to insert into DB");
        unset ($_POST['do_add']);
        exec_query("INSERT INTO ksh_hooks (
			`category`,
			`name`,
			`title`,
			`hook_module`,
			`hook_type`,
			`hook_id`,
			`to_module`,
			`to_type`,
			`to_id`
			) values (
			'".mysql_real_escape_string($_POST['category'])."',
			'".mysql_real_escape_string($_POST['name'])."',
			'".mysql_real_escape_string($_POST['title'])."',
			'".mysql_real_escape_string($_POST['hook_module'])."',
			'".mysql_real_escape_string($_POST['hook_type'])."',
			'".mysql_real_escape_string($_POST['hook_id'])."',
			'".mysql_real_escape_string($_POST['to_module'])."',
			'".mysql_real_escape_string($_POST['to_type'])."',
			'".mysql_real_escape_string($_POST['to_id'])."'
			)");
    }
    else
        debug ("don't have data to insert into DB");

	if (isset($_GET['element']))
		$category_id = $_GET['element'];
	if (isset($_GET['category']))
		$category_id = $_GET['category'];
	if (isset($_POST['category']))
		$category_id = $_POST['category'];

	$cat = new Category();
	$content['categories_select'] = $cat -> get_select("ksh_hooks_categories", $category_id);
	
	$content['category'] = $category_id;
    if (isset($_GET['to_module'])) $content['to_module'] = $_GET['to_module'];
    if (isset($_GET['to_type'])) $content['to_type'] = $_GET['to_type'];
    if (isset($_GET['to_id'])) $content['to_id'] = $_GET['to_id'];
    if (isset($_GET['hook_module'])) $content['hook_module'] = $_GET['hook_module'];
    if (isset($_GET['hook_type'])) $content['hook_type'] = $_GET['hook_type'];
    if (isset($_GET['hook_id'])) $content['hook_id'] = $_GET['hook_id'];


    return $content;
    debug ("*** end: hook_add ***");
}

function hooks_del()
{
    debug ("*** hooks_del ***");
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
        $result = exec_query("SELECT * FROM ksh_hooks WHERE id='".mysql_real_escape_string($_GET['element'])."'");
        $hook = mysql_fetch_array($result);
        mysql_free_result($result);

        $content['id'] = stripslashes($hook['id']);
        $content['title'] = stripslashes($hook['title']);
    }
    else
    {
        debug ("user doesn't have admin rights!");
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    debug ("*** end: hooks_del ***");
    return $content;
}

function hooks_edit()
{
    debug ("*** hooks_edit ***");
    global $user;
    global $config;
    $content = array(
    	'content' => '',
        'id' => '',
		'hook_module' => '',
		'hook_type' => '',
		'hook_id' => '',
		'to_module' => '',
		'to_type' => '',
		'to_id' => '',
		'name' => '',
		'title' => '',
		'categories_select' => array()
    );

    if (1 == $user['id'])
    {
        $hook_id = 0;
		if (isset($_GET['hook']))
			$hook_id = $_GET['hook'];
		if (isset($_GET['element']))
			$hook_id = $_GET['element'];
        if (isset($_POST['id']))
			$hook_id = $_POST['id'];

        if (isset($_POST['do_update']))
        {
            debug ("have data to insert into DB");
            unset ($_POST['do_update']);
            exec_query("UPDATE ksh_hooks set 
				`category` = '".mysql_real_escape_string($_POST['category'])."',
				`name` = '".mysql_real_escape_string($_POST['name'])."',
				`title` = '".mysql_real_escape_string($_POST['title'])."',
				hook_module = '".mysql_real_escape_string($_POST['hook_module'])."',
				hook_type = '".mysql_real_escape_string($_POST['hook_type'])."',
				hook_id = '".mysql_real_escape_string($_POST['hook_id'])."',
				to_module = '".mysql_real_escape_string($_POST['to_module'])."',
				to_type = '".mysql_real_escape_string($_POST['to_type'])."',
				to_id = '".mysql_real_escape_string($_POST['to_id'])."'
				WHERE id='".$hook_id."'");
        }
        else
        {
            debug ("don't have data to insert into DB");
        }

        $result = exec_query("SELECT * FROM ksh_hooks WHERE id='".mysql_real_escape_string($hook_id)."'");
        $hook = mysql_fetch_array($result);
        mysql_free_result($result);

		$cat = new Category();
		$content['categories_select'] = $cat -> get_select("ksh_hooks_categories", stripslashes($hook['category']));

		$content['category'] = stripslashes($hook['category']);
        $content['id'] .= stripslashes($hook['id']);
        $content['name'] .= stripslashes($hook['name']);
        $content['title'] .= htmlspecialchars(stripslashes($hook['title']));
		$content['hook_module'] .= stripslashes($hook['hook_module']);
		$content['hook_type'] .= stripslashes($hook['hook_type']);
		$content['hook_id'] .= stripslashes($hook['hook_id']);
		$content['to_module'] .= stripslashes($hook['to_module']);
		$content['to_type'] .= stripslashes($hook['to_type']);
		$content['to_id'] .= stripslashes($hook['to_id']);
    }
    else
    {
        $content['content'] .= "Пожалуйста, войдите в систему как администратор";
    }

    return $content;
    debug ("*** end: hooks_edit ***");
}

function hooks_list()
{
	debug ("*** hooks_list ***");
    global $config;
    $hooks = array();

    $result = exec_query("SELECT * FROM ksh_hooks ORDER BY id ASC");
    while ($row = mysql_fetch_array($result))
        $hooks[] = $row;
    mysql_free_result($result);
    debug ("*** end: hooks_list ***");
    return $hooks;
}

function hooks_list_view()
{
        debug ("*** hooks_list_view ***");
        global $config;
        global $user;
        $content = array(
        	'content' => '',
            'hooks' => ''
        );
        $i = 0;

		if (1 == $user['id'])
		{
			debug ("user has admin rights");
			if (isset($_POST['do_del']))
			{
				exec_query("DELETE FROM ksh_hooks WHERE id='".stripslashes($_POST['id'])."'");
				$content['content'] .= "Привязка успешно удалена";
			}
		}
        $hooks = hooks_list();

		if (0 == count($hooks))
			$content['content'] .= "Привязок нет";
		else
		{
        	foreach ($hooks as $k => $v)
        	{
            	$content['hooks'][$i]['id'] = stripslashes($v['id']);
				$content['hooks'][$i]['hook_module'] = stripslashes($v['hook_module']);
				$content['hooks'][$i]['hook_type'] = stripslashes($v['hook_type']);
				$content['hooks'][$i]['hook_id'] = stripslashes($v['hook_id']);

				switch (stripslashes($v['hook_type']))
				{
					default:
						$table = "ksh_".stripslashes($v['hook_module']);
					break;
					case 'category':
						$table = "ksh_".stripslashes($v['hook_module'])."_categories";
					break;
				}
				$content['hooks'][$i]['hook_name'] = mysql_result(exec_query("SELECT name FROM ".$table." WHERE id='".stripslashes($v['hook_id'])."'"), 0, 0);

				$content['hooks'][$i]['to_module'] = stripslashes($v['to_module']);
				$content['hooks'][$i]['to_type'] = stripslashes($v['to_type']);
				$content['hooks'][$i]['to_id'] = stripslashes($v['to_id']);

				switch (stripslashes($v['to_type']))
				{
					default:
						$table = "ksh_".stripslashes($v['to_module']);
					break;
					case 'category':
						$table = "ksh_".stripslashes($v['to_module'])."_categories";
					break;
				}
				$content['hooks'][$i]['to_name'] = mysql_result(exec_query("SELECT name FROM ".$table." WHERE id='".stripslashes($v['to_id'])."'"), 0, 0);

                if (1 == $user['id'])
                {
                	$content['hooks'][$i]['edit_link'] = "<a href=\"/index.php?module=hooks&action=edit&hook=".$v['id']."\">";
                    $content['hooks'][$i]['edit_link_end'] = "</a>";
                }
                else
                {
                	$content['hooks'][$i]['edit_link'] = "";
                    $content['hooks'][$i]['edit_link_end'] = "";
                }
				$i++;
        	}
		}

        debug ("*** end: hooks_list_view");

        return $content;
}

function hooks_get_hook ($category_name)
{
	global $config;
	global $user;
	debug ("=== hooks: get_hook ===");
	debug ("category name: ".$category_name);
	$content = "";

	$sql_query = "SELECT `id` FROM `ksh_hooks_categories` WHERE `name` = '".mysql_real_escape_string($category_name)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	$category_id = stripslashes($row['id']);
	debug ("category id: ".$category_id);

	debug ("current module: ".$config['modules']['current_module']);
	debug ("current category: ".$config['modules']['current_category']);
	debug ("current id: ".$config['modules']['current_id']);

	$sql_query = "SELECT * FROM `ksh_hooks` WHERE 
		`category` = '".mysql_real_escape_string($category_id)."'
		AND `to_module` = '".mysql_real_escape_string($config['modules']['current_module'])."'
		AND `to_type` = 'element'
		AND `to_id` = '".mysql_real_escape_string($config['modules']['current_id'])."'";
	$result = exec_query($sql_query);
	if (mysql_num_rows($result))
	{
		debug ("element has hook, processing");
		$hook = mysql_fetch_array($result);
		mysql_free_result($result);
	}
	else
	{
		debug ("element doesn't has hook, trying categories");
		mysql_free_result($result);

		$category = $config['modules']['current_category'];
		while ($category > 0)
		{
			debug ("category: ".$category);
			$sql_query = "SELECT * FROM `ksh_hooks` WHERE 
				`category` = '".mysql_real_escape_string($category_id)."'
				AND `to_module` = '".mysql_real_escape_string($config['modules']['current_module'])."'
				AND `to_type` = 'category'
				AND `to_id` = '".mysql_real_escape_string($category)."'";
			$result = exec_query($sql_query);
			if (mysql_num_rows($result))
			{
				debug ("category has hook, processing");
				$hook = mysql_fetch_array($result);
				mysql_free_result($result);
				break;
			}
			else
			{
				debug ("category doesn't has hook, trying parent");
				mysql_free_result($result);

				$sql_query = "SELECT * FROM 
					`ksh_".mysql_real_escape_string($config['modules']['current_module'])."_categories` 
					WHERE `id` = '".mysql_real_escape_string($category)."'";
				$result = exec_query($sql_query);
				$cat = mysql_fetch_array($result);
				mysql_free_result($result);
				$category = stripslashes($cat['parent']);
			}
		}
	}

	if (isset($hook))
	{
		$include_path = $config['modules']['location'].$hook['hook_module']."/index.php";
		debug ("including: ".$include_path);
		include_once($include_path);
		$hook_action = stripslashes($hook['hook_module'])."_hook";
		debug ("calling: ".$hook_action.", type: ".stripslashes($hook['hook_type']).", id: ".stripslashes($hook['hook_id']));
		$content = $hook_action(stripslashes($hook['hook_type']), stripslashes($hook['hook_id']));
	}

/*
	$sql_query = "SELECT * FROM `ksh_hooks` WHERE `category` = '".mysql_real_escape_string($category_id)."'";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$hook_module = stripslashes($row['hook_module']);
		$hook_type = stripslashes($row['hook_type']);
		$hook_id = stripslashes($row['hook_id']);
		$to_module = stripslashes($row['to_module']);
		$to_type = stripslashes($row['to_type']);
		$to_id = stripslashes($row['to_id']);

		debug ($hook_module.", ".$hook_type.", ".$hook_id." to ".$to_module.", ".$to_type.", ".$to_id);
		$if_activate = 0;


		if ($to_module == $config['modules']['current_module'] && ($to_type == "category" && $to_id == $config['modules']['current_category']))
		{
			debug ("activating hook");
			$include_path = $config['modules']['location'].$hook_module."/index.php";
			debug ("including: ".$include_path);
			include_once($include_path);
			$hook_action = $hook_module."_hook";
            debug ("calling: ".$hook_action);
            $content = $hook_action($hook_type, $hook_id);
		}
		else if ($to_module == $config['modules']['current_module'] && ($to_type == "element" && $to_id == $config['modules']['current_id']))
		{
			debug ("activating hook");
			$include_path = $config['modules']['location'].$hook_module."/index.php";
			debug ("including: ".$include_path);
			include_once($include_path);
			$hook_action = $hook_module."_hook";
            debug ("calling: ".$hook_action);
            $content = $hook_action($hook_type, $hook_id);
		}

	}
	mysql_free_result($result);
*/	
	debug ("=== end: hooks: get_hook ===");
	return $content;
}


?>
