<h1>���������� �������</h1>

#content#

<p>
<a href="/pages/admin/">���� ����������������� �������</a><br>
{{if:category:<a href="/pages/view_by_category/#category#/">� ���������</a><br>}}
<a href="/pages/list_view/">������ ���� �������</a><br>
<a href="/pages/help#pages_add">�������</a>
</p>

<p>
<a href="/uploads/admin/" target="uploads">�������� ����</a>
</p>

<form action="/pages/add/#category#" method="post" enctype="multipart/form-data">
<table summary="Pages add table" class="pages_add_table">
<tr><td>��������� �������� (����������� �������, �������� - page):</td><td><input type="text" name="name"></td></tr>
<tr><td>�������� ��� ������ ������������:</td><td><input type="text" name="title"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories_select#</select></td></tr>
<tr><td>������� �������� ���������:</td><td><select name="subcategory"><option value="0">-</option>#subcategories_select#</select></td></tr>
<tr><td>������� ������:</td><td><input type="text" name="position" size="2"></td></tr>
<tr><td>�����������-��������:</td><td><input type="file" name="image"></td></tr>
<tr><td>�������� �����:</td><td><input type="text" name="meta_keywords" value=""></td></tr>
<tr><td>��������:</td><td><input type="text" name="meta_description" value=""></td></tr>
<tr><td>����� ������:</td><td><input type="text" name="template" value="default"></td></tr>
<tr><td>������ ����:</td><td><input type="text" name="menu_template" value="default"></td></tr>
<tr><td>����������:</td></tr>
<tr><td colspan="2"><textarea style="width: 800px; height: 600px" name="full_text"></textarea></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
