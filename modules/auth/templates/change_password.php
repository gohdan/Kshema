<h1>Смена пароля</h1>

<p>
<a href="#inst_root#/users/profile_view/">Ваш профиль</a><br>
<a href="#inst_root#/auth/admin/">Возврат в меню администрирования</a>
</p>

{{if:res_wrong_old_psw:<p>Старый пароль введён неправильно</p>}}
{{if:res_new_psw_not_eq:<p>Введённые пароли не совпадают</p>}}
{{if:res_db_error:<p>Ошибка при запросе к базе данных</p>}}
{{if:res_success:<p>Пароль успешно изменён. <a href="#inst_root#/auth/show_login_form/">Войти на сайт</a></p>}}

{{if:if_show_login_link:
<p>
Чтобы сменить пароль, сначала надо <a href="#inst_root#/auth/show_login_form/">войти на сайт</a>.
</p>
}}

{{if:if_show_change_form:
<form action="#inst_root#/auth/change_password/" method="post">
<table>
<tr><td>Старый пароль:</td><td><input type="password" name="old_password"></td></tr>
<tr><td>Новый пароль:</td><td><input type="password" name="new_password_1"></td></tr>
<tr><td>Новый пароль ещё раз:</td><td><input type="password" name="new_password_2"></td></tr>
<tr><td></td><td><input type="submit" name="do_change" value="Сменить пароль"></td></tr>
</table>
</form>
}}
