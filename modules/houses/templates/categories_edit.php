<h1>�������������� ��������� "#title#"</h1>

<p>
<a href="/houses/admin/">��������� � ���� �����������������</a>
</p>

<p>
<a href="/houses/add_category/">�������� ���������</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/houses/category_edit/" method="post">
<input type="hidden" name="id" value="#category_id#">
��������� �������� (���������� �������; ����� ������������ �����):<br>
<input type="text" name="name" value="#name#"><br>
�������� ��� ������ ������������ (����� ����� �����):<br>
<input type="text" name="title" value="#title#"><br>
<input type="submit" name="do_update" value="��������">
</form>
