<h1>�������������� ��������� "#title#"</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=admin">��������� � ���� �����������������</a><br>
<a href="/index.php?module=portfolio&amp;action=view_categories">��������� � ��������� ���������</a><br>
<a href="/index.php?module=portfolio&amp;action=help#categories_edit">�������</a>
</p>


{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=portfolio&amp;action=category_edit" method="post">
<input type="hidden" name="id" value="#category_id#">

<table summary="Category edit table">
<tr><td>��������� �������� (���������� �������; ����� ������������ �����):</td><td><input type="text" name="name" value="#name#"></td></tr>
<tr><td>�������� ��� ������ ������������ (����� ����� �����):</td><td><input type="text" name="title" value="#title#"></td></tr>
<tr><td>������ ���� �������� <i>(�� ��������� - default)</i>:</td><td><input type="text" name="page_template" value="#page_template#"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view_by_category)</i>:</td><td><input type="text" name="template" value="#template#"></td></tr>
<tr><td>������ ������ ��������� <i>(�� ��������� - portfolio)</i>:</td><td><input type="text" name="list_template" value="#list_template#"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view)</i>:</td><td><input type="text" name="portfolio_template" value="#portfolio_template#"></td></tr>
<tr><td>������ ���� <i>(�� ��������� - �����)</i>:</td><td><input type="text" name="menu_template" value="#menu_template#"></td></tr>
<tr><td></td><td><input type="submit" name="do_update" value="��������"></td></tr>
</table>
</form>
