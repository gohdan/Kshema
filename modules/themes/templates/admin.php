<h1>#heading#</h1>


<p>
<a href="/users/profile_view/">Ваш профиль</a>
{{if:show_admin_link:<br><a href="/index.php?module=modules&amp;action=admin">Вернуться в главное меню администрирования</a>}}
</p>

<hr>

<h2>Администрирование базы данных тем</h2>

<p>
{{if:show_create_tables_link:<a href="/themes/create_tables/">Создать таблицы базы данных</a><br>}}
{{if:show_drop_tables_link:<a href="/themes/drop_tables/">Уничтожить таблицы базы данных</a><br>}}
{{if:show_update_tables_link:<a href="/themes/update_tables/">Обновить таблицы базы данных</a><br>}}
</p>
