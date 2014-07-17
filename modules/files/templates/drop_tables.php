<h1>Удаление таблиц базы данных файлов</h1>

<a href="/files/admin/">Вернуться в меню администрирования файлов</a>

#content#

<p>#result#</p>

<p>
Уничтожить таблицы:
</p>
<form action="/files/drop_tables/" method="post">
<input type="checkbox" name="drop_files_categories_table" value="ksh_files_categories">Категории файлов<br>
<input type="checkbox" name="drop_files_table" value="ksh_files">Файлы<br>
<input type="checkbox" name="drop_files_config_table" value="ksh_files_config">Настройки<br>
<input type="checkbox" name="drop_files_privileges_table" value="ksh_files_privileges">Привилегии<br>
<input type="submit" name="do_drop" value="Уничтожить">
</form>
