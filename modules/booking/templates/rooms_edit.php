<h1>�������������� �������</h1>

<p><a href="/booking/admin/">� �������� ���� �����������������</a></p>

<form action="/booking/rooms_edit/" method="post">
������� ����� �������, ����� ������� ������<br><br>

<table class="rooms">
<tr>
<th>����</th>
<th>�����</th>
<th>���</th>
#rooms#
</table>
<br>
�������� �����:<br>
<select name="new_floor">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select>
<input type="text" name="new_room_number" size="3">
<select name="new_room_type">
<option value="1">Standard</option>
<option value="2">Deluxe</option>
<option value="3">Apartments</option>
</select>
<br><br>
<input type="submit" name="do_update" value="��������">
</form>
