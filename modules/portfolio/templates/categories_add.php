<h1>Добавление категорий</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=view_categories">Вернуться к просмотру категорий</a><br>
<a href="/index.php?module=portfolio&amp;action=help#categories_add">Справка</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=portfolio&amp;action=add_category" method="post">
<table summary="Category add table">
<tr><td>Системное название (латинские буквы и цифры):</td><td><input type="text" name="name"></td></tr>
<tr><td>Название для вывода пользователю (любые символы):</td><td><input type="text" name="title"></td></tr>
<tr><td>Шаблон всей страницы <i>(по умолчанию - default)</i>:</td><td><input type="text" name="page_template" value="default"></td></tr>
<tr><td>Шаблон просмотра категории <i>(по умолчанию - view_by_category)</i>:</td><td><input type="text" name="template" value="view_by_category"></td></tr>
<tr><td>Шаблон списка портфолио <i>(по умолчанию - portfolio)</i>:</td><td><input type="text" name="list_template" value="portfolio"></td></tr>
<tr><td>Шаблон просмотра портфолио <i>(по умолчанию - view)</i>:</td><td><input type="text" name="portfolio_template" value="view"></td></tr>
<tr><td>Шаблон меню <i>(по умолчанию - пусто)</i>:</td><td><input type="text" name="menu_template" value=""></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="Добавить"></td></tr>
</table>
</form>
