<?php

// Functions of db module

function connect_2db($db_user, $db_password, $db_host, $db_name)
{

    global $config;

	debug ("*** connect_2db", 2);

	debug ("connecting to db", 2);
	debug ("db user: ".$db_user, 2);
    debug ("db password hash: ".md5($db_password), 2);
	debug ("db host: ".$db_host, 2);
    debug ("db name: ".$db_name, 2);
    
	if (!($config['db']['conn_id'] = @mysqli_connect ($db_host, $db_user, $db_password)))
    {
    	debug ("Cannot connect to database server");
		debug (mysqli_errno($config['db']['conn_id']) . ": " . mysqli_error($config['db']['conn_id']));
        $config['db']['connected'] = "no";
    }
    else
    {
    	debug ("connected to DB server", 2);
        $config['db']['connected'] = "yes";
    
	    if (isset($db_name)) mysqli_select_db ($config['db']['conn_id'], $db_name);

	    debug ("setting right charsets", 2);
		if ("yes" == $config['db']['old_engine'])
			debug ("db engine is too old, don't using charsets", 2);
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
    
	debug ("*** end: connect_2db", 2);
	return 1;
}

function db_exec_query($sql_query)
{
	global $config;
	debug ($sql_query, 2);
    if ("yes" == $config['db']['connected'])
    {
		$result = mysqli_query ($config['db']['conn_id'], $sql_query);
		if (0 == mysqli_errno($config['db']['conn_id']))
			debug ("OK", 2);
		else
			debug ("DB error: ".mysqli_errno($config['db']['conn_id']) . ": " . mysqli_error($config['db']['conn_id']));
    }
    else
    {
    	debug ("not connected to DB!");
		$result = "";
    }
	return $result;
}

function exec_query ($sql_query)
{
	$result = db_exec_query($sql_query);
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
			$sql_query = "SELECT count(*) FROM ".db_escape($_POST['search_table'])." WHERE ".db_escape($_POST['search_field'])." LIKE '%".db_escape($_POST['search_string'])."%'";
			$result = exec_query($sql_query);
			$count = mysql_result($result, 0, 0);
			mysql_free_result($result);
			$content['result'] .= "Найдено вхождений: ".$count."";
			
			if (($count > 0) && (isset($_POST['if_replace'])))
			{
				$sql_query = "SELECT id, ".db_escape($_POST['search_field'])." FROM ".db_escape($_POST['search_table'])." WHERE ".db_escape($_POST['search_field'])." LIKE '%".db_escape($_POST['search_string'])."%'";
				$result = exec_query($sql_query);
				while ($row = mysql_fetch_array($result))
				{
					$full_text = str_replace($_POST['search_string'], $_POST['replace_string'], stripslashes($row[$_POST['search_field']]));
					$sql_query = "UPDATE ".db_escape($_POST['search_table'])." SET ".db_escape($_POST['search_field'])." = '".db_escape($full_text)."' WHERE id='".$row['id']."'";
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

function db_field_exists($table, $field)
{
	global $config;
	global $user;
	debug("*** db_field_exists ***");

	$fields = array();

	$sql_query = "SHOW FIELDS IN `".db_escape($table)."`";
	$result = exec_query($sql_query);
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
		$fields[] = stripslashes($row['Field']);		

	dump($fields);

	if (in_array($field, $fields))
	{
		debug("field exists");
		$res = 1;
	}
	else
	{
		debug("field doesn't exist");
		$res = 0;
	}

	mysqli_free_result($result);

	debug("*** end: db_field_exists ***");
	return $res;
}

function db_fields_list($table)
{
	global $config;
	global $user;
	debug("*** db_fields_list ***");

	debug("table: ".$table);

	$fields = array();

	if ("" != $table)
	{
		$i = 0;
		$sql_query = "SHOW FIELDS IN `".db_escape($table)."`";
		$result = exec_query($sql_query);
		while ($row = mysql_fetch_array($result))
		{
			$fields['names'][$i] = stripslashes($row['Field']);
			$fields['types'][$i] = stripslashes($row['Type']);
			$fields['null'][$i] = stripslashes($row['Null']);
			$i++;
		}
		mysql_free_result($result);
	}

	debug("*** end: db_fields_list ***");
	return $fields;
}

if (!function_exists('mysql_real_escape_string'))
{
	debug("function mysql_real_escape_string doesn't exist, defining wrapper", 2);

	function mysql_real_escape_string($string)
	{
		global $config;
		$new_string = mysqli_real_escape_string($config['db']['conn_id'], $string);
		return $new_string;
	}
}

function db_escape($string)
{
	global $config;
	$escaped_string = mysqli_real_escape_string($config['db']['conn_id'], $string);
	return ($escaped_string);
}

function db_get_row($table, $where)
{
	$sql_query = "SELECT * FROM `".db_escape($table)."` WHERE ".$where;
	$result = db_exec_query($sql_query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	return $row;
}

function db_get_row_by_query($sql_query)
{
	$result = db_exec_query($sql_query);
	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	return $row;
}

function db_get_field($table, $field, $where)
{
	$sql_query = "SELECT `".db_escape($field)."` FROM `".db_escape($table)."` WHERE ".$where;

	$row = db_get_row_by_query($sql_query);
	$value = stripslashes($row[$field]);

	return $value;
}

function db_get_count($table, $field = "*", $where = "")
{
	global $config;
	debug("*** db_get_count ***", 2);

	if ($field == "*")
		$ct = "COUNT(".db_escape($field).")";
	else
		$ct = "COUNT(`".db_escape($field)."`)";

	$sql_query = "SELECT ".$ct." FROM `".db_escape($table)."`";
	if ("" != $where)
		$sql_query .= "WHERE ".$where;
	
	$row = db_get_row_by_query($sql_query);
	$count = $row[$ct];
	debug("count: ".$count, 2);

	debug("*** db_get_count ***", 2);
	return $count;
}

?>
