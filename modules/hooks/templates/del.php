<h1>Удаление привязки</h1>

<p>
<a href="/index.php?module=hooks&amp;action=categories_view">Вернуться к списку категорий</a><br>
<a href="/index.php?module=hooks&amp;action=help#hooks_del">Справка</a>
</p>

<p>Вы действительно хотите удалить привязку{{if:title:<b>#title#</b>}}?</p>

#content#

<form action="/index.php?module=hooks&amp;action=categories_view" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>
