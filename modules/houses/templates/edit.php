<h1>�������������� ������� ����</h1>

<a href="/houses/view_categories/">��������� �������� �����</a>

<p>#result#</p>

<p>#content#</p>

<form action="/houses/edit/" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="#id#">
    <input type="hidden" name="old_image" value="#image#">
	<input type="hidden" name="old_3d" value="#3d#">
	<input type="hidden" name="old_fasad" value="#fasad#">
	<input type="hidden" name="old_1floor_t" value="#1floor_t#">
	<input type="hidden" name="old_1floor" value="#1floor#">
	<input type="hidden" name="old_2floor_t" value="#2floor_t#">
	<input type="hidden" name="old_2floor" value="#2floor#">
	<input type="hidden" name="old_pdf" value="#pdf#">
    ��������: <input type="text" name="name" value="#name#"><br>
    ���������:
    <select name="category">
    #categories_select#
    </select><br>
	���������� �������������: <input type="checkbox" name="if_show" value="yes"{{if:if_show: checked}}><br>
    ����: <input type="text" name="price" size="12" value="#price#"><br>
	����� �������: <input type="text" name="sq_common" size="3" value="#sq_common#"><br>
    � ��� ����� ������� � �������: <input type="text" name="sq_balcones" size="3" value="#sq_balcones#"><br>
    ����� �������: <input type="text" name="sq_living" size="3" value="#sq_living#"><br>
	������:<br>
	<textarea name="composition">#composition#</textarea>
    �����������-��������:<br><img src="#image#"><br>
    ����� �����������-��������: <input type="file" name="image"><br>
	3D-�����������:<br><img src="#3d#"><br>
    ����� 3D-�����������: <input type="file" name="3d"><br>
	����������� ������:<br><img src="#fasad#"><br>
    ����� ����������� ������: <input type="file" name="fasad"><br>
	���� 1 �����:<br><img src="#1floor_t#"><br>
    ����� ���� 1 ����� (���������): <input type="file" name="1floor_t"><br>
	���� 1 ����� (�������):<br><img src="#1floor#"><br>
    ����� ���� 1 ����� (�������): <input type="file" name="1floor"><br>
	���� 2 ����� (���������):<br><img src="#2floor_t#"><br>
    ����� ���� 2 ����� (���������): <input type="file" name="2floor_t"><br>
	���� 2 ����� (�������):<br><img src="#2floor#"><br>
    ����� ���� 2 ����� (�������): <input type="file" name="2floor"><br>
	<a href="#pdf#">PDF</a><br>
    ����� PDF: <input type="file" name="pdf"><br>
    <input type="submit" name="do_update" value="��������">
</form>
