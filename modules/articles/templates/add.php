<h1>���������� ������</h1>

{{if:result:<p>#result#</p>}}

{{if:show_admin_link:
<a href="/articles/admin/">� ����������������� ������</a>
}}

{{if:show_user_articles_link:<a href="/articles/view_by_user/">��� ������</a>}}

{{if:category:<p><a href="#inst_root##module##action#/#category#/">������� � ���������</a></p>}}

<p><a href="/uploads/admin/" target="_upload">�������� �����������</a></p>

<form action="#inst_root#/articles/add/" method="post" enctype="multipart/form-data">
<input type="hidden" name="required_fields[]" value="title">
<input type="hidden" name="required_fields[]" value="full_text">
<!--
    �����������-��������: <input type="file" name="image">
	���������� ��������: <input type="file" name="doc">
-->
<table summary="articles add table">
<tr><td>��������*:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>�������� ��� ���:</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>��������:</td><td><textarea cols="40" rows="20" name="descr">#descr#</textarea></td></tr>
<tr><td>�����*:</td><td><textarea cols="40" rows="20" name="full_text">#full_text#</textarea></td></tr>
{{if:show_captcha:<tr><td><img src="#inst_root#/libs/kcaptcha/index.php?#session_name#=#session_id#"></td><td>����������� ��� �����:<br><input type="text" name="keystring"></td></tr>}}
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
