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

function get_user_id()
{
    return 1;
}

function get_user_role($id)
{
    return 1;
}



?>
