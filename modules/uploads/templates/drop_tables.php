<h1>Уничтожение таблиц базы данных закачек</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/uploads/admin/">Вернуться к меню администрирования</a><br>
<a href="/uploads/help#db_tables_drop">Справка</a>
</p>


<p>
Уничтожить таблицы:
</p>
<form action="/uploads/drop_tables/" method="post">
<input type="checkbox" name="drop_uploads_privileges_table" value="ksh_uploads_privileges">Привилегии<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
