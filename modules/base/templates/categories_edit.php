<h1>#module_title# - �������������� ��������� "#title#"</h1>

<p>
<a href="/#module_name#/admin/">��������� � �������� ���� �����������������</a><br>
<a href="/#module_name#/categories_view/">��������� � ��������� ���������</a><br>
</p>


<p>#result#</p>

<p>#content#</p>

<form action="/#module_name#/categories_edit/#id#/" method="post">
<input type="hidden" name="id" value="#id#">
<table>
<tr><td>��������� �������� (���������� �������; ����� ������������ �����):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>�������� ��� ������ ������������ (����� ����� �����):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>������������ � ���������:</td><td><select name="parent"><option value="0">���</option>#categories_select#</select></td></tr>
<tr><td>������� ������:</td><td><input type="text" name="position" size="2" value="#position#"></td></tr>
<tr><td>������ ���� �������� <i>(�� ��������� - default)</i>:</td><td><input type="text" name="page_template" value="#page_template#"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view_by_category)</i>:</td><td><input type="text" name="template" value="#template#"></td></tr>
<tr><td>������ ������ ��������� <i>(�� ��������� - elements)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td>������ ��������� ���������� �������� <i>(�� ��������� - view)</i>:</td><td><input type="text" name="element_template" value="#element_template#"></td></tr>
<tr><td>������ ���� <i>(�� ��������� - �����)</i>:</td><td><input type="text" name="menu_template" value="#menu_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update_category" value="��������"></td></tr>
</table>
</form>
