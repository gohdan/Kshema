<h1>�������������� ���</h1>

<p><a href="/booking/admin/">� �������� ���� �����������������</a></p>

<form action="/booking/prices_edit/" method="post">

<p>���� �� ������� ���� ������ � ���������, ���� ����� ��������� �����������</p>

<table class="prices">
<tr>
<th>������<br>(����-��-��)</th>
<th>���������<br>(����-��-��)</th>
<th>���</th>
<th>����</th>
</tr>
#prices#
<tr><td colspan="4">�������� ����:</td></tr>
<tr>
<td><input type="text" name="new_date_from" size="10"></td>
<td><input type="text" name="new_date_to" size="10"></td>
<td><select name="new_type">
<option value="1">Standard</option>
<option value="2">Deluxe</option>
<option value="3">Apartments</option>
</select></td>
<td><input type="text" name="new_price" size="3"></td>
</tr>
</table>
<input type="submit" name="do_update" value="��������">
</form>
