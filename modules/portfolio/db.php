<?php

// Database functions of the "portfolio" module

function portfolio_install_tables()
{
	debug ("*** portfolio_install_tables ***");
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
		$charset = " charset='".$config['db']['charset']."'";
	}

	$cat = new Category();
	$result =  $cat -> create_table("ksh_portfolio_categories");
	$content['result'] .= $result['result'];

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_portfolio_privileges");
	$content['result'] .= $result['result'];

	$acc = new Access();
	$result =  $acc -> create_table("ksh_portfolio_access");
	$content['result'] .= $result['result'];

    $queries[] = "CREATE TABLE IF NOT EXISTS `ksh_portfolio` (
            `id` int auto_increment primary key,
            `name` tinytext,
			`title` tinytext,
            `date` date,
			`year` tinytext,
            `category` int,
			`image` tinytext,
			`descr` mediumtext,
			`full_text` mediumtext,
			`images` mediumtext,
			`tags` mediumtext
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

	debug ("*** end: portfolio_install_tables ***");
    return $content;
}

function portfolio_drop_tables()
{
    debug ("*** portfolio_drop_tables ***");
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

    debug ("*** end: portfolio_drop_tables ***");
    return $content;
}

function portfolio_update_tables()
{
	debug ("*** portfolio_update_tables ***");
    global $config;
    $content = array(
    	'content' => '',
        'queries_qty' => '',
        'result' => ''
    );

    $queries = array();

    // $queries[] = ""; // Write your SQL queries here


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

	debug ("*** portfolio_update_tables ***");
    return $content;
}


?>
