<h1>�������������� ��������� "#title#"</h1>

<p>
<a href="/banners/admin/">��������� � ���� �����������������</a><br>
<a href="/banners/view_categories/">��������� � ��������� ���������</a><br>
<a href="/banners/help#categories_edit">�������</a>
</p>


{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/banners/category_edit/" method="post">
<input type="hidden" name="id" value="#category_id#">
��������� �������� (���������� �������; ����� ������������ �����):<br>
<input type="text" name="name" value="#name#"><br>
�������� ��� ������ ������������ (����� ����� �����):<br>
<input type="text" name="title" value="#title#" size="40"><br>

<input type="submit" name="do_update" value="��������">
</form>
