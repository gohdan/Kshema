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
<p>Пароль не подходит. <a href="/auth/reset_password/">Сбросить пароль</a></p>
}}


{{if:if_success:
<p>Авторизация прошла успешно. Добро пожаловать, #username#.</p>
}}

{{if:if_show_admin_link:
<p><a href="/base/admin/">Администрировать сайт</a></p>
}}

{{if:if_fail:
<form class="auth_login" action="/auth/login/" method="post">
<input type="text" name="login" value="#login#" placeholder="Логин или email"><br>
<input type="password" name="password" placeholder="Пароль"><br>
<input type="submit" name="do_login" value="Войти">
</form>
}}

{{if:if_show_register_link:
<p><a href="/auth/show_register_form">Зарегистрироваться</a></p>
}}
