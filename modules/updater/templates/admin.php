<h1>#heading#</h1>


<p>
<a href="/users/profile_view/">Ваш профиль</a>
{{if:show_admin_link:<br><a href="/index.php?module=modules&amp;action=admin">Вернуться в главное меню администрирования</a>}}
</p>

<hr>

<p>
{{if:show_all_link:<a href="/updater/all/">Обновить всё</a><br>}}
{{if:show_theme_link:<a href="/updater/theme/">Обновить тему оформления</a>}}
</p>

<hr>

<h2>Администрирование базы данных обновлений</h2>

<p>
{{if:show_create_tables_link:<a href="/updater/create_tables/">Создать таблицы базы данных</a><br>}}
{{if:show_drop_tables_link:<a href="/updater/drop_tables/">Уничтожить таблицы базы данных</a><br>}}
{{if:show_update_tables_link:<a href="/updater/update_tables/">Обновить таблицы базы данных</a><br>}}
</p>
