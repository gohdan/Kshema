<?php

// Database functions of the "menu" module

function uploads_tables_create()
{
	debug ("*** uploads_tables_create ***");
	global $config;
    $content = array(
    	'content' => '',
        'result' => '',
        'queries_qty' => ''
    );

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_uploads_privileges");
	$content['result'] .= $result['result'];

	debug ("*** end: uploads_tables_create ***");        
	return $content;
}

function uploads_tables_drop()
{
	debug ("*** uploads_tables_drop ***");
    global $config;
    $content = array(
    	'content' => '',
        'result' => ''
    );

    if (isset($_POST['do_drop']))
    {
           debug ("*** drop_db");
           unset ($_POST['do_drop']);
			
			if (isset($_POST['drop_uploads_privileges_table']))
			{
				debug ("dropping privileges table");
				$cat = new Privileges();
				$result = $cat -> drop_table("ksh_uploads_privileges");
				$content['result'] .= $result['result'];
				unset($_POST['drop_uploads_privileges_table']);
			}

           foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
           $content['result'] .= "Таблицы БД успешно удалены";
    }
    debug ("*** end: drop_db");
	debug ("*** end: menu_tables_drop ***");
    return $content;
}

function uploads_tables_update()
{
	global $user;
	global $config;
	global $db_name;

	debug ("*** uploads_tables_update ***");
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
/*
	$version = modules_get_version("uploads");

	if ($version < 0.1)
	{
		$priv = new Privileges();
		$result =  $priv -> create_table("ksh_uploads_privileges");
		$content['result'] .= $result['result'];
	}
*/
    // $queries[] = ""; // Write your SQL queries here

	$tables = array();
	$sql_query = "SHOW TABLES";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$tables[] = stripslashes($row['Tables_in_'.$db_name]);
	mysql_free_result($result);

	debug("tables:", 2);
	dump($tables);

	if (!in_array("ksh_uploads_privileges", $tables))
	{
		$priv = new Privileges();
		$priv -> create_table("ksh_uploads_privileges");
		$content['result'] .= $result['result'];
	}

	$queries_qty = count($queries);
    $content['queries_qty'] = $queries_qty;

    if ($queries_qty > 0)
    {
        foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
        $content['result'] .= "Запросы выполнены";
    }
	debug ("*** menu_tables_update ***");        
    return $content;
}


?>
