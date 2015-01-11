<?php

// Database functions of the photos module

function photos_install_tables()
{
	debug ("*** photos_install_tables ***");
	global $config;
	$content = array(
		'content' => '',
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

        $queries[] = "create table if not exists ksh_photos_categories (
                id int auto_increment primary key,
                name tinytext,
				title tinytext
        )".$charset;


        $queries[] = "create table if not exists ksh_photos_galleries (
                id int auto_increment primary key,
                name tinytext,
                category int,
                descr text
        )".$charset;

        $queries[] = "create table if not exists ksh_photos (
                id int auto_increment primary key,
                name tinytext,
                author int,
                gallery int,
                image tinytext,
                thumb tinytext,
                descr text,
                date date
        )".$charset;


        $queries_qty = count($queries);
		$content['queries_qty'] = $queries_qty;
        
		if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content['result'] = "Запросы выполнены";
        }
		else
			$content['result'] = "Нечего выполнять";
	debug ("*** end: photos_install_tables ***");
    return $content;
}

function photos_drop_tables()
{
	debug ("*** photos_drop_tables ***");
	$content = array(
		'content' => '',
		'result' => ''
	);
        
		if (isset($_POST['do_drop']))
        {
                debug ("*** drop_db");
                unset ($_POST['do_drop']);
                foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
                $content['result'] .= "Таблицы БД успешно удалены";
        }
        debug ("*** end: drop_db");


	debug ("*** photos_drop_tables ***");
    return $content;
}

function photos_update_tables()
{
	debug ("*** photos_update_tables ***");
    global $config;
	$content = array(
		'content' => '',
		'result' => '',
		'queries_qty' => ''
	);
	$queries = array();
        
	//$queries[] = ""; // Write your SQL queries here
    
    if ($config['base']['version'] > 0.4)
    {
    	$queries[] = "ALTER TABLE ksh_photos ADD thumb tinytext";
    }

        $queries_qty = count($queries);
        $content['queries_qty'] = $queries_qty;

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content['result'] .= "Запросы выполнены";
        }
		else
			$content['result'] .= "Нечего выполнять";
	debug ("*** end: photos_update_tables ***");
    return $content;
}

?>
