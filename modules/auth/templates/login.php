<h1>�����������</h1>

<p>#result#</p>

<p>#content#</p>

{{if:if_empty_fields:
<p>����������, ��������� ��� ����.</p>
}}

{{if:if_user_not_exist:
<p>������ ������������ � ��� ���.</p>
}}

{{if:if_password_dont_match:
<p>������ �� ��������.</p>
}}


{{if:if_success:
<p>����������� ������ �������. ����� ����������, #username#.</p>
}}

{{if:if_show_admin_link:
<p><a href="/index.php?module=base&action=admin">���������������� ����</a></p>
}}

{{if:if_fail:
<form class="auth_login" action="/index.php?module=auth&action=login" method="post">
��� e-mail: <input type="text" name="login" value="#login#"><br>
������: <input type="password" name="password"><br>
<input type="submit" name="do_login" value="�����">
</form>
}}

{{if:if_show_register_link:
<p>��� �� ����������������? <a href="/index.php?module=auth&action=show_register_form">�����������������!</a></p>
}}
