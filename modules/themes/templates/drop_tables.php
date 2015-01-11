<h1>Уничтожение таблиц базы данных тем</h1>

<p>
<a href="/users/profile_view/">Ваш профиль</a>
{{if:show_admin_link:<br><a href="/themes/admin/">Вернуться к меню администрирования</a>}}
</p>

{{if:result:<p>#result#</p>}}

{{if:show_drop_form:
<p>
Уничтожить таблицы:
</p>
<form action="/themes/drop_tables/" method="post">
<input type="checkbox" name="drop_privileges_table" value="ksh_themes_privileges">Привилегии<br>
<input type="checkbox" name="drop_tparts_table" value="ksh_themes_tparts">Части шаблонов<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
}}
