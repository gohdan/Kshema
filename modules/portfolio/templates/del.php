<h1>Удаление из портфолио</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=view_by_category&amp;category=#category_id#">Вернуться к просмотру новостей в категории</a><br>
<a href="/index.php?module=portfolio&amp;action=help#portfolio_del">Справка</a>
</p>

<p>Вы действительно хотите удалить из портфолио <b>#name#</b>?</p>

#content#

<form action="/index.php?module=portfolio&amp;action=view_by_category&amp;category=#category_id#" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>

