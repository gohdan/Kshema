<h1>�������� ������ ���� ������ ��������</h1>

<a href="/index.php?module=projects&action=admin">��������� � ����������������� ��������</a>

<p>#result#</p>

<p>#content#</p>

<p>
���������� �������:
</p>
<form action="/index.php?module=projects&action=drop_tables" method="post">
<input type="checkbox" name="drop_projects_categories_table" value="ksh_projects_categories">��������� ��������<br>
<input type="checkbox" name="drop_projects_table" value="ksh_projects">�������<br>
<input type="checkbox" name="drop_projects_files_table" value="ksh_projects_files">����� ��������<br>
<input type="checkbox" name="drop_projects_statuses_table" value="ksh_projects_statuses">������� ��������<br>
<input type="submit" name="do_drop" value="����������">
</form>
