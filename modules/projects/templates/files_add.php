<h1>���������� ����� � ������ "#project_title#"</h1>

<a href="/index.php?module=projects&action=admin">��������� � ����������������� ��������</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=projects&action=files_add" method="post" enctype="multipart/form-data">
	<input type="hidden" name="project" value="#project#">
	�������� �����, ������������ ������������: <input type="text" name="name"><br>
	����� �����: <input type="text" name="number"><br>
	����� �����: <input type="text" name="part"><br>
	�������� ���� ��� �������: <input type="file" name="image"><br>
    ��� ������� ��� ������������, ���� �� ��� ������� (������: <b>/uploads/file.zip</b>): <input type="text" name="file_path"><br>
    ��������:<br><textarea cols="40" rows="20" name="descr"></textarea><br>
    <input type="submit" name="do_add" value="��������">
</form>