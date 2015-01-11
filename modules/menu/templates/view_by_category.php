<h1>#category#</h1>

{{if:show_admin_link:
<p>
<a href="/index.php?module=menu&action=categories_view">К перечислению списков меню</a><br>
<a href="/index.php?module=menu&action=add&category=#category_id#">Добавить в этот список</a><br>
<a href="/index.php?module=menu&amp;action=help#db_tables_update">Справка</a>
</p>}}

<p>#result#</p>

<p>#admin_link#</p>


<p>#content#</p>


<table>
<tr>
<th>ID</th><th>Позиция</th><th>Название</th><th>Подменю</th>
</tr>
#elements#
</table>

