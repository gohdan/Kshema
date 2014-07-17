<h1>Редактирование категорий</h1>

<p>
<a href="/index.php?module=photos&action=admin">Вернуться к администрированию изображений</a>
</p>

<p>
<a href="/index.php?module=photos&action=add_category">Добавить категорию</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=category_edit" method="post">
<input type="hidden" name="id" value="#category_id#">
Системное название (латинскими буквами; можно использовать цифры):<br>
<input type="text" name="name" value="#name#"><br>
Название для вывода пользователю (можно любой текст):<br>
<input type="text" name="title" value="#title#"><br>
<input type="submit" name="do_update" value="Записать">
</form>