<h1>����������� ������ ���� ������ �������� �����</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/guestbook/admin/">��������� � ���� �����������������</a><br>
<a href="/guestbook/help#db_tables_drop">�������</a>
</p>


<p>
���������� �������:
</p>
<form action="/guestbook/drop_tables/" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_guestbook_categories">�������� �����<br>
<input type="checkbox" name="drop_guestbook_table" value="ksh_guestbook">���������<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_guestbook_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
