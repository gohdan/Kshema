<h1>Редактирование группы "#title#"</h1>

<p>
<a href="/users/admin/">Вернуться к меню администрирования</a><br>
<a href="/users/groups_view/">Вернуться к просмотру групп</a><br>
<a href="/users/help#categories_edit">Справка</a>
</p>


{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/users/group_edit/" method="post">
<input type="hidden" name="id" value="#group_id#">
<table>
<tr><td>Название для вывода пользователю (можно любой текст):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>Перенаправлять после входа на адрес:</td><td><input type="text" name="redirect" value="#redirect#" size="40"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="Записать"></td></tr>
</table>
</form>
