<h1>�������������� ������ "#title#"</h1>

<p>
<a href="/users/admin/">��������� � ���� �����������������</a><br>
<a href="/users/groups_view/">��������� � ��������� �����</a><br>
<a href="/users/help#categories_edit">�������</a>
</p>


{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/users/group_edit/" method="post">
<input type="hidden" name="id" value="#group_id#">
<table>
<tr><td>�������� ��� ������ ������������ (����� ����� �����):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>�������������� ����� ����� �� �����:</td><td><input type="text" name="redirect" value="#redirect#" size="40"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="��������"></td></tr>
</table>
</form>
