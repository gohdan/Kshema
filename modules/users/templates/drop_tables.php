<h1>Удаление таблиц базы данных пользователей</h1>

<p>
<a href="/users/admin/">Вернуться в меню администрирования пользователей</a><br>
<a href="/users/help#db_tables_drop">Справка</a>
</p>


#content#

{{if:result:<p>#result#</p>}}

<p>
Уничтожить таблицы:
</p>
<form action="/users/drop_tables/" method="post">
<input type="checkbox" name="drop_users_table" value="ksh_users">Пользователи<br>
<input type="checkbox" name="drop_users_groups_table" value="ksh_users_groups">Группы пользователей<br>
<input type="checkbox" name="drop_users_privileges_table" value="ksh_users_privileges">Привилегии<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
