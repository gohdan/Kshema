<h1>#module_title# - �������������� ��������� "#title#"</h1>

<p>
<a href="/index.php?module=#module_name#&action=admin">��������� � �������� ���� �����������������</a><br>
<a href="/index.php?module=#module_name#&action=categories_view">��������� � ��������� ���������</a><br>
</p>


<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=#module_name#&action=categories_edit&category=#id#" method="post">
<input type="hidden" name="id" value="#id#">
<table>
<tr><td>��������� �������� (���������� �������; ����� ������������ �����):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>�������� ��� ������ ������������ (����� ����� �����):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>������������ � ���������:</td><td><select name="parent"><option value="0">���</option>#categories_select#</select></td></tr>
<tr><td>������ ������ ��������� <i>(�� ��������� - elements)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update_category" value="��������"></td></tr>
</table>
</form>
