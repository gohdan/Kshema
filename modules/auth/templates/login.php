<h1>Авторизация</h1>

<p>#result#</p>

<p>#content#</p>

{{if:if_empty_fields:
<p>Пожалуйста, заполните оба поля.</p>
}}

{{if:if_user_not_exist:
<p>Такого пользователя у нас нет.</p>
}}

{{if:if_password_dont_match:
<p>Пароль не подходит.</p>
}}


{{if:if_success:
<p>Авторизация прошла успешно. Добро пожаловать, #username#.</p>
}}

{{if:if_show_admin_link:
<p><a href="/index.php?module=base&action=admin">Администрировать сайт</a></p>
}}

{{if:if_fail:
<form class="auth_login" action="/index.php?module=auth&action=login" method="post">
Ваш e-mail: <input type="text" name="login" value="#login#"><br>
Пароль: <input type="password" name="password"><br>
<input type="submit" name="do_login" value="Войти">
</form>
}}

{{if:if_show_register_link:
<p>Ещё не регистрировались? <a href="/index.php?module=auth&action=show_register_form">Зарегистрируйтесь!</a></p>
}}
