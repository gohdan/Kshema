<h1>���������� ������� ����</h1>

<a href="/houses/admin/">� ����������������� �������� �����</a>

<p>#result#</p>

<p>#content#</p>


<form action="/houses/add_houses/" method="post" enctype="multipart/form-data">
	<input type="hidden" name="if_show" value="">
    ��������: <input type="text" name="name"><br>
    ���������:
    <select name="category">
    #categories_select#
    </select><br>
	���������� �������������: <input type="checkbox" name="if_show" value="yes" checked><br>
    ����: <input type="text" name="price" size="12"><br>
    ����� �������: <input type="text" name="sq_common" size="3"><br>
    � ��� ����� ������� � �������: <input type="text" name="sq_balcones" size="3"><br>
    ����� �������: <input type="text" name="sq_living" size="3"><br>
	������:<br>
	<textarea name="composition"></textarea>
    �����������-��������: <input type="file" name="image"><br>
    3D-�����������: <input type="file" name="3d"><br>
    ����������� ������: <input type="file" name="fasad"><br>
    ���� 1 ����� (���������): <input type="file" name="1floor_t"><br>
    ���� 1 ����� (�������): <input type="file" name="1floor"><br>
    ���� 2 ����� (���������): <input type="file" name="2floor_t"><br>
    ���� 2 ����� (�������): <input type="file" name="2floor"><br>
    PDF: <input type="file" name="pdf"><br>
    <br>
    <input type="submit" name="do_add" value="��������">
</form>
