<h1>Редактирование настроек</h1>

<p><a href="/#module#/admin/">В меню администрирования</a></p>

<p>Сотрите название, чтобы удалить запись</p>

{{if:satellite_id:<p><a href="/#module#/admin_satellite/#satellite_id#/">Обратно в администрирование модуля на сателлите</a></p>}}

<form action="/#module#/config_edit/{{if:satellite_id:satellite_#satellite_id#/}}" method="post">

<table>
<tr>
<th>Описание</th>
<th>Название</th>
<th>Значение</th>
</tr>
#config_elements#
<tr>
<td colspan="3">Новая запись:</td>
</tr>
<tr>
<td><input type="text" name="new_descr" size="40"></td>
<td><input type="text" name="new_name"></td>
<td><input type="text" name="new_value"></td>
</tr>

</table>

<input type="submit" name="do_update" value="Записать">
</form>
