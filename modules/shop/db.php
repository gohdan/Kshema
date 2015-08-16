<?php

// Database functions of the shop module

function shop_install_tables()
{
	debug ("*** shop_install_tables ***");
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

	$priv = new Privileges();
	$result =  $priv -> create_table("ksh_shop_privileges");
	$content['result'] .= $result['result'];

	$acc = new Access();
	$result =  $acc -> create_table("ksh_shop_access");
	$content['result'] .= $result['result'];

        $queries[] = "create table if not exists ksh_shop_authors (
                id int auto_increment primary key,
                name tinytext,
				`category` int,
				`image` tinytext,
				`descr` text,
				`if_hide` varchar(1)
        )".$charset;

        $queries[] = "create table if not exists ksh_shop_categories (
                id int auto_increment primary key,
                parent int,
                name tinytext,
				template tinytext
        )".$charset;

        $queries[] = "create table if not exists ksh_shop_goods (
                id int auto_increment primary key,
				code tinytext,
                name tinytext,
                author int,
                category int,
                image tinytext,
                images text,
                genre tinytext,
                original_name tinytext,
                format tinytext,
                language tinytext,
                year tinytext,
                publisher tinytext,
                pages_qty tinytext,
                new_qty tinytext,
                new_price tinytext,
                used_qty tinytext,
                used_price tinytext,
                weight tinytext,
                commentary text,
				if_new varchar(1),
				if_popular varchar(1),
				if_hide varchar(1),
				`collection` int,
				`pdf` tinytext,
				`epub` tinytext,
				`mp3` tinytext,
				`embed` mediumtext,
				`tags` tinytext,
				`if_recommended` varchar(1),
				`links` mediumtext
        )".$charset;

        $queries[] = "create table if not exists ksh_shop_requests (
                id int auto_increment primary key,
                user int,
                good int,
                qty int
        )".$charset;

		$queries[] = "create table if not exists ksh_shop_demands (
                id int auto_increment primary key,
                user int,
                name tinytext,
                author tinytext,
				isbn tinytext,
				commentary text
        )".$charset;

        $queries[] = "create table if not exists ksh_shop_carts (
                id int auto_increment primary key,
                user int,
                good int,
                new_qty int,
                used_qty int
        )".$charset;

        $queries[] = "create table if not exists ksh_shop_orders (
                id int auto_increment primary key,
                user int,
                status tinyint,
				date date
        )".$charset;

        $queries[] = "create table if not exists ksh_shop_orders_statuses (
                id tinyint auto_increment primary key,
                status tinytext,
                date date
        )".$charset;

		$queries[] = "INSERT INTO ksh_shop_orders_statuses (id, status) values ('1', 'Бандероль отправлена')";
		$queries[] = "INSERT INTO ksh_shop_orders_statuses (id, status) values ('2', 'Деньги получены')";
		$queries[] = "INSERT INTO ksh_shop_orders_statuses (id, status) values ('3', 'Возврат')";
		$queries[] = "INSERT INTO ksh_shop_orders_statuses (id, status) values ('4', 'Отмена')";

        $queries[] = "create table if not exists ksh_shop_ordered_goods (
                id int auto_increment primary key,
                order_id int,
                good int,
                new_qty int,
                used_qty int
        )".$charset;


        $queries[] = "create table if not exists `ksh_shop_collections` (
                `id` int auto_increment primary key,
                `author` int,
				`category` int,
				`name` tinytext,
				`title` tinytext,
				`descr` text,
				`images` text
        )".$charset;


        $queries_qty = count($queries);
        $content['queries_qty'] .= $queries_qty;

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content['result'] .= "Запросы выполнены";
        }
		else
			$content['result'] .= "Нечего выполнять";
	debug ("*** end: shop_install_tables ***");
        return $content;
}

function shop_drop_tables()
{
	debug ("*** shop_drop_tables ***");
	global $config;
	global $user;
	$content = array(
		'content' => ''
	);
	if (1 == $user['id'])
	{
		debug ("user is admin");
        if (isset($_POST['do_drop']))
        {
                debug ("*** drop_db");
                unset ($_POST['do_drop']);
                foreach ($_POST as $k => $v) exec_query ("DROP TABLE ".mysql_real_escape_string($v));
                $content['content'] .= "Таблицы БД успешно удалены";
				debug ("*** end: drop_db");
        }
	}
	else
	{
		debug ("user isn't admin");
		$content['content'] .= "Пожалуйста, <a href=\"/auth/show_login_form/\">войдите в систему как администратор</a>";
	}
	debug ("*** end: shop_drop_tables ***");
    return $content;
}

function shop_update_tables()
{
	debug("*** shop_update_tables ***");
	global $config;
	global $user;
	$content = array(
		'content' => '',
        'result' => '',
		'queries_qty' => ''
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

	/* Checking tables */

	$tables = db_tables_list();

	if (!in_array("ksh_shop_privileges", $tables))
	{
		$priv = new Privileges();
		$result =  $priv -> create_table("ksh_shop_privileges");
		$content['result'] .= $result['result'];
	}

	if (!in_array("ksh_shop_access", $tables))
	{
		$acc = new Access();
		$result = $acc -> create_table("ksh_shop_access");
		$content['result'] .= $result['result'];
	}	

	if (!in_array("ksh_shop_collections", $tables))
	{
        $queries[] = "create table if not exists `ksh_shop_collections` (
                `id` int auto_increment primary key,
                `author` int,
				`category` int,
				`name` tinytext,
				`title` tinytext,
				`descr` text,
				`images` text
        )".$charset;
	}

	/* end: Checking tables */

	/* Checking fields in ksh_shop_goods */

	$sql_query = "SHOW FIELDS IN `ksh_shop_goods`";
	$result = exec_query($sql_query);
	$i = 0;
	while ($row = mysql_fetch_array($result))
	{
		$field_names[$i] = stripslashes($row['Field']);
		$field_types[$i] = stripslashes($row['Type']);
		$i++;
	}
	mysql_free_result($result);

	if (!in_array("collection", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `collection` int";
	if (!in_array("pdf", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `pdf` tinytext";
	if (!in_array("epub", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `epub` tinytext";
	if (!in_array("mp3", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `mp3` tinytext";
	if (!in_array("embed", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `embed` mediumtext";
	if (!in_array("tags", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `tags` tinytext";
	if (!in_array("if_recommended", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `if_recommended` varchar(1)";
	if (!in_array("links", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_goods` ADD `links` mediumtext";


	/* end: Checking fields in ksh_shop_goods */

	/* Checking fields in ksh_shop_authors */

	$sql_query = "SHOW FIELDS IN `ksh_shop_authors`";
	$result = exec_query($sql_query);
	while ($row = mysql_fetch_array($result))
	{
		$field_names[$i] = stripslashes($row['Field']);
		$field_types[$i] = stripslashes($row['Type']);
	}
	mysql_free_result($result);

	if (!in_array("category", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_authors` ADD `category` int";
	if (!in_array("image", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_authors` ADD `image` tinytext";
	if (!in_array("if_hide", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_authors` ADD `if_hide` varchar(1)";
	if (!in_array("descr", $field_names))
		$queries[] = "ALTER TABLE `ksh_shop_authors` ADD `descr` text";

	/* end: Checking fields in ksh_shop_authors */


	$queries_qty = count($queries);
	$content['queries_qty'] = $queries_qty;

	if ($queries_qty > 0)
	{
		foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
			$content['content'] .= "Запросы выполнены";
	}
	else
		$content['content'] .= "Нечего выполнять";

	debug("*** end: shop_update_tables ***");
	return $content;
}


?>
