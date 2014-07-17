<?php

// Database functions of the auth module

function auth_install_tables()
{
        $content['content'] = "";

        $queries[] = "create table if not exists users (
                id int auto_increment primary key,
                login tinytext,
                password tinytext,
                name tinytext,
                first_name tinytext,
                second_name tinytext,
                sur_name tinytext,
                country tinytext,
                post_code tinytext,
                area tinytext,
                city tinytext,
                address tinytext
        )";

        $queries[] = "insert into users (id, login, password, name) values ('1', 'admin', '', 'Admin')";

        $queries_qty = count($queries);
        $content['content'] .= "<p>Количество запросов к БД: ".$queries_qty."</p>";

        if ($queries_qty > 0)
        {
                foreach ($queries as $idx => $sql_query) exec_query ($sql_query);
                $content['content'] .= "<p>Запросы выполнены</p>";
        }
        return $content;
}


?>
