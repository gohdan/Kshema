<h1>Удаление группы</h1>

<p>
<a href="/users/groups_view/">Вернуться к просмотру групп</a><br>
<a href="/users/help#categories_del">Справка</a>
</p>

<p>Вы действительно хотите удалить группу <b>#title#</b>?</p>

{{if:content:<p>#content#</p>}}

<form action="/users/groups_view/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="Не удалять">
<input type="submit" name="do_del" value="Удалить">
</form>
