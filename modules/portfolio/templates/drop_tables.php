<h1>Удаление таблиц базы данных портфолио</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=admin">Вернуться в меню администрирования</a><br>
<a href="/index.php?module=portfolio&amp;action=help#db_tables_drop">Справка</a>
</p>

#content#

{{if:result:<p>#result#</p>}}

<p>
Уничтожить таблицы:
</p>
<form action="/index.php?module=portfolio&amp;action=drop_tables" method="post">
<input type="checkbox" name="drop_portfolio_categories_table" value="ksh_portfolio_categories">Категории портфолио<br>
<input type="checkbox" name="drop_portfolio_table" value="ksh_portfolio">Портфолио<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
