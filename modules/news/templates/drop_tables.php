<h1>�������� ������ ���� ������ ��������</h1>

<p>
<a href="/news/admin/">��������� � ���� ����������������� ��������</a><br>
<a href="/news/help#db_tables_drop">�������</a>
</p>

#content#

{{if:result:<p>#result#</p>}}

<p>
���������� �������:
</p>
<form action="/news/drop_tables/" method="post">
<input type="checkbox" name="drop_news_categories_table" value="ksh_news_categories">��������� ��������<br>
<input type="checkbox" name="drop_news_table" value="ksh_news">�������<br>
<input type="checkbox" name="drop_news_privileges_table" value="ksh_news_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
