<h1>����������� ������ ���� ������ ����� ����������</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/bbcpanel/admin/">��������� � ���� �����������������</a><br>
<a href="/bbcpanel/help#db_tables_drop">�������</a>
</p>


<p>
���������� �������:
</p>
<form action="/bbcpanel/drop_tables/" method="post">
<input type="checkbox" name="drop_bbcpanel_categories_table" value="ksh_bbcpanel_categories">��������� ����� ����������<br>
<input type="checkbox" name="drop_bbcpanel_bbs_table" value="ksh_bbcpanel_bbs">����� ����������<br>
<input type="checkbox" name="drop_bbcpanel_privileges_table" value="ksh_bbcpanel_privileges">����������<br>
<input type="submit" name="do_drop" value="����������">
</form>
