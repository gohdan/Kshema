<h1>�������������� ��������� "#title#"</h1>

<p>
<a href="/news/admin/">��������� � ���� �����������������</a><br>
<a href="/news/view_categories/">��������� � ��������� ���������</a><br>
<a href="/news/help#categories_edit">�������</a>
</p>


{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/news/category_edit/#category_id#" method="post">
<input type="hidden" name="id" value="#category_id#">

<table summary="Category edit table">
<tr><td>��������� �������� (���������� �������; ����� ������������ �����):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>�������� ��� ������ ������������ (����� ����� �����):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>������ ���� �������� <i>(�� ��������� - default)</i>:</td><td><input type="text" name="page_template" value="#page_template#"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view_by_category)</i>:</td><td><input type="text" name="template" value="#template#"></td></tr>
<tr><td>������ ������ �������� <i>(�� ��������� - news)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td>������ ��������� ������� <i>(�� ��������� - view)</i>:</td><td><input type="text" name="news_template" value="#news_template#"></td></tr>
<tr><td>������ ���� <i>(�� ��������� - �����)</i>:</td><td><input type="text" name="menu_template" value="#menu_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="��������"></td></tr>
</table>
</form>
