<h1>Назначение прав</h1>

<p><a href="/#module#/admin/">Обратно в администрирование модуля</a></p>

{{if:result:<p>#result#</p>}}

{{if:show_form:
<p>Сотрите название объекта, чтобы удалить запись</p>

<form action="/#module#/privileges_edit/" method="post">

<table>
<tr>
<th>Объект</th>
<th>Тип</th>
<th>ID</th>
<th>Чтение</th>
<th>Запись</th>
</tr>

#privileges#

<tr>
<td colspan="5">Новая запись:</td>
</tr>
<tr>
<input type="hidden" name="read_new" value="0">
<input type="hidden" name="write_new" value="0">
<td><input type="text" name="action_new"></td>
<td><select name="type_new">
<option value="group">группа</option>
<option value="user">пользователь</option>
</select></td>
<td><input type="text" name="id_new" size="3"></td>
<td><input type="checkbox" name="read_new" value="1"></td>
<td><input type="checkbox" name="write_new" value="1"></td>
</tr>

</table>
<input type="submit" name="do_update" value="Записать">
</form>
}}
