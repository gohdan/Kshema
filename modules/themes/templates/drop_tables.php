<h1>����������� ������ ���� ������ ���</h1>

<p>
<a href="/users/profile_view/">��� �������</a>
{{if:show_admin_link:<br><a href="/themes/admin/">��������� � ���� �����������������</a>}}
</p>

{{if:result:<p>#result#</p>}}

{{if:show_drop_form:
<p>
���������� �������:
</p>
<form action="/themes/drop_tables/" method="post">
<input type="checkbox" name="drop_privileges_table" value="ksh_themes_privileges">����������<br>
<input type="checkbox" name="drop_tparts_table" value="ksh_themes_tparts">����� ��������<br>
<input type="submit" name="do_drop" value="����������">
</form>
}}
