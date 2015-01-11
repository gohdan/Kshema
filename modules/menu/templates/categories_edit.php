<h1>#module_title# - Редактирование категории "#title#"</h1>

<p>
<a href="/index.php?module=#module_name#&action=admin">Вернуться в основное меню администрирования</a><br>
<a href="/index.php?module=#module_name#&action=categories_view">Вернуться к просмотру категорий</a><br>
</p>


<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=#module_name#&action=categories_edit&category=#id#" method="post">
<input type="hidden" name="id" value="#id#">
<table>
<tr><td>Системное название (латинскими буквами; можно использовать цифры):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>Название для вывода пользователю (можно любой текст):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Подкатегория в категории:</td><td><select name="parent"><option value="0">Нет</option>#categories_select#</select></td></tr>
<tr><td>Шаблон списка элементов <i>(по умолчанию - elements)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update_category" value="Записать"></td></tr>
</table>
</form>
