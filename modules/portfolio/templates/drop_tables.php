<h1>�������� ������ ���� ������ ���������</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=admin">��������� � ���� �����������������</a><br>
<a href="/index.php?module=portfolio&amp;action=help#db_tables_drop">�������</a>
</p>

#content#

{{if:result:<p>#result#</p>}}

<p>
���������� �������:
</p>
<form action="/index.php?module=portfolio&amp;action=drop_tables" method="post">
<input type="checkbox" name="drop_portfolio_categories_table" value="ksh_portfolio_categories">��������� ���������<br>
<input type="checkbox" name="drop_portfolio_table" value="ksh_portfolio">���������<br>
<input type="submit" name="do_drop" value="����������">
</form>
