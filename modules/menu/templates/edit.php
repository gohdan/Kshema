<h1>Редактирование элемента меню</h1>

<p>
<a href="/index.php?module=menu&amp;action=admin">Меню администрирования списков меню</a><br>
<a href="/index.php?module=menu&amp;action=help#menu_edit">Справка</a>
</p>

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=menu&amp;action=edit&amp;menu=#id#" method="post">
<input type="hidden" name="id" value="#id#">
<table summary="Menu element edit table">
<tr><td>Категория:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>Активирует подменю:</td><td><select name="submenu"><option value="0">Нет</option>#subcategories_select#</select></td></tr>
<tr><td>Открывать в новом окне:</td><td><input type="checkbox" name="if_new_window" value="yes"{{if:if_new_window: checked}}></td></tr>
<tr><td>Позиция:</td><td><input type="text" name="position" size="2" value="#position#"></td></tr>
<tr><td>Название:</td><td><input type="text" name="title" value="#title#" size="60"></td></tr>
<tr><td>URL:</td><td><input type="text" name="url" value="#url#" size="60"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="Сохранить"></td></tr>
</table>
</form>
