<h1>���������� ������� �����������</h1>

<p>#result#</p>

<p>#content#</p>

{{if:if_show_admin_link:
<p>
<a href="/index.php?module=auto_models&action=admin">���� ����������������� ������� �����������</a><br>
<a href="/index.php?module=auto_models&action=list_view">������ ������� �����������</a>
</p>
}}

{{if:if_show_add_form:
<form action="/index.php?module=auto_models&action=add" method="post" enctype="multipart/form-data">
�������� (����������� �������, �������� - getz): <input type="text" name="name"><br>
�������� � ����: <input type="text" name="title"><br>
���������: <select name="category">#categories_select#</select><br>
������: <input type="text" name="link" size="50"><br>
������: <input type="text" name="template" value="default"><br>
�����������-��������: <input type="file" name="image"><br>
��������:<br>
<textarea cols="60" rows="30" name="full_text"></textarea><br>
<input type="submit" name="do_add" value="��������">
</form>
}}
