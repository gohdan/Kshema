<h1>�������������� ��������</h1>

<p>
<a href="/#lang#/pages/admin/">���� ����������������� �������</a><br>
<a href="/#lang#/pages/list_view/">������ �������</a><br>
<a href="/#lang#/pages/add/">�������� ��������</a><br>
<a href="/#lang#/pages/help#pages_edit">�������</a>
</p>

<p><a href="/#lang#/pages/view/page:#name#">����������, ��� �������� ��������</a></p>

<p>
<a href="/uploads/admin/" target="uploads">�������� ����</a>
</p>

{{if:content:<p>#content#</p>}}

<form action="/#lang#/pages/edit/page:#id#" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#id#">
<input type="hidden" name="old_image" value="#image#">
<table summary="Page edit table" class="pages_edit_table">
<tr><td>�������� (����������� �������, �������� - page):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>�������� � ����:</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>������� �������� ���������:</td><td><select name="subcategory"><option value="0">-</option>#subcategories_select#</select></td></tr>
<tr><td>������� ������:</td><td><input type="text" name="position" size="2" value="#position#"></td></tr>
<tr><td>�����������-��������:</td><td>{{if:image:<img src="#image#">}}</td></tr>
<tr><td>����� �����������-��������:</td><td><input type="file" name="image"></td></tr>
<tr><td>�������� �����:</td><td><input type="text" name="meta_keywords" value="#meta_keywords#"></td></tr>
<tr><td>��������:</td><td><input type="text" name="meta_description" value="#meta_description#"></td></tr>
<tr><td>����� ������ <i>(�� ��������� - default)</i>:</td><td><input type="text" name="template" value="#template#"></td></tr>
<tr><td>������ ���� <i>(�� ��������� - default)</i>:</td><td><input type="text" name="menu_template" value="#menu_template#"></td></tr>
<tr><td>����������:</td></tr>
<tr><td colspan="2"><textarea style="width: 800px; height: 600px" name="full_text">#full_text#</textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="���������"></td></tr>
</table>
</form>
