{{if:name:<h1>#name#</h1>}}

{{if:show_admin_link:<p><a href="#inst_root#/base/admin/">���������������� ����</a></p>}}

{{if:show_logout_link:<p><a href="#inst_root#/auth/logout">����� �� �������</a></p>}}
{{if:show_change_password_link:<p><a href="#inst_root#/auth/change_password">������� ������</a></p>}}



<h2>������ ������</h2>

{{if:id:ID: #id#<br>}}
{{if:login:�����: #login#<br>}}
{{if:name:���: #name#<br>}}
{{if:group: ������: #group#<br>}}
{{if:first_name: ���: #first_name#<br>}}
{{if:second_name: ��������: #second_name#<br>}}
{{if:sur_name: �������: #sur_name#<br>}}
{{if:country: ������: #country#<br>}}
{{if:post_code: �������� ������: #post_code#<br>}}
{{if:area: �������: #area#<br>}}
{{if:city: �����: #city#<br>}}
{{if:address: �����: #address#<br>}}
{{if:last_login_date:���� ���������� �����: #last_login_date#<br>}}
{{if:last_login_time:����� ���������� �����: #last_login_time#<br>}}
{{if:last_login_date_never:���� ���������� �����: �������<br>}}
{{if:show_profile_edit_link:<p><a href="#inst_root#/users/profile_edit/">������������� ������ ������</a></p>}}

{{if:modules:<h2>������</h2>
#modules#}}

