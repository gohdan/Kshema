<h1>����������� ������ ���� ������ RSS</h1>

{{if:content:<p>#content#<p>}}

{{if:result:<p>#result#</p>}}

<p>
<a href="/rss/admin/">��������� � ���� �����������������</a><br>
</p>


<p>
���������� �������:
</p>
<form action="/rss/drop_tables/" method="post">
<input type="checkbox" name="drop_rss_table" value="ksh_rss">�������� RSS<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_rss_privileges">����������<br>
<input type="checkbox" name="drop_privileges_table" value="ksh_rss_access">������<br>
<input type="submit" name="do_drop" value="����������">
</form>
