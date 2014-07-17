<h1>Добавление категорий</h1>

<p><a href="/index.php?module=shop&action=categories_view">К просмотру категорий</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=shop&action=categories_add" method="post">
Название: <input type="text" name="name"><br>
Добавить как подкатегорию в:
<select name="parent">
<option value="0"></option>
#categories_select#
</select><br>
Шаблон страницы <i>(по умолчанию - default)</i>: <input type="text" name="template" value="default"><br>
<input type="submit" name="do_add" value="Добавить">
</form>

