<h1>#module_title# - ���������� ���������</h1>

<p>
<a href="/#module_name#/categories_view/">��������� � ��������� ���������</a><br>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/#module_name#/categories_add/" method="post">
<table>
<tr><td>��������� �������� (��������� ����� � �����):</td><td><input type="text" name="name"></td></tr>
<tr><td>�������� ��� ������ ������������ (����� �������):</td><td><input type="text" name="title"></td></tr>
<tr><td>������������ � ���������:</td><td><select name="parent"><option value="0">���</option>#categories_select#</select></td></tr>
<tr><td>������� ������:</td><td><input type="text" name="position" size="2"></td></tr>
<tr><td>������ ���� �������� <i>(�� ��������� - default)</i>:</td><td><input type="text" name="page_template" value="default"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view_by_category)</i>:</td><td><input type="text" name="template" value="view_by_category"></td></tr>
<tr><td>������ ������ ��������� <i>(�� ��������� - elements)</i>:</td><td><input type="text" name="list_template" value="elements"></td></tr>
<tr><td>������ ��������� ���������� �������� <i>(�� ��������� - view)</i>:</td><td><input type="text" name="element_template" value="view"></td></tr>
<tr><td>������ ���� <i>(�� ��������� - �����)</i>:</td><td><input type="text" name="menu_template" value=""></td></tr>
<tr><td></td><td><input type="submit" name="do_add_category" value="��������"></td></tr>
</table>
</form>
