<h1>���������� ���������</h1>

<p>
<a href="/banners/view_categories/">��������� � ��������� ���������</a><br>
<a href="/banners/help#categories_add">�������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/banners/add_category/" method="post">
��������� �������� (��������� ����� � �����):<br>
<input type="text" name="name"><br>
�������� ��� ������ ������������ (����� �������):<br>
<input type="text" name="title" size="40"><br>

<input type="submit" name="do_add" value="��������">
</form>
