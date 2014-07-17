<?php

// Base functions of the "db" module
debug ("! db module included");

include_once ("replace.php");

function connect_2db($db_user, $db_password, $db_host, $db_name)
{

    global $config;

	debug ("*** connect_2db");

	debug ("connecting to db");
	debug ("db user: ".$db_user);
    debug ("db password hash: ".md5($db_password));
	debug ("db host: ".$db_host);
    debug ("db name: ".$db_name);
    
	if (!($conn_id = @mysql_connect ($db_host, $db_user, $db_password)))
    {
    	debug ("Cannot connect to database server");
		debug (mysql_errno() . ": " . mysql_error());
        $config['db']['connected'] = "no";
    }
    else
    {
    	debug ("connected to DB server");
        $config['db']['connected'] = "yes";
    
	    if (isset($db_name)) mysql_select_db ($db_name);

	    debug ("setting right charsets");
		if ("yes" == $config['db']['old_engine'])
		{
			debug ("db engine is too old, don't using charsets");
		}
		else
		{
			exec_query("SET names 'cp1251'");
			//exec_query("set character_set 'cp1251'");
			exec_query("set character_set_client='cp1251'");
			exec_query("set character_set_results='cp1251'");
			exec_query("set collation_connection='cp1251_general_ci'");
			exec_query("set SESSION collation_connection='cp1251_general_ci'");
			exec_query("set @@session.time_zone = '".$config['db']['timezone']."'");
		}
    }
    
	debug ("*** end: connect_2db");
	return 1;
}

function exec_query ($sql_query)
{
	global $config;
	debug ($sql_query);
    if ("yes" == $config['db']['connected'])
    {
		$result = mysql_query ($sql_query);
		if (0 == mysql_errno()) debug ("OK");
		else
		{
			debug ("Error ".mysql_errno() . ": " . mysql_error());
			debug ("Ошибка при запросе к базе данных");
		}
    }
    else
    {
    	debug ("not connected to DB!");
		$result = "";    	
    }
	return $result;
}

function create_db()
{
	global $tasks_table;

	$queries[] = "create table ".$tasks_table." (
		id int auto_increment primary key,
		user_from int,
		user_to int,
		status tinyint,
		deadline datetime,
		prior tinyint,
		name tinytext,
		descr text
	)";

	$queries_qty = count($queries);
	$content .= "<p>Number of queries to DB: ".$queries_qty."</p>\n<hr>\n";

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
		$content .= "<p>Запросы выполнены</p>";
	}

	return $content;
}

function drop_db()
{
	$result = exec_query ("show tables");
	debug ("*** drop_db");
	while ($row = mysql_fetch_array($result))
	{
		exec_query ("DROP TABLE ".$row['0']);
	}
	mysql_free_result($result);
	$content = "<p>Таблицы БД успешно удалены</p>";
	debug ("*** end: drop_db");
	return $content;
}

function db_admin()
{
		$content = array(
			'content' => ''
		);
        return $content;
}

function db_default_action()
{
	global $user;
	$content = "";
	/*
	$nav_string = "
		<p>
			<a href=\"/index.php?module=db&action=create_db\">Создать БД</a><br>
			<a href=\"/index.php?module=db&action=drop_db\">Удалить БД</a><br>
		</p>
	";
	$content .= $nav_string;
	*/

	debug ("<br>=== mod: db ===");


	if (isset($_GET['action']))
	{
		debug ("have an action");
		switch ($_GET['action'])
		{
			default: break;
			
			case "admin":
				$content .= gen_content("db", "admin", db_admin());
			break;
			
			case "replace":
				$content .= gen_content("db", "replace", db_replace());
			break;
			
			case "create_db": $content .= create_db(); break;
			case "drop_db": $content .= drop_db(); break;
		}
	}
	else
	{
		debug ("don't have any actions, exec default");
	}
	debug ("=== end: mod: db ===<br>");
	return $content;

}

?>
