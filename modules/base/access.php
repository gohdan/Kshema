<?php

class Access
{


function has ($module, $res_type, $res_id, $subj_type, $subj_id)
{
	global $user;
	global $config;
	debug("*** Access: has ***");

	debug("module: ".$module, 2);
	debug("res_type: ".$res_type, 2);
	debug("res_id: ".$res_id, 2);
	debug("subj_type: ".$subj_type, 2);
	debug("subj_id: ".$subj_id, 2);


	$r = 0;

	$sql_query = "SELECT `subj_id` FROM `ksh_".mysql_real_escape_string($module)."_access` WHERE (
		`res_type` = '".mysql_real_escape_string($res_type)."' AND 
		`res_id` = '".mysql_real_escape_string($res_id)."' AND
		`subj_type` = '".mysql_real_escape_string($subj_type)."'
	)";
	debug("sql query: ".$sql_query);
	$result = exec_query($sql_query);
	if (mysql_num_rows($result))
	{
		$row = mysql_fetch_array($result);
		mysql_free_result($result);

		$subjects = explode("|", stripslashes($row['subj_id']));
		if (in_array($subj_id, $subjects))
			$r = 1;
	}

	debug("access: ".$r);

	debug("*** end: Access: has ***");
	return $r;
}


function edit($module = "")
{
	global $user;
	global $config;
	debug("*** Access: edit ***");

	$content = array(
		'module' => $module,
		'access' => '',
		'result' => '',
		'show_form' => '',
		'access_categories' => ''
	);

	debug ("module: ".$module);

	if ("" != $module)
	{
		$priv = new Privileges;
		if ($priv -> has($module, "access_edit", "write"))
		{
			debug("user has privilege to edit privileges");
			$content['show_form'] = "yes";
			$table = "`".mysql_real_escape_string("ksh_".$module."_access")."`";

			if (isset($_POST['do_update']))
			{
				debug("have data to update");
				debug("POST:", 2);
				dump($_POST);

				foreach($_POST as $k => $v)
				{
					if ("cat" == substr($k, 0, 3))
					{
						$cat_id = substr($k, 4);
						$string = "";
						foreach($v as $idx => $grp)
							if ("-1" != $grp)
								$string .= $grp."|";
						$rights = trim($string, "|");

						$sql_query = "SELECT * FROM `ksh_".mysql_real_escape_string($module)."_access` WHERE (
							`res_type` = 'category' AND 
							`res_id` = '".mysql_real_escape_string($cat_id)."' AND
							`subj_type` = 'group'
							)";
						$result = exec_query($sql_query);
						if (mysql_num_rows($result))
							$type = "update";
						else
							$type = "insert";
						mysql_free_result($result);

						if ("insert" == $type)
							$sql_query = "INSERT INTO `ksh_".mysql_real_escape_string($module)."_access` 
								(`res_type`, `res_id`, `subj_type`, `subj_id`)
								VALUES (
									'category',
									'".mysql_real_escape_string($cat_id)."',
									'group',
									'".mysql_real_escape_string($rights)."'
								)";
						else if ("update" == $type)
							$sql_query = "UPDATE `ksh_".mysql_real_escape_string($module)."_access` 
								SET `subj_id` = '".mysql_real_escape_string($rights)."'
								WHERE 
								`res_type` = 'category' AND 
								`res_id` = '".mysql_real_escape_string($cat_id)."' AND
								`subj_type` = 'group'
								";

						$result = exec_query($sql_query);

					}
				}

			}

			$cat = new Category;
			$res_categories = $cat -> view("ksh_".$module."_categories");
			$categories = $res_categories['categories'];

			debug("categories:", 2);
			dump($categories);

			$groups = array(0 => 'Гости');
			$sql_query = "SELECT * FROM `ksh_users_groups` ORDER BY `id`";
			$result = exec_query($sql_query);
			while ($row = mysql_fetch_array($result))
			{
				$id = stripslashes($row['id']);
				$title = stripslashes($row['title']);
				$groups[$id] = $title;
			}
			mysql_free_result($result);
			
			debug("groups:", 2);
			dump($groups);

			$content['access_categories'] = array();
			foreach($categories as $k => $v)
			{
				$content['access_categories'][$k]['id'] = $v['id'];
				$content['access_categories'][$k]['name'] = $v['name'];
				$content['access_categories'][$k]['title'] = $v['title'];
				$content['access_categories'][$k]['prefix'] = $v['prefix'];
				$content['access_categories'][$k]['agroups'] = "";


				foreach($groups as $gid => $gtitle)
				{
					$ag['cat_id'] = $v['id'];
					$ag['group_id'] = $gid;
					$ag['group_title'] = $gtitle;

					if ($this -> has ($module, "category", $v['id'], "group", $gid))
						$ag['checked'] = "yes";
					else
						$ag['checked'] = "";

					$content['access_categories'][$k]['agroups'] .= gen_content("base", "list_access_groups", $ag);
				}
			}


		}
		else
			$content['result'] = "Недостаточно прав";
	}

	debug("*** end: Access: edit ***");
	return $content;
}

function add_default($module, $res_type, $res_id)
{
	global $config;
	global $user;

	debug("=== Access: add_default ===");
    $content = array (
        'result' => ''
    );

	if (1 == $user['id'])
	{
		debug ("user is admin");

		$groups = "0";
		$sql_query = "SELECT `id` FROM `ksh_users_groups`";
		$result = exec_query($sql_query);
		while ($row = mysql_fetch_array($result))
			$groups .= "|".stripslashes($row['id']);
		mysql_free_result($result);
		
		debug("groups:".$groups, 2);

		$sql_query = "INSERT INTO `ksh_".mysql_real_escape_string($module)."_access` 
			(`res_type`, `res_id`, `subj_type`, `subj_id`) VALUES	(
			'".mysql_real_escape_string($res_type)."',
			'".mysql_real_escape_string($res_id)."',
			'group',
			'".mysql_real_escape_string($groups)."'
			)";
		$result = exec_query($sql_query);

	}

	debug("=== end: Access: add_default ===");
	return $content;
}

function create_table($table_name)
{
	global $config;
	global $user;

	debug ("=== Access: create_table ===");

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
			$charset = " charset='cp1251'";
		}

		$sql_query = "CREATE TABLE IF NOT EXISTS `".mysql_real_escape_string($table_name)."` (
			`id` int auto_increment primary key,
			`res_type` tinytext,
			`res_id` int,
			`subj_type` tinytext,
			`subj_id` tinytext
		)".$charset;

		exec_query($sql_query);
		$content['result'] .= "<p>Таблица доступа успешно создана</p>";


		$module = $config['modules']['current_module'];

		$categories = array();
		$sql_query = "SELECT `id` FROM `ksh_".mysql_real_escape_string($module)."_categories` ORDER BY `id`";
		$result = exec_query($sql_query);
		while ($row = mysql_fetch_array($result))
			$categories[] = stripslashes($row['id']);
		mysql_free_result($result);

		debug("categories:", 2);
		dump($categories);

		foreach($categories as $k => $v)
			$this -> add_default($module, "category", $v);

	}
	else
	{
		debug ("user isn't admin!");
		$content['result'] = "<p>Пожалуйста, войдите как администратор</p>";
	}

	debug ("=== end: Access: create_table ===");
	return $content;
}


}


?>
