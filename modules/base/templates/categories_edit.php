<h1>#module_title# - Редактирование категории "#title#"</h1>

<p>
<a href="/#module_name#/admin/">Вернуться в основное меню администрирования</a><br>
<a href="/#module_name#/categories_view/">Вернуться к просмотру категорий</a><br>
</p>


<p>#result#</p>

<p>#content#</p>

<form action="/#module_name#/categories_edit/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
<table>
<tr><td>Системное название (латинскими буквами; можно использовать цифры):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>Название для вывода пользователю (можно любой текст):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Подкатегория в категории:</td><td><select name="parent"><option value="0">Нет</option>#categories_select#</select></td></tr>
<tr><td>Порядок вывода:</td><td><input type="text" name="position" size="2" value="#position#"></td></tr>
<tr><td>Шаблон всей страницы <i>(по умолчанию - default)</i>:</td><td><input type="text" name="page_template" value="#page_template#"></td></tr>
<tr><td>Шаблон просмотра категории <i>(по умолчанию - view_by_category)</i>:</td><td><input type="text" name="template" value="#template#"></td></tr>
<tr><td>Шаблон списка элементов <i>(по умолчанию - elements)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td>Шаблон просмотра отдельного элемента <i>(по умолчанию - view)</i>:</td><td><input type="text" name="element_template" value="#element_template#"></td></tr>
<tr><td>Шаблон меню <i>(по умолчанию - пусто)</i>:</td><td><input type="text" name="menu_template" value="#menu_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update_category" value="Записать"></td></tr>
</table>
</form>
