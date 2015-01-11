<h1>Редактирование категории "#title#"</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=admin">Вернуться к меню администрирования</a><br>
<a href="/index.php?module=portfolio&amp;action=view_categories">Вернуться к просмотру категорий</a><br>
<a href="/index.php?module=portfolio&amp;action=help#categories_edit">Справка</a>
</p>


{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=portfolio&amp;action=category_edit" method="post">
<input type="hidden" name="id" value="#category_id#">

<table summary="Category edit table">
<tr><td>Системное название (латинскими буквами; можно использовать цифры):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>Название для вывода пользователю (можно любой текст):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Шаблон всей страницы <i>(по умолчанию - default)</i>:</td><td><input type="text" name="page_template" value="#page_template#"></td></tr>
<tr><td>Шаблон просмотра категории <i>(по умолчанию - view_by_category)</i>:</td><td><input type="text" name="template" value="#template#"></td></tr>
<tr><td>Шаблон списка портфолио <i>(по умолчанию - portfolio)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td>Шаблон просмотра портфолио <i>(по умолчанию - view)</i>:</td><td><input type="text" name="portfolio_template" value="#portfolio_template#"></td></tr>
<tr><td>Шаблон меню <i>(по умолчанию - пусто)</i>:</td><td><input type="text" name="menu_template" value="#menu_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="Записать"></td></tr>
</table>
</form>
