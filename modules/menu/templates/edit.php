<h1>�������������� �������� ����</h1>

<p>
<a href="/index.php?module=menu&amp;action=admin">���� ����������������� ������� ����</a><br>
<a href="/index.php?module=menu&amp;action=help#menu_edit">�������</a>
</p>

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=menu&amp;action=edit&amp;menu=#id#" method="post">
<input type="hidden" name="id" value="#id#">
<table summary="Menu element edit table">
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>���������� �������:</td><td><select name="submenu"><option value="0">���</option>#subcategories_select#</select></td></tr>
<tr><td>��������� � ����� ����:</td><td><input type="checkbox" name="if_new_window" value="yes"{{if:if_new_window: checked}}></td></tr>
<tr><td>�������:</td><td><input type="text" name="position" size="2" value="#position#"></td></tr>
<tr><td>��������:</td><td><input type="text" name="title" value="#title#" size="60"></td></tr>
<tr><td>URL:</td><td><input type="text" name="url" value="#url#" size="60"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="���������"></td></tr>
</table>
</form>
