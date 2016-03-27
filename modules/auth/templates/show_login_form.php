<h1>Авторизация</h1>

#content#

<form class="auth_login" action="#inst_root#/auth/login/" method="post">
<input type="text" name="login" placeholder="Логин"><br>
<input type="password" name="password" placeholder="Пароль"><br>
<input type="submit" name="do_login" value="Войти">
</form>

{{if:if_show_register_link:<p>Ещё не регистрировались? <a href="/auth/show_register_form/">Зарегистрируйтесь!</a></p>}}
