<h1>���������� ����������</h1>

{{if:result:<p>#result#</p>}}

{{if:show_admin_link:
<p>
<a href="/bills/admin/">���� ����������������� ����������</a><br>
<a href="/bills/help#bb_add">�������</a>
</p>
}}

{{if:show_user_bills_link:<a href="/bills/view_by_user/">��� ����������</a>}}

{{if:category:<p><a href="#module##action#/#category#/">� ���������</a></p>}}

<form action="/bills/add/" method="post">
<table summary="bills add table">
<tr><td>�������� ����������:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>�������� ��� ���:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>�����:</td><td><textarea name="full_text">#full_text#</textarea></td></tr>
{{if:show_captcha:<tr><td><img src="/libs/kcaptcha/index.php?#session_name#=#session_id#"></td><td>����������� ��� �����:<br><input type="text" name="keystring"></td></tr>}}
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
