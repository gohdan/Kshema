<h1>����������� ������ ���� ������ ����������</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/bills/admin/">��������� � ���� �����������������</a><br>
<a href="/bills/help#db_tables_drop">�������</a>
</p>


<p>
���������� �������:
</p>
<form action="/bills/drop_tables/" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_bills_categories">��������� ����������<br>
<input type="checkbox" name="drop_bills_table" value="ksh_bills">����������<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_bills_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
