<?php

// Privileges class

class Privileges
{

function admin()
{
	global $config;
	global $user;
	debug ("=== privileges: admin ===");

	$content = array();

	debug ("=== end: privileges: admin ===");
	return $content;
}

function create_table($table_name)
{
	global $config;
	global $user;

	debug ("=== privileges: create_table ===");

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
		`uid` int auto_increment primary key,
		`action` tinytext,
		`type` tinytext,
		`id` int,
		`read` boolean,
		`write` boolean
	)".$charset;

	exec_query($sql_query);
	$content['result'] .= "<p>Таблица привилегий успешно создана</p>";

	$sql_query = "INSERT INTO `".mysql_real_escape_string($table_name)."` (
		`action`,
		`type`,
		`id`,
		`read`,
		`write`
		) VALUES (
		'default',
		'group',
		'1',
		'1',
		'1'
		)";
	exec_query($sql_query);
	$sql_query = "INSERT INTO `".mysql_real_escape_string($table_name)."` (
		`action`,
		`type`,
		`id`,
		`read`,
		`write`
		) VALUES (
		'default',
		'group',
		'2',
		'1',
		'0'
		)";
	exec_query($sql_query);
	$sql_query = "INSERT INTO `".mysql_real_escape_string($table_name)."` (
		`action`,
		`type`,
		`id`,
		`read`,
		`write`
		) VALUES (
		'default',
		'group',
		'0',
		'1',
		'0'
		)";
	exec_query($sql_query);
	$content['result'] .= "<p>Основные привилегии успешно добавлены</p>";

	debug ("=== end: privileges: create_table ===");
	return $content;
}

function update_table($table_name)
{
	global $config;
	global $user;

	debug ("=== privileges: update_table ===");

    $content = array (
        'result' => ''
    );

	if (1 == $user['id'])
	{
		debug ("user is admin");

		$sql_query = "";
		exec_query($sql_query);
		$content['result'] .= "";
	}
	else
	{
		debug ("user isn't admin!");
		$content['result'] = "<p>Пожалуйста, войдите как администратор</p>";
	}

	debug ("=== end: privileges: update_table ===");
	return $content;
}


function drop_table($table_name)
{
	global $config;
	global $user;

	debug ("=== privileges: drop_table ===");

    $content = array (
        'result' => ''
    );

	if (1 == $user['id'])
	{
		debug ("user is admin");


		$sql_query = "DROP TABLE IF EXISTS `".mysql_real_escape_string($table_name)."`";
		exec_query($sql_query);
		$content['result'] = "<p>Таблица привилегий успешно удалена</p>";
	}
	else
	{
		debug ("user isn't admin!");
		$content['result'] = "<p>Пожалуйста, войдите как администратор</p>";
	}

	debug ("=== end: privileges: drop_table ===");
	return $content;
}

function get ($module, $action, $privilege, $type, $id)
{
	global $user;
	global $config;
	debug ("*** Privileges: get ***", 2);

	debug ("module: ".$module, 2);
	debug ("action: ".$action, 2);
	debug ("privilege: ".$privilege, 2);
	debug ("type: ".$type, 2);
	debug ("id: ".$id,2 );

	$db_tables = array();
	$table = mysql_real_escape_string("ksh_".$module."_privileges");
	$sql_query = "SHOW TABLES";
	$result = exec_query($sql_query);
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
		$db_tables[] = $row[0];
	
	if (in_array($table, $db_tables))
	{
		$where = "`action` = '".mysql_real_escape_string($action)."' 
			AND `type` = '".mysql_real_escape_string($type)."'
			AND `id` = '".mysql_real_escape_string($id)."'";

		$privilege = db_get_field($table, $privilege, $where);
		debug ("privilege: ".$privilege);
	}
	else
	{
		debug("no privileges table, no privilege");
		$privilege = 0;
	}

	debug ("*** END: Privileges: get ***", 2);
	return $privilege;
}

