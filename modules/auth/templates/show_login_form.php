<h1>�����������</h1>

#content#

<form class="auth_login" action="#inst_root#/auth/login/" method="post">
��� e-mail: <input type="text" name="login"><br>
������: <input type="password" name="password"><br>
<input type="submit" name="do_login" value="�����">
</form>

{{if:if_show_register_link:<p>��� �� ����������������? <a href="/auth/show_register_form/">�����������������!</a></p>}}
