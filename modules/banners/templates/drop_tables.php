<h1>�������� ������ ���� ������ ��������</h1>

<p>
<a href="/banners/admin/">��������� � ���� ����������������� ��������</a><br>
<a href="/banners/help#db_tables_drop">�������</a>
</p>

#content#

{{if:result:<p>#result#</p>}}

<p>
���������� �������:
</p>
<form action="/banners/drop_tables/" method="post">
<input type="checkbox" name="drop_banners_categories_table" value="ksh_banners_categories">��������� ��������<br>
<input type="checkbox" name="drop_banners_table" value="ksh_banners">�������<br>
<input type="submit" name="do_drop" value="����������">
</form>
