<?php

// Functions of db module

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
			exec_query("SET names '".$config['db']['charset']."'");
			//exec_query("set character_set '".$config['db']['charset']."'");
			exec_query("set character_set_client='".$config['db']['charset']."'");
			exec_query("set character_set_results='".$config['db']['charset']."'");
			exec_query("set collation_connection='".$config['db']['collation']."'");
			exec_query("set SESSION collation_connection='".$config['db']['collation']."'");
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

function db_tables_list()
{
	global $config;
	global $user;
	debug("*** db_tables_list ***");

	$tables = array();

	$sql_query = "SHOW TABLES";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$tables[] = stripslashes($row['Tables_in_'.$config['db']['db_name']]);
	mysql_free_result($result);

	debug("tables:", 2);
	dump($tables);

	debug("*** end: db_tables_list ***");
	return $tables;
}

function db_replace()
{
	debug ("*** db_replace ***");
	global $config;
    global $user;
    $content = array(
    	'content' => '',
		'result' => '',
		'search_string' => '',
		'replace_string' => '',
		'if_replace' => ''
    );
	$count = 0;
	

	if (1 == $user['id'])
	{
		debug ("user has admin rights");
		if (isset($_POST['search_string']))
		{
			$content['search_string'] = $_POST['search_string'];
			$sql_query = "SELECT count(*) FROM ".mysql_real_escape_string($_POST['search_table'])." WHERE ".mysql_real_escape_string($_POST['search_field'])." LIKE '%".mysql_real_escape_string($_POST['search_string'])."%'";
			$result = exec_query($sql_query);
			$count = mysql_result($result, 0, 0);
			mysql_free_result($result);
			$content['result'] .= "Найдено вхождений: ".$count."";
			
			if (($count > 0) && (isset($_POST['if_replace'])))
			{
				$sql_query = "SELECT id, ".mysql_real_escape_string($_POST['search_field'])." FROM ".mysql_real_escape_string($_POST['search_table'])." WHERE ".mysql_real_escape_string($_POST['search_field'])." LIKE '%".mysql_real_escape_string($_POST['search_string'])."%'";
				$result = exec_query($sql_query);
				while ($row = mysql_fetch_array($result))
				{
					$full_text = str_replace($_POST['search_string'], $_POST['replace_string'], stripslashes($row[$_POST['search_field']]));
					$sql_query = "UPDATE ".mysql_real_escape_string($_POST['search_table'])." SET ".mysql_real_escape_string($_POST['search_field'])." = '".mysql_real_escape_string($full_text)."' WHERE id='".$row['id']."'";
					debug ($sql_query);
					exec_query ($sql_query);
					
				}
				mysql_free_result($result);
				$content['result'] .= "Замена произведена успешно.";
			}
		}
		
		if (isset($_POST['replace_string']))
			$content['replace_string'] = $_POST['replace_string'];
		if (isset($_POST['if_replace']))
			$content['if_replace'] = " checked";
		if (isset($_POST['search_table']))
			$content['search_table'] = $_POST['search_table'];
		if (isset($_POST['search_field']))
			$content['search_field'] = $_POST['search_field'];
		
	}
	else
	{
		debug ("user doesn't have admin rights");
		$content['result'] .= "Пожалуйста, войдите на сайт как администратор";
	}
    
	debug ("*** end: db_replace ***");
    return $content;
}

?>
