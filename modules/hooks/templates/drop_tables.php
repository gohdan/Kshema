<h1>����������� ������ ���� ������ ��������</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/index.php?module=hooks&amp;action=admin">��������� � ���� �����������������</a><br>
<a href="/index.php?module=hooks&amp;action=help#db_tables_drop">�������</a>
</p>

<p>
���������� �������:
</p>
<form action="/index.php?module=hooks&amp;action=drop_tables" method="post">
<input type="checkbox" name="drop_hooks_categories_table" value="ksh_hooks_categories">��������� ��������<br>
<input type="checkbox" name="drop_hooks_table" value="ksh_hooks">��������<br>
<input type="checkbox" name="drop_hooks_privileges_table" value="ksh_hooks_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
