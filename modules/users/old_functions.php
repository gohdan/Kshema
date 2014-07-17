<?php

function get_users_list()
{
        debug ("*** get_users_list");
        $table = "ksh_users";
        $result = exec_query ("SELECT * FROM ".$table);
        while ($users_list[] = mysql_fetch_array ($result))
        {

        }
        mysql_free_result ($result);
        foreach ($users_list as $k => $v) debug ($k.":".$v);
        debug ("*** end: get_users_list");
        return $users_list;
}

function view_users($user)
{
        debug ("*** view_users");
        $content = "";

        $users_list = get_users_list();

        $content .= "<table style=\"width: 100%\">";
        $content .= "<tr><td style=\"background-color: #eeeeee; text-align: center\">ID</td><td style=\"background-color: #eeeeee; text-align: center\">Имя</td><td style=\"background-color: #eeeeee; text-align: center\">Должность</td>";
        foreach ($users_list as $k => $v)
        {
                debug ($k.":".$v);
                $content .= "<tr>";
                $content .= "<td style=\"text-align: center\">".$v['id']."</td>";
                $content .= "<td>".$v['name']."</td>";
                $content .= "<td>".mysql_result (exec_query ("SELECT name FROM roles WHERE id='".$v['role']."'"),0,0)."</td>";
                $content .= "</tr>";
        }
        $content .= "</table>";

        debug ("*** end: view_users");
        return $content;
}


function view_roles($user)
{
        debug ("*** view_roles");
        $content = "";
        $content .= "<h1>Роли</h1>";

        $content .= "<table>";
        $content .= "<tr><td>ID</td><td>Название</td>";
        $result = exec_query ("SELECT * FROM roles");
        while ($row = mysql_fetch_array ($result))
        {
                $content .= "<tr>";
                $content .= "<td>".$row['id']."</td>";
                $content .= "<td>".$row['name']."</td>";
                $content .= "</tr>";
        }
        $content .= "</table>";

        debug ("*** end: view_roles");
        return $content;
}

function create_roles($user)
{
        debug ("*** create_roles");
        $content = "";
        $content .= "<h1>Создание ролей</h1>";

        $queries[] = "create table roles (
                id int auto_increment primary key,
                name tinytext
        )";

        $queries[] = "insert into roles (name) values ('Administrator')";
        $queries[] = "insert into roles (name) values ('Manager')";
        $queries[] = "insert into roles (name) values ('Worker')";

        $queries_qty = count($queries);
        $content .= "<p>Number of queries to DB: ".$queries_qty."</p>\n<hr>\n";

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content .= "<p>Запросы выполнены</p>";
        }

        debug ("*** end: create_roles");
        return $content;
}


function delete_roles($user)
{
        debug ("*** delete_roles");

        exec_query ("DROP TABLE roles");
        $content = "<p>Таблицы БД успешно удалены</p>";

        debug ("*** end: delete_roles");
        return $content;
}

function create_users_table($user)
{
        debug ("*** create_users_table");
        $content = "";
        $content .= "<h1>Создание таблицы пользователей</h1>";

        $queries[] = "create table ksh_users (
                id int auto_increment primary key,
                name tinytext,
                role int
        )";

        $queries[] = "insert into ksh_users (name,role) values ('Administrator','1')";
        $queries[] = "insert into ksh_users (name,role) values ('Manager','2')";
        $queries[] = "insert into ksh_users (name,role) values ('Worker','3')";

        $queries_qty = count($queries);
        $content .= "<p>Number of queries to DB: ".$queries_qty."</p>\n<hr>\n";

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content .= "<p>Запросы выполнены</p>";
        }

        debug ("*** end: create_roles");
        return $content;
}
/*
function users_get_name($id)
{
        $result = exec_query("SELECT name FROM ksh_users WHERE id='".mysql_real_escape_string($id)."'");
        $name = mysql_result($result, 0, 0);
        mysql_free_result($result);
        return $name;
}
*/

function users_tables_create()
{
	return users_install_tables();
}

function users_current_id()
{
	debug ("*** users_current_id ***");
	global $config;
	global $user;
	debug ("*** end: users_current_id ***");

	return $user['id'];
}

function users_get_info($user_id)
{
	debug ("*** users_get_info ***");
	global $user;
	global $config;

	$content = array(
		'id' => '',
		'login' => '',
		'password' => '',
		'name' => '',
		'first_name' => '',
		'second_name' => '',
		'sur_name' => '',
		'country' => '',
		'post_code' => '',
		'area' => '',
		'city' => '',
		'address' => ''
	);

	$result = exec_query("SELECT * FROM ksh_users WHERE id='".mysql_real_escape_string($user_id)."'");
	$user = mysql_fetch_array($result);
	mysql_free_result($result);

	$content['id'] = stripslashes($user['id']);
	$content['login'] = stripslashes($user['login']);
	$content['password'] = stripslashes($user['password']);
	$content['name'] = stripslashes($user['name']);
	$content['first_name'] = stripslashes($user['first_name']);
	$content['sur_name'] = stripslashes($user['sur_name']);
	$content['country'] = stripslashes($user['country']);
	$content['post_code'] = stripslashes($user['post_code']);
	$content['area'] = stripslashes($user['area']);
	$content['city'] = stripslashes($user['city']);
	$content['address'] = stripslashes($user['address']);

	debug ("*** users_get_info ***");
	return $content;
}


?>
