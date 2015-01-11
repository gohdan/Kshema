<h1>Удаление элемента меню</h1>

<p>
<a href="/index.php?module=menu&amp;action=admin">Вернуться в меню администрирования</a><br>
<a href="/index.php?module=menu&amp;action=help#elements_del">Справка</a>
</p>

<p>Вы действительно хотите удалить элемент <b>#title#</b>?</p>

#content#

<form action="/index.php?module=menu&amp;action=view_by_category&amp;category=#category_id#" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>
