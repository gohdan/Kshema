<h1>Добавление категорий</h1>

<p>
<a href="/index.php?module=photos&action=view_categories">Вернуться к просмотру категорий</a><br>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=add_category" method="post">
Системное название (латинскими буквами; можно использовать цифры):<br>
<input type="text" name="name"><br>
Название для вывода пользователю (можно любой текст):<br>
<input type="text" name="title"><br>
<input type="submit" name="do_add" value="Добавить">
</form>
