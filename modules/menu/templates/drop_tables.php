<h1>Уничтожение таблиц базы данных меню</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/index.php?module=menu&amp;action=admin">Вернуться к меню администрирования</a><br>
<a href="/index.php?module=menu&amp;action=help#db_tables_drop">Справка</a>
</p>


<p>
Уничтожить таблицы:
</p>
<form action="/index.php?module=menu&amp;action=drop_tables" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_menu_categories">Списки меню<br>
<input type="checkbox" name="drop_menu_table" value="ksh_menu">Элементы списков меню<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_menu_privileges">Привилегии<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
