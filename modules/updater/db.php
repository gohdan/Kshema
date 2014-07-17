<?php

// Database functions of the "updater" module

function updater_tables_create()
{
	global $user;
	global $config;
	debug ("*** updater_tables_create ***");
    $content = array(
        'result' => '',
        'queries_qty' => ''
    );

	$priv = new Privileges();

	if ($priv -> has("updater", "create_tables", "write") || 1 == $user['id'])
	{

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

		$result =  $priv -> create_table("ksh_updater_privileges");
		$content['result'] .= $result['result'];

		$queries_qty = count($queries);
		$content['queries_qty'] = $queries_qty;

		if ($queries_qty > 0)
		{
			foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
			$content['result'] .= "Запросы выполнены";
		}
	}
	else
		$content['result'] .= "Недостаточно прав";

	if ($priv -> has("updater", "admin", "write"))
		$content['show_admin_link'] = "yes";

	debug ("*** end: updater_tables_create ***");        
	return $content;
}

function updater_tables_drop()
{
	debug ("*** updater_tables_drop ***");
    global $config;
    $content = array(
        'result' => '',
		'show_drop_form' => ''
    );

	$priv = new Privileges();
	if ($priv -> has("updater", "admin", "write"))
		$content['show_admin_link'] = "yes";

	if ($priv -> has("updater", "drop_tables", "write"))
	{
		$content['show_drop_form'] = "yes";
	    if (isset($_POST['do_drop']))
	    {
	           debug ("*** drop_db");
	           unset ($_POST['do_drop']);

				if (isset($_POST['drop_privileges_table']))
				{
					debug ("dropping privileges table");
					$cat = new Privileges();
					$result = $cat -> drop_table("ksh_updater_privileges");
					$content['result'] .= $result['result'];
					unset($_POST['drop_privileges_table']);
				}

	           foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
	           $content['result'] .= "Таблицы БД успешно удалены";
	    }
	}
	else
		$content['result'] .= "Недостаточно прав";

    debug ("*** end: drop_db");
	debug ("*** end: updater_tables_drop ***");
    return $content;
}

function updater_tables_update()
{
	debug ("*** updater_tables_update ***");
    $content = array(
        'result' => '',
        'queries_qty' => ''
    );

	$priv = new Privileges();
	if ($priv -> has("updater", "admin", "write"))
		$content['show_admin_link'] = "yes";

	if ($priv -> has("updater", "update_tables", "write"))
	{

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

		$version = modules_get_version("updater");

	 	if ($version < 0.2)
		{
		}

	    $queries_qty = count($queries);
	    $content['queries_qty'] = $queries_qty;

	    if ($queries_qty > 0)
	    {
	        foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
	        $content['result'] .= "Запросы выполнены";
	    }
	}
	else
		$content['result'] .= "Недостаточно прав";

	debug ("*** updater_tables_update ***");        
    return $content;
}

?>
