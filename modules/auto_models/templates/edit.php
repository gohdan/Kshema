<h1>�������������� ������ ����������</h2>

<p>
<a href="/index.php?module=auto_models&action=admin">���� ����������������� ������� �����������</a><br>
<a href="/index.php?module=auto_models&action=list_view">������ �������</a>
</p>

<p><a href="/index.php?module=auto_models&action=view&model=#name#" target="_new">����������, ��� �������� ������</a></p>

<p>#content#</p>

<form action="/index.php?module=auto_models&action=edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="old_image" value="#image#">
�������� (����������� �������, �������� - getz): <input type="text" name="name" value="#name#"><br>
�������� � ����: <input type="text" name="title" value="#title#"><br>
���������: <select name="category">#categories_select#</select><br>
������: <input type="text" name="link" value="#link#" size="50"><br>
������ <i>(�� ��������� - default)</i>: <input type="text" name="template" value="#template#"><br>
<img src="#image#">
����� �����������-��������: <input type="file" name="image"><br>
��������:<br>
<textarea cols="60" rows="30" name="full_text">#full_text#</textarea><br>
<input type="submit" name="do_update" value="���������">
</form>
