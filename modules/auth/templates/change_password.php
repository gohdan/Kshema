<h1>����� ������</h1>

<p>
<a href="#inst_root#/users/profile_view/">��� �������</a><br>
<a href="#inst_root#/auth/admin/">������� � ���� �����������������</a>
</p>

{{if:res_wrong_old_psw:<p>������ ������ ����� �����������</p>}}
{{if:res_new_psw_not_eq:<p>�������� ������ �� ���������</p>}}
{{if:res_db_error:<p>������ ��� ������� � ���� ������</p>}}
{{if:res_success:<p>������ ������� ������. <a href="#inst_root#/auth/show_login_form/">����� �� ����</a></p>}}

{{if:if_show_login_link:
<p>
����� ������� ������, ������� ���� <a href="#inst_root#/auth/show_login_form/">����� �� ����</a>.
</p>
}}

{{if:if_show_change_form:
<form action="#inst_root#/auth/change_password/" method="post">
<table>
<tr><td>������ ������:</td><td><input type="password" name="old_password"></td></tr>
<tr><td>����� ������:</td><td><input type="password" name="new_password_1"></td></tr>
<tr><td>����� ������ ��� ���:</td><td><input type="password" name="new_password_2"></td></tr>
<tr><td></td><td><input type="submit" name="do_change" value="������� ������"></td></tr>
</table>
</form>
}}
