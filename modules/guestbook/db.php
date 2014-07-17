<?php

// Database functions of the "guestbook" module

function guestbook_tables_create()
{
	debug ("*** guestbook_tables_create ***");
	global $config;
    $content = array(
    	'content' => '',
        'result' => '',
        'queries_qty' => ''
    );

	$cat = new Category();
	$result =  $cat -> create_table("ksh_guestbook_categories");
	$content['result'] .= $result['result'];

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

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_guestbook_privileges");

	$queries[] = "INSERT INTO `ksh_guestbook_privileges`
		(`action`, `type`, `id`, `read`, `write`)
		VALUES
		('add', 'group', '0', '1', '1')";

	$content['result'] .= $result['result'];

	$queries[] = "create table if not exists `ksh_guestbook` (
		`id` int auto_increment primary key,
		`category` int,
		`title` tinytext,
		`text` text,
		`user` int,
		`name` tinytext,
		`contact` tinytext,
		`datetime` datetime
	)".$charset;

	$queries_qty = count($queries);
	$content['queries_qty'] = $queries_qty;

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
		$content['result'] .= "Запросы выполнены";
	}
	debug ("*** end: guestbook_tables_create ***");        
	return $content;
}

function guestbook_tables_drop()
{
	debug ("*** guestbook_tables_drop ***");
    global $config;
    $content = array(
    	'content' => '',
        'result' => ''
    );

    if (isset($_POST['do_drop']))
    {
           debug ("*** drop_db");
           unset ($_POST['do_drop']);

			if (isset($_POST['drop_categories_table']))
			{
				debug ("dropping categories table");
				$cat = new Category();
				$result = $cat -> drop_table("ksh_guestbook_categories");
				$content['result'] .= $result['result'];
				unset($_POST['drop_categories_table']);
			}

			if (isset($_POST['drop_privileges_table']))
			{
				debug ("dropping privileges table");
				$cat = new Privileges();
				$result = $cat -> drop_table("ksh_guestbook_privileges");
				$content['result'] .= $result['result'];
				unset($_POST['drop_privileges_table']);
			}

           foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
           $content['result'] .= "Таблицы БД успешно удалены";
    }
    debug ("*** end: drop_db");
	debug ("*** end: guestbook_tables_drop ***");
    return $content;
}

function guestbook_tables_update()
{
	debug ("*** guestbook_tables_update ***");
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

	$version = modules_get_version("guestbook");

 	if ($version < 0.2)
		// $queries[] = ""; // Write your SQL queries here

    $queries_qty = count($queries);
    $content['queries_qty'] = $queries_qty;

    if ($queries_qty > 0)
    {
        foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
        $content['result'] .= "Запросы выполнены";
    }
	debug ("*** guestbook_tables_update ***");        
    return $content;
}

?>
