<h1>Редактирование привязки</h1>

<p>
<a href="/index.php?module=hooks&amp;action=admin">Меню администрирования привязок</a><br>
<a href="/index.php?module=hooks&amp;action=view_by_category&amp;category=#category#">Обратно в категорию</a><br>
<a href="/index.php?module=hooks&amp;action=list_view">Список всех привязок</a><br>
<a href="/index.php?module=hooks&amp;action=help#hooks_edit">Справка</a>
</p>

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=hooks&amp;action=edit" method="post">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="name" value="#name#">
<table summary="Hook edit table">
<tr><td>Название:</td><td><input type="text" name="title" size="25" value="#title#"></td></tr>
<tr><td>Категория:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>Привязываемый модуль:</td><td><input type="text" name="hook_module" value="#hook_module#"></td></tr>
<tr><td>Тип содержимого:</td><td><input type="text" name="hook_type" value="#hook_type#"></td></tr>
<tr><td>ID содержимого:</td><td><input type="text" name="hook_id" value="#hook_id#"></td></tr>
<tr><td>Модуль, к которому привязываем:</td><td><input type="text" name="to_module" value="#to_module#"></td></tr>
<tr><td>Тип содержимого:</td><td><input type="text" name="to_type" value="#to_type#"></td></tr>
<tr><td>ID содержимого:</td><td><input type="text" name="to_id" value="#to_id#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="Сохранить"></td></tr>
</table>
</form>
