<h1>���������� �����</h1>

<p>
<a href="/users/groups_view/">��������� � ��������� �����</a><br>
<a href="/users/help#categories_add">�������</a>
</p>

{{if:result:<p>#result#</p>}}

{{if:content:<p>#content#</p>}}

<form action="/users/groups_add/" method="post">
�������� ��� ������ ������������ (����� �������):<br>
<input type="text" name="title"><br>

<input type="submit" name="do_add" value="��������">
</form>
