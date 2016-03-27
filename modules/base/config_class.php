<?php

class Config
{

var $table;

function create_table()
{
	global $user;
	global $config;
	debug("*** Config: create_table ***");
	$content = array(
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

	$sql_query = "CREATE TABLE IF NOT EXISTS `".mysql_real_escape_string($this -> table)."` (
		`id` int auto_increment primary key,
		`name` tinytext,
		`value` tinytext,
		`descr` tinytext
	)".$charset;

	exec_query($sql_query);
	if (0 == mysql_errno())
		$content['result'] = "Таблица конфига создана успешно";
	else
		$content['result'] = "Не удалось создать таблицу настроек, ошибка базы данных";

	debug("*** end: Config: create_table ***");
	return $content;
}

function edit()
{
	global $user;
	global $config;
	debug("*** Config: edit ***");

	$content = array(
		'module' => $config['modules']['current_module'],
		'satellite_id' => '',
		'config_elements' => ''
	);

	if (isset($_GET['satellite']))
	{
		$satellite = $_GET['satellite'];
		debug("satellite: ".$satellite);
		$content['satellite_id'] = $satellite;
		$sat = new Satellite;
		$sat -> id = $satellite;
		$sat -> url = $sat -> get_url();
	}
	else
		$satellite = 0;

	if (isset($_POST['do_update']))
	{
		if ("" != $_POST['new_name'] && "" != $_POST['new_descr'])
		{
			if ($satellite)
			{
				debug("inserting to satellite");
				$data_desc = array(
					'name' => 'string',
					'value' => 'string',
					'descr' => 'string'
				);
				$data = array(
					'name' => $_POST['new_name'],
					'value' => $_POST['new_value'],
					'descr' => $_POST['new_descr']
				);
				$sat -> send_element($this -> table, "insert", $data, $data_desc);
			}
			else
			{
				debug("deleting from local table");
				$sql_query = "INSERT INTO `".mysql_real_escape_string($this -> table)."` 
					(`name`, `descr`, `value`)
					VALUES (
					'".mysql_real_escape_string($_POST['new_name'])."',
					'".mysql_real_escape_string($_POST['new_descr'])."',
					'".mysql_real_escape_string($_POST['new_value'])."'
					)";
				exec_query($sql_query);
			}
		}


		foreach($_POST['entries'] as $k => $v)
		{
			if ("" == $_POST['name_'.$v] || "" == $_POST['descr_'.$v])
				if ($satellite)
				{
					debug("deleting from satellite");
					$sat -> del_element($this -> table, $v);
				}
				else
				{
					debug("delete from local table");
					$sql_query = "DELETE FROM `".mysql_real_escape_string($this -> table)."` WHERE `id` = '".mysql_real_escape_string($v)."'";
					exec_query($sql_query);
				}
			else
				if ($satellite)
				{
					debug("updating on satellite");
					$data_desc = array(
						'id' => 'string',
						'name' => 'string',
						'value' => 'string',
						'descr' => 'string'
					);
					$data = array(
						'id' => $v,
						'name' => $_POST['name_'.$v],
						'value' => $_POST['value_'.$v],
						'descr' => $_POST['descr_'.$v]
					);
					$sat -> send_element($this -> table, "update", $data, $data_desc);
				}
				else
				{
					debug("updating in local table");
					$sql_query = "UPDATE `".mysql_real_escape_string($this -> table)."` SET
						`name` = '".mysql_real_escape_string($_POST['name_'.$v])."',
						`descr` = '".mysql_real_escape_string($_POST['descr_'.$v])."',
						`value` = '".mysql_real_escape_string($_POST['value_'.$v])."'
						WHERE `id` = '".mysql_real_escape_string($v)."'";
					exec_query($sql_query);
				}
		}
	}

	if (isset($_GET['satellite']))
	{
		debug("getting config from satellite");
		$satellite = $_GET['satellite'];
		debug("satellite: ".$satellite);
		$sat = new Satellite;
		$sat -> id = $satellite;
		$sat -> url = $sat -> get_url();
		$content['config_elements'] = $sat -> get_config($this -> table);
	}
	else
	{
		debug("getting config from database");
		$sql_query = "SELECT * FROM `".mysql_real_escape_string($this -> table)."`";
		$result = exec_query($sql_query);
		$i = 0;
		while ($row = mysql_fetch_array($result))
		{
			$content['config_elements'][$i]['id'] = stripslashes($row['id']);
			$content['config_elements'][$i]['name'] = stripslashes($row['name']);
			if (phpversion() >= 5.4)
				$content['config_elements'][$i]['value'] = htmlspecialchars(stripslashes($row['value']), ENT_QUOTES, $config['base']['output_charset']);
			else
				$content['config_elements'][$i]['value'] = htmlspecialchars(stripslashes($row['value']));
			$content['config_elements'][$i]['descr'] = stripslashes($row['descr']);
			$i++;
		}
		mysql_free_result($result);
	}

	debug("*** end: Config: edit ***");
	return $content;
}

function get()
{
	global $user;
	global $config;
	debug("*** Config: get ***");

	$cnf = array();

	$sql_query = "SELECT * FROM `".mysql_real_escape_string($this -> table)."`";
	$result = exec_query($sql_query);
	$i = 0;
	while ($row = mysql_fetch_array($result))
	{
		$cnf[$i]['id'] = stripslashes($row['id']);
		$cnf[$i]['name'] = stripslashes($row['name']);
		$cnf[$i]['value'] = stripslashes($row['value']);
		$cnf[$i]['descr'] = stripslashes($row['descr']);
		$i++;
	}
	mysql_free_result($result);

	debug("*** end: Config: get ***");
	return $cnf;
}

function get_list()
{
	global $user;
	global $config;
	debug("*** Config: get_list ***");

	$cnf = array();

	$sql_query = "SELECT * FROM `".mysql_real_escape_string($this -> table)."`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$name = stripslashes($row['name']);
		$value = stripslashes($row['value']);
		$cnf[$name] = $value;
	}
	mysql_free_result($result);

	debug("*** end: Config: get_list ***");
	return $cnf;
}

}

?>
