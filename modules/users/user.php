<?php

class User
{

var $satellite_id;
var $table;

function __construct()
{
	global $user;
	global $config;
	debug("*** User: constructor ***");

	debug("*** end: User: constructor ***");
}

function add()
{
	global $user;
	global $config;
	debug("*** User: add ***");

	$content = array(
		'result' => '',
		'show_add_form' => '',
		'group' => '',
		'satellite_id' => $this -> satellite_id,
		'groups_select' => ''
	);

	debug("satellite id: ".$this -> satellite_id);

	if (isset($_POST['group']))
		$group = $_POST['group'];
	else if (isset($_GET['element']))
		$group = $_GET['element'];
	else
		$group = 0;

	$content['group'] = $group;
	
	$priv = new Privileges();

	if ($priv -> has("users", "add", "write"))
	{
		debug("user has rights");
		$content['show_add_form'] = "yes";

		$cat = new Category;
		$content['groups_select'] = $cat -> get_select($config['users']['categories_table'], $group);

		if (isset($_POST['do_add']))
		{
			debug("have data to add");

			$password = md5($_POST['login']."\n".$_POST['password']);

			if ($this -> satellite_id)
			{
				debug("sending data to satellite");
				$data_desc = array(
					'login' => 'string',
					'name' => 'string',
					'email' => 'string',
					'group' => 'string',
					'password' => 'string'
				);
				$data = array(
					'login' => $_POST['login'],
					'name' => $_POST['name'],
					'email' => $_POST['email'],
					'group' => $_POST['group'],
					'password' => $password
				);
				$sat = new Satellite();
				$sat -> id = $this -> satellite_id;
				$sat -> send_element($config['users']['table'], "insert", $data, $data_desc);
			}

			$sql_query = "INSERT INTO `".mysql_real_escape_string($this -> table)."` (`login`, `name`, `email`, `group`, `password`) VALUES (
				'".mysql_real_escape_string($_POST['login'])."',
				'".mysql_real_escape_string($_POST['name'])."',
				'".mysql_real_escape_string($_POST['email'])."',
				'".mysql_real_escape_string($_POST['group'])."',
				'".mysql_real_escape_string($password)."'
			)";
			// exec_query($sql_query);
			$content['result'] = "Пользователь добавлен";
		}
	}
	else
		$content['result'] = "Недостаточно прав";

	debug("*** end: Users: add ***");
	return $content;
}

}

?>
