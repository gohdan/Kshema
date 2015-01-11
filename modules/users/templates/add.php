<h1>Добавление пользователя</h1>

{{if:group:<p><a href="/users/view_by_group/#group#/">Обратно к просмотру группы</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_add_form:
<form action="/users/add/#group#" method="post">
<input type="hidden" name="group" value="#group#">
<table>
<tr>
<td>Логин:</td><td><input type="text" name="login"></td>
</tr>
<tr>
<td>Имя:</td><td><input type="text" name="name"></td>
</tr>
<tr>
<td>E-mail:</td><td><input type="text" name="email"></td>
</tr>
<tr>
<td>Пароль:</td><td><input type="password" name="password"></td>
</tr>
<tr>
<td></td><td><input type="submit" name="do_add" value="Добавить"></td>
</tr>
</table>
</form>
}}
