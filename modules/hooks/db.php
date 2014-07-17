<?php

// Database functions of the "hooks" module

function hooks_tables_create()
{
	debug ("*** hooks_tables_create ***");
	global $config;
    $content = array(
    	'content' => '',
        'result' => '',
        'queries_qty' => ''
    );

	$cat = new Category();
	$result =  $cat -> create_table("ksh_hooks_categories");
	$content['result'] .= $result['result'];

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_hooks_privileges");
	$content['result'] .= $result['result'];

	$acc = new Access();
	$result =  $acc -> create_table("ksh_hooks_access");
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

        $queries[] = "create table if not exists ksh_hooks (
                id int auto_increment primary key,
				name tinytext,
				title tinytext,
				category int,
				hook_module tinytext,
				hook_type tinytext,
				hook_id int,
				to_module tinytext,
				to_type tinytext,
				to_id int
        )".$charset;


        $queries_qty = count($queries);
        $content['queries_qty'] = $queries_qty;

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content['result'] .= "Запросы выполнены";
        }
	debug ("*** end: hooks_tables_create ***");
        return $content;
}

function hooks_tables_drop()
{
	debug ("*** hooks_tables_drop ***");
    global $config;
    $content = array(
    	'content' => '',
        'result' => ''
    );

	dump($_POST);

    if (isset($_POST['do_drop']))
    {
           debug ("*** drop_db");
           unset ($_POST['do_drop']);
			
			if (isset($_POST['drop_hooks_categories_table']))
			{
				debug ("dropping categories table");
				$cat = new Category();
				$result = $cat -> drop_table("ksh_hooks_categories");
				$content['result'] .= $result['result'];
				unset($_POST['drop_hooks_categories_table']);
			}
			

           foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
           $content['result'] .= "Таблицы БД успешно удалены";
    }
    debug ("*** end: drop_db");
	debug ("*** end: hooks_tables_drop ***");
    return $content;
}

function hooks_tables_update()
{
	debug ("*** hooks_tables_update ***");
    $content = array(
    	'content' => '',
        'result' => '',
        'queries_qty' => ''
    );

    $queries = array();

	if (!in_array("ksh_hooks_categories", db_tables_list()))
	{
		$cat = new Category();
		$cat -> create_table("ksh_hooks_categories");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_hooks_privileges", $tables))
	{
		$priv = new Privileges();
		$priv -> create_table("ksh_hooks_privileges");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_hooks_access", $tables))
	{
		$acc = new Access();
		$acc -> create_table("ksh_hooks_access");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_hooks", $tables))
        $queries[] = "create table if not exists ksh_hooks (
                id int auto_increment primary key,
				name tinytext,
				title tinytext,
				category int,
				hook_module tinytext,
				hook_type tinytext,
				hook_id int,
				to_module tinytext,
				to_type tinytext,
				to_id int
        )".$charset;



    $queries_qty = count($queries);
    $content['queries_qty'] = $queries_qty;

    if ($queries_qty > 0)
    {
        foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
        $content['result'] .= "Запросы выполнены";
    }
	debug ("*** hooks_tables_update ***");
    return $content;
}

?>
