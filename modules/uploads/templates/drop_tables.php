<h1>����������� ������ ���� ������ �������</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/uploads/admin/">��������� � ���� �����������������</a><br>
<a href="/uploads/help#db_tables_drop">�������</a>
</p>


<p>
���������� �������:
</p>
<form action="/uploads/drop_tables/" method="post">
<input type="checkbox" name="drop_uploads_privileges_table" value="ksh_uploads_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
