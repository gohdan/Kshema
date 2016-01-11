<?php

// Category class

class Category
{

function create_table($table_name)
{
	global $config;
	global $user;

	debug ("=== category: create_table ===");

    $content = array (
        'result' => ''
    );

	if ("yes" == $config['db']['old_engine'])
	{
		debug ("db engine is too old, don't using charsets");
		$charset = "";
	}
	else
	{
		debug ("db engine isn't too old, using charsets");
		$charset = " charset='utf8'";
	}

	$sql_query = "CREATE TABLE IF NOT EXISTS `".mysql_real_escape_string($table_name)."` (
		`id` int unsigned auto_increment primary key,
		`parent` int,
		`position` int unsigned default '4294967295' not null,
		`name` tinytext,
		`title` tinytext,
		`image` tinytext,
		`h1` tinytext,
		`description` mediumtext,
		`meta_keywords` tinytext,
		`meta_description` tinytext,
		`template` tinytext,
		`list_template` tinytext,
		`element_template` tinytext,
		`page_template` tinytext,
		`menu_template` tinytext
	)".$charset;

	exec_query($sql_query);
	$content['result'] .= "<p>Таблица категорий успешно создана</p>";

	$sql_query = "SELECT COUNT(*) FROM `".mysql_real_escape_string($table_name)."`";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	$rows_qty = $row['COUNT(*)'];
	debug("rows_qty: ".$rows_qty);
	if (!$rows_qty)
	{
		$sql_query = "INSERT INTO `".mysql_real_escape_string($table_name)."` (
			`id`,
			`parent`,
			`position`,
			`name`,
			`title`,
			`menu_template`
			) VALUES (
			'1',
			'0',
			'1',
			'main',
			'Главная',
			'default'
			)";
		exec_query($sql_query);
		$content['result'] .= "<p>Основная категория успешно создана</p>";
	}

	debug ("=== end: category: create_table ===");
	return $content;
}

