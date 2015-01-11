<h1>Перенос пользователя #name# в другую группу</h1>

<p>
<a href="/users/groups_view/">Список групп</a><br>
<a href="/users/help#users_group_change">Справка</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=users&amp;action=change_group&amp;user=#id#" method="post">
<input type="hidden" name="id" value="#id#">
Выберите группу: <select name="group">
#groups_select#
</select>
<input type="submit" name="do_change" value="Перенести">
</form>
