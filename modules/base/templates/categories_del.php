<h1>#module_title# - Удаление категории</h1>

<p>
<a href="/index.php?module=#module_name#&action=categories_view">Вернуться к просмотру категорий</a><br>
</p>

<p>Вы действительно хотите удалить категорию <b>"#title#"</b>? Все элементы в этой категории также будут удалены!</p>

<p>#content#</p>

<form action="/index.php?module=#module_name#&action=categories_view" method="post">

<input type="hidden" name="category" value="#id#">
<input type="submit" name="do_not_del_category" value="Не удалять">
<input type="submit" name="do_del_category" value="Удалить">
</form>
