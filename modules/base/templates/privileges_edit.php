<h1>���������� ����</h1>

<p><a href="/#module#/admin/">������� � ����������������� ������</a></p>

{{if:result:<p>#result#</p>}}

{{if:show_form:
<p>������� �������� �������, ����� ������� ������</p>

<form action="/#module#/privileges_edit/" method="post">

<table>
<tr>
<th>������</th>
<th>���</th>
<th>ID</th>
<th>������</th>
<th>������</th>
</tr>

#privileges#

<tr>
<td colspan="5">����� ������:</td>
</tr>
<tr>
<input type="hidden" name="read_new" value="0">
<input type="hidden" name="write_new" value="0">
<td><input type="text" name="action_new"></td>
<td><select name="type_new">
<option value="group">������</option>
<option value="user">������������</option>
</select></td>
<td><input type="text" name="id_new" size="3"></td>
<td><input type="checkbox" name="read_new" value="1"></td>
<td><input type="checkbox" name="write_new" value="1"></td>
</tr>

</table>
<input type="submit" name="do_update" value="��������">
</form>
}}
