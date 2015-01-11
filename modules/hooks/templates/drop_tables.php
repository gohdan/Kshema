<h1>Уничтожение таблиц базы данных привязок</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/index.php?module=hooks&amp;action=admin">Вернуться к меню администрирования</a><br>
<a href="/index.php?module=hooks&amp;action=help#db_tables_drop">Справка</a>
</p>

<p>
Уничтожить таблицы:
</p>
<form action="/index.php?module=hooks&amp;action=drop_tables" method="post">
<input type="checkbox" name="drop_hooks_categories_table" value="ksh_hooks_categories">Категории привязок<br>
<input type="checkbox" name="drop_hooks_table" value="ksh_hooks">Привязки<br>
<input type="checkbox" name="drop_hooks_privileges_table" value="ksh_hooks_privileges">Привилегии<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
