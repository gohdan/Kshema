<h1>�������������� ��������</h1>

<p><a href="/#module#/admin/">� ���� �����������������</a></p>

<p>������� ��������, ����� ������� ������</p>

{{if:satellite_id:<p><a href="/#module#/admin_satellite/#satellite_id#/">������� � ����������������� ������ �� ���������</a></p>}}

<form action="/#module#/config_edit/{{if:satellite_id:satellite_#satellite_id#/}}" method="post">

<table>
<tr>
<th>��������</th>
<th>��������</th>
<th>��������</th>
</tr>
#config_elements#
<tr>
<td colspan="3">����� ������:</td>
</tr>
<tr>
<td><input type="text" name="new_descr" size="40"></td>
<td><input type="text" name="new_name"></td>
<td><input type="text" name="new_value"></td>
</tr>

</table>

<input type="submit" name="do_update" value="��������">
</form>
