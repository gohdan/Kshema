<h1>���������� ���������</h1>

{{if:result:<p>#result#</p>}}

{{if:show_admin_link:
<p>
<a href="/guestbook/admin/">���� ����������������� ����������</a><br>
<a href="/guestbook/help#bb_add">�������</a>
</p>
}}

<p><a href="/guestbook/view_by_category/#category_link#/">������� � �������� �����</a></p>

<form action="/guestbook/add/#category#/" method="post">
<input type="hidden" name="category" value="#category#">
<table summary="message add table">
<tr><td>���� ��� (*):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>���������� ������:</td><td><input type="text" name="contact" value="#contact#"></td></tr>
<tr><td>��������� (*):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>����� (*):</td><td><textarea name="text" style="width: 400px; height: 300px">#text#</textarea></td></tr>
<tr><td><img src="/libs/kcaptcha/index.php?#session_name#=#session_id#"></td><td>����������� ��� �����:<br><input type="text" name="keystring"></td>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
