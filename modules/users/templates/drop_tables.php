<h1>�������� ������ ���� ������ �������������</h1>

<p>
<a href="/users/admin/">��������� � ���� ����������������� �������������</a><br>
<a href="/users/help#db_tables_drop">�������</a>
</p>


#content#

{{if:result:<p>#result#</p>}}

<p>
���������� �������:
</p>
<form action="/users/drop_tables/" method="post">
<input type="checkbox" name="drop_users_table" value="ksh_users">������������<br>
<input type="checkbox" name="drop_users_groups_table" value="ksh_users_groups">������ �������������<br>
<input type="checkbox" name="drop_users_privileges_table" value="ksh_users_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
