<h1>���������� ���������</h1>

<p>
<a href="/index.php?module=portfolio&amp;action=view_categories">��������� � ��������� ���������</a><br>
<a href="/index.php?module=portfolio&amp;action=help#categories_add">�������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/index.php?module=portfolio&amp;action=add_category" method="post">
<table summary="Category add table">
<tr><td>��������� �������� (��������� ����� � �����):</td><td><input type="text" name="name"></td></tr>
<tr><td>�������� ��� ������ ������������ (����� �������):</td><td><input type="text" name="title"></td></tr>
<tr><td>������ ���� �������� <i>(�� ��������� - default)</i>:</td><td><input type="text" name="page_template" value="default"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view_by_category)</i>:</td><td><input type="text" name="template" value="view_by_category"></td></tr>
<tr><td>������ ������ ��������� <i>(�� ��������� - portfolio)</i>:</td><td><input type="text" name="list_template" value="portfolio"></td></tr>
<tr><td>������ ��������� ��������� <i>(�� ��������� - view)</i>:</td><td><input type="text" name="portfolio_template" value="view"></td></tr>
<tr><td>������ ���� <i>(�� ��������� - �����)</i>:</td><td><input type="text" name="menu_template" value=""></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>
</form>
