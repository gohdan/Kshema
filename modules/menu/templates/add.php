<h1>Добавление элементов меню в список</h1>

#content#

<p>
<a href="/index.php?module=menu&amp;action=admin">Меню администрирования списков меню</a><br>
<a href="/index.php?module=menu&amp;action=help#elements_add">Справка</a>
</p>


<form action="/index.php?module=menu&amp;action=add&amp;category=#category_id#" method="post">
<input type="hidden" name="if_new_window" value="">
<table summary="menu add table">
<tr><td>Меню:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>Активирует подменю:</td><td><select name="submenu">#subcategories_select#<option value="0" selected>Нет</option></select></td></tr>
<tr><td>Открывать в новом окне:</td><td><input type="checkbox" name="if_new_window" value="yes"></td></tr>
<tr><td>Позиция <i>(число; чем оно больше, тем элемент ниже в списке)</i>:</td><td><input type="text" name="position" size="2"></td></tr>
<tr><td>Название для вывода пользователю:</td><td><input type="text" name="title" size="60"></td></tr>
<tr><td>URL <i>(можно без названия сайта)</i>:</td><td><input type="text" name="url" size="60"></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="Добавить"></td></tr>
</table>
</form>
