<h1>����������� ������ ���� ������ ������� �����</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/pages/admin/">��������� � ���� �����������������</a><br>
<a href="/pages/help#db_tables_drop">�������</a>
</p>


<p>
���������� �������:
</p>
<form action="/pages/drop_tables/" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_pages_categories">��������� �������<br>
<input type="checkbox" name="drop_pages_table" value="ksh_pages">��������<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_pages_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
