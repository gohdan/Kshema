<?php

// Database functions of the "users" module

function users_table_create($table)
{
	global $user;
	global $config;
	debug("*** users_table_create ***");
    $content = array(
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
		$charset = " charset='utf8'";
	}
	$queries = array();

	$sql_query = "create table if not exists `".mysql_real_escape_string($table)."` (
                `id` int auto_increment primary key,
                `login` tinytext,
                `password` tinytext,
				`group` int,
                `name` tinytext,
				`email` tinytext,
                `first_name` tinytext,
                `second_name` tinytext,
                `sur_name` tinytext,
                `country` tinytext,
                `post_code` tinytext,
                `area` tinytext,
                `city` tinytext,
                `address` tinytext,
				`image` tinytext,
				`url` tinytext,
				`site` tinytext,
				`phone` tinytext,
				`phone_mob` tinytext,
				`phone_stat` tinytext,
				`last_login_date` date,
				`last_login_time` time
				";

	if (isset($config['users']['additional_fields']))
		foreach($config['users']['additional_fields'] as $k => $v)
			if ("" != $v['name'])
				$sql_query .= ", `".mysql_real_escape_string($v['name'])."` ".mysql_real_escape_string($v['db_type']);
	
	$sql_query .= ")".$charset;

	$queries[] = $sql_query;

	$psw="";
	for($i=0; $i < 8; $i++)
		$psw.=chr(rand(48,57));
	// echo $psw;
	$content['result'] .= "Ваш пароль: ".$psw."<br>";

	$queries[] = "insert into ksh_users 
		(`id`, `login`, `password`, `group`, `name`) values (
		'1',
		'".$config['base']['admin_email']."',
		'".mysql_real_escape_string(md5($config['base']['admin_email']."\n".$psw))."',
		'1',
		'Admin'
		)";

	$queries_qty = count($queries);
	$content['queries_qty'] = $queries_qty;

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query)
			exec_query ($sql_query);
		$content['result'] .= "Запросы выполнены";
	}
	debug("content: ", 2);
	dump($content);

	debug("*** end: users_table_create ***");
	return $content;
}

function users_groups_table_create($table)
{
	global $user;
	global $config;
	debug("*** users_groups_table_create ***");
    $content = array(
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
		$charset = " charset='utf8'";
	}
	$queries = array();

	$queries[] = "CREATE TABLE IF NOT EXISTS ksh_users_groups (
		`id` int auto_increment primary key,
		`name` tinytext,
		`title` tinytext,
		`template` tinytext,
		`list_template` tinytext,
		`element_template` tinytext,
		`page_template` tinytext,
		`menu_template` tinytext,
		`redirect` tinytext
	)".$charset;

	$queries[] = "INSERT INTO ksh_users_groups (`id`, `title`) values ('1', 'Администраторы')";
	$queries[] = "INSERT INTO ksh_users_groups (`id`, `title`) values ('2', 'Пользователи')";


	$queries_qty = count($queries);
	$content['queries_qty'] = $queries_qty;

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query)
			exec_query ($sql_query);
		$content['result'] .= "Запросы выполнены";
	}

	debug("*** end: users_groups_table_create ***");
	return $content;
}


function users_install_tables()
{
	debug ("*** users_install_tables ***");
	global $config;
    $content = array (
    	'content' => '',
        'queries_qty' => '',
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

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_users_privileges");
	$content['result'] .= $result['result'];

	$cnt = users_groups_table_create("ksh_users_groups");
	$content['result'] .= $cnt['result'];
	$cnt = users_table_create("ksh_users");
	$content['result'] .= $cnt['result'];

	$queries_qty = count($queries);

	$content['queries_qty'] .= $queries_qty;

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
		$content['result'] .= "Запросы выполнены";
	}
	else
		$content['result'] .= "Запросов нет";

	debug ("*** end: users_install_tables ***");
        return $content;
}

function users_drop_tables()
{
    debug ("*** users_drop_tables ***");
	global $config;
    $content = array(
    	'content' => '',
        'result' => ''
    );

    if (isset($_POST['do_drop']))
    {
            unset ($_POST['do_drop']);

			
			if (isset($_POST['drop_users_privileges_table']))
			{
				debug ("dropping privileges table");
				$cat = new Privileges();
				$result = $cat -> drop_table("ksh_users_privileges");
				$content['result'] .= $result['result'];
				unset($_POST['drop_users_privileges_table']);
			}

            foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
            $content['result'] .= "Таблицы БД успешно удалены";
    }
    else
	   	$content['result'] .= "";

    debug ("*** end: users_drop_tables ***");
    return $content;
}

function users_update_tables()
{
    global $config;
	global $user;

	debug ("*** users_update_tables ***");
    $content = array(
    	'content' => '',
        'queries_qty' => '',
        'result' => ''
    );

    $queries = array();

    // $queries[] = ""; // Write your SQL queries here

	$tables = db_tables_list();

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

	if (!in_array("ksh_users_groups", $tables))
		users_groups_table_create("ksh_users_groups");

	if (!in_array("ksh_users_privileges", $tables))
	{
		$priv = new Privileges();
		$priv -> create_table("ksh_users_privileges");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_users", $tables))
		users_table_create("ksh_users");


	/* Fields in ksh_users */

	$fields = array();
	$sql_query = "SHOW FIELDS IN `ksh_users`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$fields[] = stripslashes($row['Field']);
	mysql_free_result($result);

	debug("fields in ksh_users:", 2);
	dump($fields);

	if (!in_array("email", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `email` tinytext";

	if (!in_array("image", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `image` tinytext";

	if (!in_array("url", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `url` tinytext";

	if (!in_array("site", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `site` tinytext";

	if (!in_array("phone", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `phone` tinytext";

	if (!in_array("phone_mob", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `phone_mob` tinytext";

	if (!in_array("phone_stat", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `phone_stat` tinytext";

	if (!in_array("last_login_date", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `last_login_date` date";

	if (!in_array("last_login_time", $fields))
		$queries[] = "ALTER TABLE `ksh_users` ADD `last_login_time` time";


	if (isset($config['users']['additional_fields']))
		foreach($config['users']['additional_fields'] as $k => $v)
			if ("" != $v['name'])
				if (!in_array($v['name'], $fields))
					$queries[] = "ALTER TABLE `ksh_users` ADD `".mysql_real_escape_string($v['name'])."` ".mysql_real_escape_string($v['db_type']);


	/* End: Fields in ksh_users */

	/* Fields in ksh_users_groups */

	$fields = array();
	$sql_query = "SHOW FIELDS IN `ksh_users_groups`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$fields[] = stripslashes($row['Field']);
	mysql_free_result($result);

	debug("fields in ksh_users_groups:", 2);
	dump($fields);

	if (!in_array("redirect", $fields))
		$queries[] = "ALTER TABLE `ksh_users_groups` ADD `redirect` tinytext";

	/* End: Fields in ksh_users_groups */

    $queries_qty = count($queries);
    $content['queries_qty'] .= $queries_qty;

    if ($queries_qty > 0)
    {
	    foreach ($queries as $idx => $sql_query)
        	exec_query ($sql_query);
        $content['result'] .= "Запросы выполнены";
    }
    else
	  	$content['result'] .= "Нет запросов";

	debug ("*** users_update_tables ***");
    return $content;
}


?>
