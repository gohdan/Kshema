<h1>�������� ������ ���� ������ �������� ���������</h1>

<a href="/index.php?module=counter&action=admin">��������� � ���� ����������������� �������� ���������</a>

#content#

<p>#result#</p>

<p>
���������� �������:
</p>
<form action="/index.php?module=counter&action=drop_tables" method="post">
<input type="checkbox" name="drop_counter_days_table" value="ksh_counter_days">���������� �� ����<br>
<input type="checkbox" name="drop_counter_monthes_table" value="ksh_counter_monthes">���������� �� �������<br>
<input type="checkbox" name="drop_counter_years_table" value="ksh_counter_years">���������� �� �����<br>
<input type="submit" name="do_drop" value="����������">
</form>
