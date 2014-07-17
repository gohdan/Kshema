<h1>Добавление галерей</h1>

<p>
<a href="/index.php?module=photos&action=view_categories">Вернуться к просмотру категорий</a><br>
</p>

#content#

<form action="/index.php?module=photos&action=add_gallery" method="post">
<input type="hidden" name="category" value="#category_id#">
<input type="text" name="name"><br>
Описание:<br>
<textarea rows="20" cols="50" name="descr"></textarea><br>
<input type="submit" name="do_add" value="Добавить">
</form>

<hr>