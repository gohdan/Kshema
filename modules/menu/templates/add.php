<h1>���������� ��������� ���� � ������</h1>

#content#

<p>
<a href="/index.php?module=menu&amp;action=admin">���� ����������������� ������� ����</a><br>
<a href="/index.php?module=menu&amp;action=help#elements_add">�������</a>
</p>


<form action="/index.php?module=menu&amp;action=add&amp;category=#category_id#" method="post">
<input type="hidden" name="if_new_window" value="">
<table summary="menu add table">
<tr><td>����:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>���������� �������:</td><td><select name="submenu">#subcategories_select#<option value="0" selected>���</option></select></td></tr>
<tr><td>��������� � ����� ����:</td><td><input type="checkbox" name="if_new_window" value="yes"></td></tr>
<tr><td>������� <i>(�����; ��� ��� ������, ��� ������� ���� � ������)</i>:</td><td><input type="text" name="position" size="2"></td></tr>
<tr><td>�������� ��� ������ ������������:</td><td><input type="text" name="title" size="60"></td></tr>
<tr><td>URL <i>(����� ��� �������� �����)</i>:</td><td><input type="text" name="url" size="60"></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
