<h1>���������� ��������</h1>

#content#

<p>
<a href="/index.php?module=hooks&amp;action=admin">���� ����������������� ��������</a><br>
<a href="/index.php?module=hooks&amp;action=view_by_category&amp;category=#category#">������� � ���������</a><br>
<a href="/index.php?module=hooks&amp;action=list_view">������ ���� ��������</a><br>
<a href="/index.php?module=hooks&amp;action=help#hooks_add">�������</a>
</p>


<form action="/index.php?module=hooks&amp;action=add" method="post">
<input type="hidden" name="name" value="">
<table summary="Hook add table">
<tr><td>��������:</td><td><input type="text" name="title" size="25"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>������������� ������:</td><td><input type="text" name="hook_module" value="#hook_module#"></td></tr>
<tr><td>��� �������������� �����������:</td><td><select name="hook_type">
<option value="category">���������</option>
<option value="element">�������</option>
</select></td></tr>
<tr><td>ID �����������:</td><td><input type="text" name="hook_id" value="#hook_id#"></td></tr>
<tr><td>������, � �������� �����������:</td><td><input type="text" name="to_module" value="#to_module#"></td></tr>
<tr><td>��� �����������:</td><td><select name="to_type">
<option value="category">���������</option>
<option value="element">�������</option>
</select></td></tr>
<tr><td>ID �����������:</td><td><input type="text" name="to_id" value="#to_id#"></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
