<?php

class Log
{

function create_table($table_name)
{
	global $config;
	global $user;

	debug ("=== Log: create_table ===");

    $content = array (
        'result' => ''
    );

	if (1 == $user['id'])
	{
		debug ("user is admin");

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
			`id` int auto_increment primary key,
			`module` tinytext,
			`action` tinytext,
			`message` text,
			`user` int,
			`date` date,
			`time` time,
			`hide` enum('0','1')
		)".$charset;

		exec_query($sql_query);
		$content['result'] .= "<p>Таблица журнала успешно создана</p>";
	}
	else
	{
		debug ("user isn't admin!");
		$content['result'] = "<p>Пожалуйста, войдите как администратор</p>";
	}

	debug ("=== end: Log: create_table ===");
	return $content;
}


function add($module, $action, $message, $user_id = 0)
{
	global $user;
	global $config;

	debug("*** Log: add ***");

	debug("module: ".$module);
	debug("action: ".$action);
	debug("message: ".$message);
	debug("user_id: ".$user_id);

	if (!$user_id)
		$user_id = $user['id'];

	$sql_query = "INSERT INTO `ksh_".$module."_log` (`module`, `action`, `message`, `user`, `date`, `time`) VALUES (
		'".mysql_real_escape_string($module)."',
		'".mysql_real_escape_string($action)."',
		'".mysql_real_escape_string($message)."',
		'".mysql_real_escape_string($user_id)."',
		CURDATE(),
		CURTIME()
		)";
	exec_query($sql_query);

	debug("*** End: Log: add ***");
	return $content;
}

function view($module)
{
	global $user;
	global $config;

	debug("*** Log: view ***");

	debug("module: ".$module);

	$i = 0;
	$sql_query = "SELECT * FROM `ksh_".mysql_real_escape_string($module)."_log` WHERE `hide` IS NULL OR `hide` = '0' ORDER BY `id` DESC";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		foreach ($row as $k => $v)
			$content['log_elements'][$i][$k] = stripslashes($v);

		$content['log_elements'][$i]['user_name'] = users_get_name($row['user']);
		$i++;
	}
	mysql_free_result($result);


	debug("*** End: Log: add ***");
	return $content;
}

function hide($module, $id)
{
	global $user;
	global $config;

	debug("*** Log: hide ***");

	debug("module: ".$module);
	debug("id: ".$id);


	$sql_query = "UPDATE `ksh_".mysql_real_escape_string($module)."_log` SET `hide` = '1' WHERE `id` = '".mysql_real_escape_string($id)."'";
	exec_query($sql_query);

	debug("*** End: Log: add ***");
	return $content;
}


}