function has($module, $action, $privilege, $user_id = 0)
{
	global $user;
	global $config;
	debug ("*** Privileges: has ***");

	dump($user);

	if (!$user_id)
	{
		$user_id = $user['id'];
		$group_id = $user['group'];
	}
	else
		$group_id = users_get_group($user_id);
	
	$r = 0;

	debug ("module: ".$module);
	debug ("action: ".$action);
	debug ("privilege: ".$privilege);
	debug ("user id: ".$user_id);

	$right = $this -> get ($module, $action, $privilege, "user", $user_id);
	if ("" != $right || NULL != $right)
		$r = $right;
	else
	{
		$right = $this -> get($module, $action, $privilege, "group", $group_id);
		if ("" != $right || NULL != $right)
			$r = $right;
		else
		{
			$right = $this -> get($module, $action, $privilege, "user", 0);
			if ("" != $right || NULL != $right)
				$r = $right;
			else
			{
				$right = $this -> get($module, $action, $privilege, "group", 0);
				if ("" != $right || NULL != $right)
					$r = $right;
				else
				{
					$right = $this -> get($module, "default", $privilege, "user", $user_id);
					if ("" != $right || NULL != $right)
						$r = $right;
					else
					{
						$right = $this -> get($module, "default", $privilege, "group", $group_id);
						if ("" != $right || NULL != $right)
							$r = $right;
						else
						{
							$right = $this -> get($module, "default", $privilege, "user", 0);
							if ("" != $right || NULL != $right)
								$r = $right;
							else
							{
								$right = $this -> get($module, "default", $privilege, "group", 0);
								if ("" != $right || NULL != $right)
									$r = $right;
							}
						}
					}
				}
			}
		}
	}

	debug ("right: ".$r);

	debug ("*** end: users_has_privilege ***");
	return $r;
}

function edit($module = "")
{
	global $user;
	global $config;
	debug("*** edit ***");

	$content = array(
		'module' => $module,
		'privileges' => '',
		'result' => '',
		'show_form' => ''
	);

	debug ("module: ".$module);

	if ("" != $module)
	{

		if ($this -> has($module, "privileges_edit", "write"))
		{
			debug("user has privilege to edit privileges");
			$content['show_form'] = "yes";
			$table = "`".mysql_real_escape_string("ksh_".$module."_privileges")."`";

			if (isset($_POST['do_update']))
			{
				debug("have data to update");
				if (("" != $_POST['action_new']) &&
					("" != $_POST['type_new']) &&
					("" != $_POST['id_new']) &&
					("" != $_POST['read_new'] || "" != $_POST['write_new'])
					)
				{
					debug("have new privilege to insert");
					$sql_query = "INSERT INTO ".$table."
						(`action`, `type`, `id`, `read`, `write`)
						VALUES (
						'".mysql_real_escape_string($_POST['action_new'])."',
						'".mysql_real_escape_string($_POST['type_new'])."',
						'".mysql_real_escape_string($_POST['id_new'])."',
						'".mysql_real_escape_string($_POST['read_new'])."',
						'".mysql_real_escape_string($_POST['write_new'])."'
						)";
					exec_query($sql_query);
				}

				foreach($_POST['entries'] as $k => $v)
				{
					debug("processing row ".$v);
					if ("" == $_POST['action_'.$v])
					{
						$sql_query = "DELETE FROM ".$table." WHERE `uid` = '".mysql_real_escape_string($v)."'";
						exec_query($sql_query);
					}
					else
					{
						$sql_query = "UPDATE ".$table." SET
							`action` = '".$_POST['action_'.$v]."',
							`type` = '".$_POST['type_'.$v]."',
							`id` = '".$_POST['id_'.$v]."',
							`read` = '".$_POST['read_'.$v]."',
							`write` = '".$_POST['write_'.$v]."'
							WHERE `uid` = '".mysql_real_escape_string($v)."'
							";
						exec_query($sql_query);
					}
					
				}
			}

			$sql_query = "SELECT * FROM ".$table;
			$result = exec_query($sql_query);
			$i = 0;
			while ($row = mysql_fetch_array($result))
			{
				$content['privileges'][$i]['uid'] = stripslashes($row['uid']);
				$content['privileges'][$i]['action'] = stripslashes($row['action']);
				$content['privileges'][$i]['type'] = stripslashes($row['type']);
				$content['privileges'][$i]['id'] = stripslashes($row['id']);
				$content['privileges'][$i]['read'] = stripslashes($row['read']);
				$content['privileges'][$i]['write'] = stripslashes($row['write']);

				if ("group" == $row['type'])
					$content['privileges'][$i]['group_selected'] = "yes";
				else if ("user" == $row['type'])
					$content['privileges'][$i]['user_selected'] = "yes";

				if ("1" == $row['read'])
					$content['privileges'][$i]['read_checked'] = "yes";
				if ("1" == $row['write'])
					$content['privileges'][$i]['write_checked'] = "yes";

				$i++;
			}
			mysql_free_result($result);
		}
		else
			$content['result'] = "Недостаточно прав";
	}

	debug("*** end: edit ***");
	return $content;
}


}

?>
