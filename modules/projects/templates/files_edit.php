<h1>�������������� �����</h1>

<a href="/index.php?module=projects&action=files_view_by_project&project=#project#">�������� ������ � �������</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=projects&action=files_edit" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">
	<input type="hidden" name="old_filepath" value="#file_path#">
	�������� �����, ������������ ������������ (����� �������): <input type="text" name="name" value="#name#"><br>
	���� (�� ������� ������!): <input type="text" name="date" size="10" value="#date#"><br>
	����� �����: <input type="text" name="number" value="#number#"><br>
	����� �����: <input type="text" name="part" value="#part#"><br>
	������� ������������ �����: <b>#file_path#</b><br>
	�������� ������ ���� ��� �������: <input type="file" name="image"><br>
	��� ������� ��� ������������, ���� �� ��� ������� (������: <b>/uploads/file.zip</b>): <input type="text" name="file_path"><br>
    <br>
    ��������:<br>
    <textarea cols="40" rows="10" name="descr">#descr#</textarea><br>
    <input type="submit" name="do_update" value="��������">
</form>