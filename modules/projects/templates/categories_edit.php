<h1>�������������� ��������� ��������</h1>

<p>
<a href="/index.php?module=projects&action=admin">��������� � ����������������� ��������</a>
</p>

<p>
<a href="/index.php?module=projects&action=add_category">�������� ���������</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=projects&action=category_edit" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#category_id#">
<input type="hidden" name="old_image" value="#image#">
��������� �������� (��������� ����� � �����): <input type="text" name="name" value="#name#"><br>
�������� ��� ������������� (����� �������): <input type="text" name="title" value="#title#"><br>
�����: <input type="text" name="author" value="#author#"><br>
��������� ������� � ���� �����: <input type="text" name="att_project" size="2" value="#att_project#"><br>
������:  <select name="status">#statuses#</select><br>
<img src="#image#"><br>
����� �����������-��������: <input type="file" name="image"><br>
��������:<br>
<textarea name="descr" style="width: 600px; height: 300px">#descr#</textarea><br>

<input type="submit" name="do_update" value="��������">
</form>