function update_table($table_name)
{
	global $config;
	global $user;

	debug ("=== category: update_table ===");

    $content = array (
        'result' => ''
    );

	$queries = array();

	if (!in_array($table_name, db_tables_list()))
		$this -> create_table($table_name);
	else
	{
		$fields = db_fields_list($table_name);

		if (!in_array("image", $fields['names']))
		{
			$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` ADD `image` tinytext";
			$content['result'] .= "<p>В таблицу категорий добавлено поле image</p>";
		}

		if (!in_array("position", $fields['names']))
		{
			$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` ADD `position` int unsigned default '4294967295' not null";
			$queries[] = "UPDATE `".mysql_real_escape_string($table_name)."` SET `position` = '4294967295'"; 
			$content['result'] .= "<p>В таблицу категорий добавлено поле position</p>";
		}
		else
		{
			foreach($fields['names'] as $k => $v)
				if ("position" == $v)
				{
					if ("int(11)" == $fields['types'][$k])
					{
						$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` CHANGE `position` `position` int unsigned default '4294967295' not null";
						$queries[] = "UPDATE `".mysql_real_escape_string($table_name)."` SET `position` = '4294967295' WHERE `position` = '0'";
					}
					if ("YES" == $fields['null'][$k])
						$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` CHANGE `position` `position` int unsigned default '4294967295' not null";
				}
		}

		if (!in_array("h1", $fields['names']))
		{
			$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` ADD `h1` tinytext";
			$content['result'] .= "<p>В таблицу категорий добавлено поле h1</p>";
		}

		if (!in_array("description", $fields['names']))
		{
			$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` ADD `description` mediumtext";
			$content['result'] .= "<p>В таблицу категорий добавлено поле description</p>";
		}

		if (!in_array("meta_keywords", $fields['names']))
		{
			$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` ADD `meta_keywords` tinytext";
			$content['result'] .= "<p>В таблицу категорий добавлено поле meta_keywords</p>";
		}

		if (!in_array("meta_description", $fields['names']))
		{
			$queries[] = "ALTER TABLE `".mysql_real_escape_string($table_name)."` ADD `meta_description` tinytext";
			$content['result'] .= "<p>В таблицу категорий добавлено поле meta_description</p>";
		}
	}

	foreach ($queries as $sql_query)
		exec_query ($sql_query);

	debug ("=== end: category: update_table ===");
	return $content;
}


function drop_table($table_name)
{
	global $config;
	global $user;

	debug ("=== category: drop_table ===");

    $content = array (
        'result' => ''
    );

	if (1 == $user['id'])
	{
		debug ("user is admin");


		$sql_query = "DROP TABLE IF EXISTS `".mysql_real_escape_string($table_name)."`";
		exec_query($sql_query);
		$content['result'] = "<p>Таблица категорий успешно удалена</p>";
	}
	else
	{
		debug ("user isn't admin!");
		$content['result'] = "<p>Пожалуйста, войдите как администратор</p>";
	}

	debug ("=== end: category: drop_table ===");
	return $content;
}

function get_category($table_name, $id)
{
	global $user;
	global $config;
	debug ("=== category: get_category ===");

	$content = array();

	$sql_query = "SELECT * FROM `".mysql_real_escape_string($table_name)."` WHERE `id` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);

	foreach($row as $k => $v)
		$content[$k] = stripslashes($v);

	debug ("=== end: category: get_category ===");
	return $content;
}

function get_subcategories($table_name, $parent_id, $subcats = array(), $cur_prefix = "")
{
	global $user;
	global $config;
	debug ("=== category: get_subcategories ===");
	debug ("parent: ".$parent_id);
	dump ($subcats);
	$sql_query = "SELECT * FROM `".mysql_real_escape_string($table_name)."` WHERE `parent` = '".$parent_id."' ORDER BY `position` ASC, `id` ASC";
	$result = exec_query($sql_query);

	while ($row = mysql_fetch_array($result))
	{
		$id = stripslashes($row['id']);
		debug ("processing category ".$id);

		$acc = new Access;
		$module = $config['modules']['current_module'];
		if ($acc -> has($module, "category", $id, "group", $user['group']))
		{
			foreach($row as $k => $v)
				$subcats[$id][$k] = stripslashes($v);

			$subcats[$id]['prefix'] = $cur_prefix;
			$subcats[$id]['chain'] = "";
			$subcats[$id]['module_name'] = $config['modules']['current_module'];
			if (stripslashes($row['id']) == $config['modules']['current_category'])
				$subcats[$id]['current'] = "yes";
			if ("4294967295" == $subcats[$id]['position'])
				$subcats[$id]['position'] = "";

			if (1 == $user['id'])
				$subcats[$id]['show_admin_link'] = "yes";

			$parent = stripslashes($row['parent']);
			while ($parent > 0)
			{
				$sql_query = "SELECT `parent`, `title` FROM `".mysql_real_escape_string($table_name)."` WHERE `id` = '".mysql_real_escape_string($parent)."'";
				$res_parent = exec_query($sql_query);
				$prnt = mysql_fetch_array($res_parent);
				mysql_free_result($res_parent);
				$parent = stripslashes($prnt['parent']);
				//$subcats[$id]['chain'] = stripslashes($prnt['title']).$config['base']['categories']['chain_divider'].$subcats[$id]['chain'];
				$subcats[$id]['chain'] = $config['base']['categories']['list_prefix'].$subcats[$id]['chain'];
			}
		}

		$subcats = $this -> get_subcategories($table_name, $id, $subcats, $cur_prefix.$config['base']['categories']['list_prefix']);

	}
	mysql_free_result($result);

	debug ("=== end: category: get_subcategories ===");
	return $subcats;
}



function view($table_name)
{
	global $config;
	global $user;

	debug ("=== category: view ===");

    $content = array (
        'categories' => array()
    );

	if (1 == $user['id'])
	{
		debug ("user is admin");
		$content['show_admin_link'] = "yes";

	}
	else
	{
		debug ("user isn't admin!");
	}


	$content['categories'] = $this -> get_subcategories($table_name, 0, $content['categories']);
	debug("categories:", 2);
	dump($content['categories']);

	debug ("=== end: category: view ===");
	return $content;
}

function add($table_name)
{
	global $config;
	global $user;

	debug ("=== category: add ===");

    $content = array (
        'result' => '',
		'categories_select' => ''
    );

	if (isset($_POST['do_add_category']))
	{
		if ("" == $_POST['name'])
		{
			$dob = new Dataobject();
			$_POST['name'] = $dob -> generate_unique_name($table_name, $_POST['title']);
		}
		$_POST['name'] = str_replace("/", "", $_POST['name']);

		$fl = new File();
		$_POST['image'] = $fl -> upload("image");

		$fields = "";
		$values = "";
		foreach($_POST as $k => $v)
			if (db_field_exists($table_name, $k))
			{
				if (("position" == $k) && ("" == $v))
						$v = '4294967295';

				$fields .= "`".mysql_real_escape_string($k)."`, ";
				$values .= "'".mysql_real_escape_string($v)."', ";
			}

		$fields = rtrim($fields, ", ");
		$values = rtrim($values, ", ");

		$sql_query = "INSERT INTO `".mysql_real_escape_string($table_name)."` (".$fields.") VALUES (".$values.")";
		exec_query($sql_query);

		$last_id = mysql_insert_id();
		$module = $config['modules']['current_module'];
		$acc = new Access();
		$acc -> add_default($module, "category", $last_id);

		$content['result'] .= "<p>Категория успешно добавлена</p>";
	}

	$parent = 0;
	if (isset($_POST['parent']))
		$parent = $_POST['parent'];

	$content['categories_select'] = $this -> get_select($table_name, $parent);

	debug ("=== end: category: view ===");
	return $content;
}

function del($categories_table, $elements_table, $category_id, $if_del_elements = 0)
{
	global $config;
	global $user;

	debug ("=== category: del ===");

    $content = array (
		'id' => '',
		'title' => '',
        'result' => ''
    );

	if (isset($_POST['do_del_category']))
	{
		$sql_query = "DELETE FROM `".mysql_real_escape_string($categories_table)."` WHERE `id` = '".mysql_real_escape_string($category_id)."'";
		exec_query($sql_query);
		$content['result'] .= "<p>Категория успешно удалена</p>";
	
		if ($if_del_elements)
		{
			$sql_query = "DELETE FROM `".mysql_real_escape_string($elements_table)."` WHERE `category` = '".mysql_real_escape_string($category_id)."'";
			exec_query($sql_query);
			$content['result'] .= "<p>Элементы категории успешно удалены</p>";
		}
	}

	if (!isset($_POST['do_del_category']))
	{
		$sql_query = "SELECT * FROM `".mysql_real_escape_string($categories_table)."` WHERE `id` = '".mysql_real_escape_string($category_id)."'";
		$result = exec_query($sql_query);
		$row = mysql_fetch_array($result);
		mysql_free_result($result);

		$content['id'] = stripslashes($row['id']);
		$content['title'] = stripslashes($row['title']);
	}

	debug ("=== end: category: view ===");
	return $content;
}

function edit($categories_table, $category_id)
{
	global $config;
	global $user;

	debug ("=== category: edit ===");

    $content = array (
        'result' => '',
		'id' => '',
		'name' => '',
		'title' => '',
		'image' => '',
		'template' => '',
		'list_template' => '',
		'element_template' => '',
		'page_template' => '',
		'menu_template' => '',
		'categories_select' => ''
    );

	if (isset($_POST['do_update_category']))
	{
		if ("" == $_POST['name'])
		{
			$dob = new Dataobject();
			$name = $dob -> generate_unique_name($categories_table, $_POST['title']);
		}
		else
			$name = $_POST['name'];
		$name = str_replace("/", "", $name);

		$fl = new File();
		$_POST['image'] = $fl -> upload("image");

		$sql_query = "UPDATE `".mysql_real_escape_string($categories_table)."` SET ";
		foreach($_POST as $k => $v)
			if (db_field_exists($categories_table, $k))
			{
				if (("position" == $k) && ("" == $v))
					$v = '4294967295';
				$sql_query .= "`".mysql_real_escape_string($k)."` = '".mysql_real_escape_string($v)."', ";
			}
		$sql_query = rtrim($sql_query, ", ");
		$sql_query .= " WHERE `id` = '".mysql_real_escape_string($_POST['id'])."'";

		exec_query($sql_query);
		$content['result'] .= "<p>Изменения успешно записаны</p>";
	}

	$sql_query = "SELECT * FROM `".mysql_real_escape_string($categories_table)."` WHERE `id` = '".mysql_real_escape_string($category_id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);

	foreach($row as $k => $v)
		$content[$k] = stripslashes($v);

	if ("4294967295" == $content['position']) // mask default position
		$content['position'] = "";

	$content['categories_select'] = $this -> get_select ($categories_table, stripslashes($row['parent']));

	debug ("=== end: category: edit ===");
	return $content;
}

function get_list($categories_table)
{
	global $user;
	global $config;
	debug ("=== category: get_list ===");

	$list = array ();

	$sql_query = "SELECT * FROM `".mysql_real_escape_string($categories_table)."` ORDER BY `position` ASC, `id` ASC";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$id = stripslashes($row['id']);
		$title = stripslashes($row['title']);
		debug ($id.":".$title);
		$list[$id] = $title;
	}
	mysql_free_result($result);

	debug ("=== end: category: get_list ===");
	return $list;
}

function get_ids($categories_table)
{
	global $user;
	global $config;
	debug ("=== category: get_list ===");

	$list = array ();

	$sql_query = "SELECT `id` FROM `".mysql_real_escape_string($categories_table)."`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$list[] = stripslashes($row['id']);
	mysql_free_result($result);

	debug ("=== end: category: get_list ===");
	return $list;
}

function get_parent($categories_table, $category)
{
	global $user;
	global $config;
	debug ("=== category: get_parent ===");

	debug("categories_table: ".$categories_table);
	debug("category: ".$category);

	$parent = 0;

	$sql_query = "SELECT `parent` FROM `".mysql_real_escape_string($categories_table)."` WHERE `id` = '".mysql_real_escape_string($category)."'";
	$result = exec_query($sql_query);
	if ($result && mysql_num_rows($result))
	{
		$row = mysql_fetch_array($result);
		$parent = stripslashes($row['parent']);
		debug("parent: ".$parent);
	}
	if ($result)
		mysql_free_result($result);


	debug ("=== end: category: get_parent ===");
	return $parent;
}

function get_parents_list($categories_table, $category)
{
	global $user;
	global $config;
	debug ("=== category: get_parents_list ===");

	debug("categories table: ".$categories_table);

	$parents_list = array();
	$parent = 0;

	do
	{
		debug("category: ".$category);
		$parent = $this -> get_parent($categories_table, $category);
		debug("parent: ".$parent);
		$parents_list[] = $parent;
		$category = $parent;
	}
	while ($parent);

	$parents_list = array_reverse($parents_list);
	debug("parents:");
	dump($parents_list);	

	debug ("=== end: category: get_parents_list ===");
	return $parents_list;
}

function get_select($categories_table, $selected = 0)
{
	global $user;
	global $config;
	debug ("=== category: get_select ===");

	debug ("table: ".$categories_table);

	$content = array();

	debug("selected:");
	if (is_array($selected))
		dump($selected);
	else
		debug($selected);

	// $categories = $this -> get_list($categories_table);
		
	// $content['categories'] = $this -> get_subcategories($table_name, 0, $content['categories']);
	$content = $this -> get_subcategories($categories_table, 0, $content);

	dump($content);

	debug("selected:");
	if (is_array($selected))
		dump($selected);
	else
		debug($selected);

	foreach ($content as $k => $v)
	{
		/*
		if ($k == $category_id)
			$content[$k]['selected'] = "selected";
		else
			$content[$k]['selected'] = "";
		*/
		if (is_array($selected))
		{
			debug("checking in array");
			if(in_array($k, $selected))
				$content[$k]['selected'] = "selected";
		}
		else
		{
			debug("comparing ".$k." and ".$selected);			
			if($k == $selected)
				$content[$k]['selected'] = "selected";
			else
				$content[$k]['selected'] = "";
		}
	}

	dump($content);

	debug ("=== end: category: get_select ===");
	return $content;
}

function get_checkboxes($categories_table, $checked_categories = array(), $parent = 0)
{
	global $user;
	global $config;
	debug ("=== category: get_checkboxes ===");

	$content = array();
	dump($checked_categories);

	$content = $this -> get_subcategories($categories_table, $parent, $content);

	dump($content);

	foreach ($content as $k => $v)
	{
		if (is_array($checked_categories) && in_array($k, $checked_categories))
			$content[$k]['checked'] = "checked";
		else
			$content[$k]['checked'] = "";

		if ($this -> has_subcategories($categories_table, $k))
			$content[$k]['check_subcategories'] = "yes";
		else
			$content[$k]['check_subcategories'] = "";

		if (0 != $parent)
			$content[$k]['prefix'] .= $config['base']['categories']['list_prefix'];
	}

	dump($content);

	debug ("=== end: category: get_checkboxes ===");
	return $content;
}

function get_title($categories_table, $id)
{
	global $user;
	global $config;
	debug ("=== category: get_title ===");

	$sql_query = "SELECT `title` FROM `".mysql_real_escape_string($categories_table)."` WHERE `id` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	$title = stripslashes($row['title']);

	debug ("=== end: category: get_title ===");
	return $title;
}

function get_name($categories_table, $id)
{
	global $user;
	global $config;
	debug ("=== category: get_name ===");

	$sql_query = "SELECT `name` FROM `".mysql_real_escape_string($categories_table)."` WHERE `id` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	$name = stripslashes($row['name']);

	debug ("=== end: category: get_name ===");
	return $name;
}

function has_subcategories($categories_table, $id)
{
	global $user;
	global $config;
	debug ("=== category: has_subcategories ===");

	$sql_query = "SELECT COUNT(*) FROM `".mysql_real_escape_string($categories_table)."` WHERE `parent` = '".mysql_real_escape_string($id)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);
	$subcats_qty = stripslashes($row['COUNT(*)']);
	if ($subcats_qty > 0)
		$if_has_subcats = 1;
	else
		$if_has_subcats = 0;

	debug ("=== end: category: has_subcategories ===");
	return $if_has_subcats;
}


function get_categories_list($table_name, $parent = 0, $subcats = array())
{
	global $user;
	global $config;
	debug ("=== category: get_categories_list ===");
	debug ("parent: ".$parent);
	dump ($subcats);
	$sql_query = "SELECT * FROM `".mysql_real_escape_string($table_name)."` WHERE `parent` = '".$parent."' ORDER BY `position` ASC, `id` ASC";
	$result = exec_query($sql_query);

	while ($row = mysql_fetch_array($result))
	{
		$id = stripslashes($row['id']);
		debug ("category: ".$id);
		$subcats[$id] = $id;
		$subcats = $this -> get_categories_list($table_name, $id, $subcats);
	}
	mysql_free_result($result);

	debug ("=== end: category: get_categories_list ===");
	return $subcats;
}

function get_categories_level($table_name, $parent = 0)
{
	global $user;
	global $config;
	debug ("=== category: get_categories_level ===");
	debug ("parent: ".$parent);

	$categories = array();

	$sql_query = "SELECT * FROM `".mysql_real_escape_string($table_name)."` WHERE `parent` = '".$parent."' ORDER BY `position` ASC, `id` ASC";
	$result = exec_query($sql_query);

	while ($row = mysql_fetch_array($result))
	{
		$id = stripslashes($row['id']);
		debug ("category: ".$id);
		$categories[] = $id;
	}
	mysql_free_result($result);

	debug ("=== end: category: get_categories_level ===");
	return $categories;
}

function get_id_by_name($name)
{
	global $user;
	global $config;
	debug("*** Category: get_id_by_name ***");

	debug("name: ".$name);

	$sql_query = "SELECT `id` FROM `".mysql_real_escape_string($this -> table)."` WHERE `name` = '".mysql_real_escape_string($name)."'";
	$result = exec_query($sql_query);
	$row = mysql_fetch_array($result);
	mysql_free_result($result);

	$id = stripslashes($row['id']);
	debug("id: ".$id);

	debug("*** end: Category: get_id_by_name ***");
	return $id;
}



}

?>
