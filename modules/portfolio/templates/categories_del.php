<h1>Удаление категории</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=view_categories">Вернуться к просмотру категорий</a><br>
<a href="/index.php?module=portfolio&amp;action=help#categories_del">Справка</a>
</p>

<p>Вы действительно хотите удалить категорию <b>#name#</b>? Все элементы в этой категории также будут удалены!</p>

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=portfolio&amp;action=view_categories" method="post">
<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>
