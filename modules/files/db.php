<?php

// Database functions of the "files" module

function files_install_tables()
{
	debug ("*** files_install_tables ***");
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

	$cat = new Category();
	$result =  $cat -> create_table("ksh_files_categories");
	$content['result'] .= $result['result'];

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_files_privileges");
	$content['result'] .= $result['result'];

	$acc = new Access();
	$result =  $acc -> create_table("ksh_files_access");
	$content['result'] .= $result['result'];

	$cnf = new Config();
	$cnf -> table = "ksh_files_config";
	$result = $cnf -> create_table();
	$content['result'] .= " ".$result['result'];
	$queries[] = "INSERT INTO `ksh_files_config` (`name`, `value`, `descr`) VALUES ('elements_on_page', '20', 'Количество статей на странице')";

        $queries[] = "CREATE TABLE IF NOT EXISTS `ksh_files` (
                `id` int auto_increment primary key,
                `name` tinytext,
				`title` tinytext,
                `category` int,
				`path` text,
				`file` tinytext,
				`descr` text,
                `date` date
        )".$charset;


        $queries_qty = count($queries);

        $content['queries_qty'] .= $queries_qty;

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content['result'] .= "Запросы выполнены";
        }
        else
        	$content['result'] .= "Запросов нет";

	debug ("*** end: files_install_tables ***");
        return $content;
}

function files_drop_tables()
{
    debug ("*** files_drop_tables ***");
	global $config;
    $content = array(
    	'content' => '',
        'result' => ''
    );

    if (isset($_POST['do_drop']))
    {
            unset ($_POST['do_drop']);
            foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
            $content['result'] .= "Таблицы БД успешно удалены";
    }
    else
	   	$content['result'] .= "";

    debug ("*** end: files_drop_tables ***");
    return $content;
}

function files_update_tables()
{
	global $user;
	global $config;

	debug ("*** files_update_tables ***");

    $content = array(
    	'content' => '',
        'queries_qty' => '',
        'result' => ''
    );

    $queries = array();

    // $queries[] = ""; // Write your SQL queries here


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

	$tables = db_tables_list();

	if (!in_array("ksh_files_categories", $tables))
	{
		$cat = new Category();
		$cat -> create_table("ksh_files_categories");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_files_privileges", $tables))
	{
		$priv = new Privileges();
		$priv -> create_table("ksh_files_privileges");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_files_access", $tables))
	{
		$acc = new Access();
		$acc -> create_table("ksh_files_access");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_files_config", $tables))
	{
		$cnf = new Config();
		$cnf -> table = "ksh_files_config";
		$result = $cnf -> create_table();
		$content['result'] .= " ".$result['result'];
		$queries[] = "INSERT INTO `ksh_files_config` (`name`, `value`, `descr`) VALUES ('elements_on_page', '20', 'Количество статей на странице')";
	}

	if (!in_array("ksh_files", $tables))
        $queries[] = "create table if not exists ksh_files (
                id int auto_increment primary key,
                name tinytext,
				`title` tinytext,
                category int,
				path text,
				`file` tinytext,
				descr text,
                date date
        )".$charset;

	$fields = array();
	$sql_query = "SHOW FIELDS IN `ksh_files_categories`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
		$fields[] = stripslashes($row['Field']);
	mysql_free_result($result);

	debug("fields in ksh_files_categories:", 2);
	dump($fields);

	if (!in_array("parent", $fields))
		$queries[] = "ALTER TABLE `ksh_files_categories` ADD `parent` int";

	if (!in_array("menu_template", $fields))
		$queries[] = "ALTER TABLE `ksh_files_categories` ADD `menu_template` tinytext";

	if (in_array("files_template", $fields))
		$queries[] = "ALTER TABLE `ksh_files_categories` CHANGE `files_template` `element_template` tinytext";



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

	debug ("*** files_update_tables ***");
    return $content;
}


?>
