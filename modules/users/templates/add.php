<h1>���������� ������������</h1>

{{if:group:<p><a href="/users/view_by_group/#group#/">������� � ��������� ������</a></p>}}

{{if:result:<p>#result#</p>}}

{{if:show_add_form:
<form action="/users/add/#group#" method="post">
<input type="hidden" name="group" value="#group#">
<table>
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
</table>
</form>
}}
