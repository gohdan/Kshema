<?php

// Old functions of the Auth module

function gen_auth_form()
{
    $form = "
        <form action=\"/index.php?module=auth\" method=\"post\">
        <input type=\"radio\" name=\"id\" value=\"1\">Администратор<br>
        <input type=\"radio\" name=\"id\" value=\"2\">Начальник<br>
        <input type=\"radio\" name=\"id\" value=\"3\" checked>Работник<br>
        <input type=\"submit\" name=\"do_login\" value=\"Войти\">
        </form>
    ";
    return $form;
}

function auth_get_user_id($login)
{
    debug ("=== mod: auth; fn: auth_get_user_id ===");
    $result = exec_query("SELECT id FROM ksh_users WHERE login='".mysql_real_escape_string($login)."'");
    $id = mysql_result($result, 0, 0);
    debug("user id: ".$id);
    mysql_free_result($result);
    debug ("=== end: mod: auth; fn: auth_get_user_id ===");
    return $id;
}

function get_user_id()
{
    return 1;
}

function get_user_role($id)
{
    return 1;
}



?>
