<h1>����������� ������ ���� ������ ����</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/index.php?module=menu&amp;action=admin">��������� � ���� �����������������</a><br>
<a href="/index.php?module=menu&amp;action=help#db_tables_drop">�������</a>
</p>


<p>
���������� �������:
</p>
<form action="/index.php?module=menu&amp;action=drop_tables" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_menu_categories">������ ����<br>
<input type="checkbox" name="drop_menu_table" value="ksh_menu">�������� ������� ����<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_menu_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
