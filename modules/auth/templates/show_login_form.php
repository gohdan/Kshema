<h1>Авторизация</h1>

#content#

<form class="auth_login" action="#inst_root#/auth/login/" method="post">
Ваш e-mail: <input type="text" name="login"><br>
Пароль: <input type="password" name="password"><br>
<input type="submit" name="do_login" value="Войти">
</form>

{{if:if_show_register_link:<p>Ещё не регистрировались? <a href="/auth/show_register_form/">Зарегистрируйтесь!</a></p>}}
