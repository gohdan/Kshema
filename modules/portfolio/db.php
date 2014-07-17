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
		$charset = " charset='cp1251'";
	}


        $queries[] = "create table if not exists ksh_portfolio (
                id int auto_increment primary key,
                name tinytext,
                author int,
                category int,
                image tinytext,
				descr_image tinytext,
				descr text,
				short_descr text,
                full_text text,
                date date,
				url tinytext
        )".$charset;

        $queries[] = "create table if not exists ksh_portfolio_categories (
                id int auto_increment primary key,
                name tinytext,
				title tinytext,
				template tinytext,
				list_template tinytext,
				portfolio_template tinytext,
				page_template tinytext,
				menu_template tinytext
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
