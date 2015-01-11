<h1>#module_title# - Добавление категорий</h1>

<p>
<a href="/index.php?module=#module_name#&action=categories_view">Вернуться к просмотру категорий</a><br>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=#module_name#&action=categories_add" method="post">
<table>
<tr><td>Системное название (латинские буквы и цифры):</td><td><input type="text" name="name"></td></tr>
<tr><td>Название для вывода пользователю (любые символы):</td><td><input type="text" name="title"></td></tr>
<tr><td>Подкатегория в категории:</td><td><select name="parent"><option value="0">Нет</option>#categories_select#</select></td></tr>
<tr><td>Шаблон списка элементов <i>(по умолчанию - elements)</i>:</td><td><input type="text" name="list_template" value="elements"></td></tr>
<tr><td></td><td><input type="submit" name="do_add_category" value="Добавить"></td></tr>
</table>
</form>
