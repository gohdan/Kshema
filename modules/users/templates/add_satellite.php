<h1>���������� ������������ �� ��������</h1>

{{if:satellite_id:<p><a href="/bbcpanel/bb_edit/#satellite_id#/">� �������������� ���������</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_add_form:
<form action="/users/#action#/" method="post">
<input type="hidden" name="group" value="#group#">
<input type="hidden" name="satellite_id" value="#satellite_id#">
<table>
<tr>
<td>������:</td><td><select name="group">#groups_select#</select></td>
</tr>
<tr>
<td>�����:</td><td><input type="text" name="login"></td>
</tr>
<tr>
<td>���:</td><td><input type="text" name="name"></td>
</tr>
<tr>
<td>E-mail:</td><td><input type="text" name="email"></td>
</tr>
<tr>
<td>������:</td><td><input type="password" name="password"></td>
</tr>
<tr>
<td></td><td><input type="submit" name="do_add" value="��������"></td>
</tr>
</form>
}}
