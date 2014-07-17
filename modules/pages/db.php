<?php

// Database functions of the "pages" module

function pages_gen_create_table_query()
{
	global $user;
	global $config;
	debug ("*** pages_gen_create_table_query ***");

	if ("yes" == $config['db']['old_engine'])
	{
		debug ("db engine is too old, don't using charsets");
		$charset = "";
	}
	else
	{
		debug ("db engine isn't too old, using charsets");
		$charset = " charset='cp1251'";
	}

	/* Creating pages table */

	$sql_query = "CREATE TABLE IF NOT EXISTS `ksh_pages` (
		`id` int auto_increment primary key,
		`category` int,
		`name` tinytext,
		`subcategory` int,
		`position` int,
		`image` tinytext,
		`template` tinytext,
		`menu_template` tinytext
	";

	if (count($config['base']['lang']['list']))
		foreach($config['base']['lang']['list'] as $k => $v)
			$sql_query .= ",`title_".$v."` tinytext,
				`full_text_".$v."` mediumtext,
				`meta_keywords_".$v."` text,
				`meta_description_".$v."` text
			";
	else
		$sql_query .= ",`title` tinytext,
			`full_text` mediumtext,
			`meta_keywords` text,
			`meta_description` text
		";
	$sql_query .= ")".$charset;

	/* End: Creating pages table */


	debug ("*** end: pages_gen_create_table_query ***");
	return $sql_query;
}


function pages_tables_create()
{
	debug ("*** pages_tables_create ***");
	global $config;
    $content = array(
    	'content' => '',
        'result' => '',
        'queries_qty' => ''
    );

	$cat = new Category();
	$result =  $cat -> create_table("ksh_pages_categories");
	$content['result'] .= $result['result'];

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_pages_privileges");
	$content['result'] .= $result['result'];

	$acc = new Access();
	$result =  $acc -> create_table("ksh_pages_access");
	$content['result'] .= $result['result'];

	$queries[] = pages_gen_create_table_query();

	$queries_qty = count($queries);
	$content['queries_qty'] = $queries_qty;

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
		$content['result'] .= "Запросы выполнены";
	}

	debug ("*** end: pages_tables_create ***");        
	return $content;
}

function pages_tables_drop()
{
	debug ("*** pages_tables_drop ***");
    global $config;
    $content = array(
    	'content' => '',
        'result' => ''
    );

    if (isset($_POST['do_drop']))
    {
           debug ("*** drop_db");
           unset ($_POST['do_drop']);

			if (isset($_POST['drop_pages_categories_table']))
			{
				debug ("dropping categories table");
				$cat = new Category();
				$result = $cat -> drop_table("ksh_pages_categories");
				$content['result'] .= $result['result'];
				unset($_POST['drop_pages_categories_table']);
			}
			
			if (isset($_POST['drop_privileges_table']))
			{
				debug ("dropping privileges table");
				$cat = new Privileges();
				$result = $cat -> drop_table("ksh_pages_privileges");
				$content['result'] .= $result['result'];
				unset($_POST['drop_privileges_table']);
			}

			foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
           $content['result'] .= "Таблицы БД успешно удалены";
    }
    debug ("*** end: drop_db");
	debug ("*** end: pages_tables_drop ***");
    return $content;
}

function pages_tables_update()
{
	global $user;
	global $config;
	global $db_name;

	debug ("*** pages_tables_update ***");
    $content = array(
    	'content' => '',
        'result' => '',
        'queries_qty' => ''
    );

	if ("yes" == $config['db']['old_engine'])
	{
		debug ("db engine is too old, don't using charsets");
		$charset = "";
	}
	else
	{
		debug ("db engine isn't too old, using charsets");
		$charset = " charset='cp1251'";
	}


    $queries = array();
    // $queries[] = ""; // Write your SQL queries here

	$tables = array();
	$sql_query = "SHOW TABLES";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$tables[] = stripslashes($row['Tables_in_'.$db_name]);
	mysql_free_result($result);

	debug("tables:", 2);
	dump($tables);

	if (!in_array("ksh_pages_categories", $tables))
	{
		$cat = new Category();
		$cat -> create_table("ksh_pages_categories");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_pages_privileges", $tables))
	{
		$priv = new Privileges();
		$priv -> create_table("ksh_pages_privileges");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_pages_access", $tables))
	{
		$acc = new Access();
		$acc -> create_table("ksh_pages_access");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_pages", $tables))
		$queries[] = pages_gen_create_table_query();

	/* Checking fields in ksh_pages */

	$sql_query = "SHOW FIELDS IN `ksh_pages`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$field_names[$i] = stripslashes($row['Field']);
		$field_types[$i] = stripslashes($row['Type']);
	}
	mysql_free_result($result);

	if (!in_array("subcategory", $field_names))
		$queries[] = "ALTER TABLE `ksh_pages` ADD `subcategory` int";
	if (!in_array("image", $field_names))
		$queries[] = "ALTER TABLE `ksh_pages` ADD `image` tinytext";
	if (!in_array("position", $field_names))
		$queries[] = "ALTER TABLE `ksh_pages` ADD `position` int";

	foreach ($config['base']['lang']['list'] as $k => $v)
	{
		if (!in_array("title_".$v, $field_names))
			$queries[] = "ALTER TABLE `ksh_pages` ADD `title_".$v."` tinytext";
		if (!in_array("full_text_".$v, $field_names))
			$queries[] = "ALTER TABLE `ksh_pages` ADD `full_text_".$v."` mediumtext";
		if (!in_array("meta_keywords_".$v, $field_names))
			$queries[] = "ALTER TABLE `ksh_pages` ADD `meta_keywords_".$v."` text";
		if (!in_array("meta_description_".$v, $field_names))
			$queries[] = "ALTER TABLE `ksh_pages` ADD `meta_description_".$v."` text";
	}

	/* End: Checking fields in ksh_pages */

    $queries_qty = count($queries);
    $content['queries_qty'] = $queries_qty;

    if ($queries_qty > 0)
    {
        foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
        $content['result'] .= "Запросы выполнены";
    }
	debug ("*** pages_tables_update ***");        
    return $content;
}

?>
