<h1>�������������� ���������</h1>

<p>
<a href="/index.php?module=photos&action=admin">��������� � ����������������� �����������</a>
</p>

<p>
<a href="/index.php?module=photos&action=add_category">�������� ���������</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=category_edit" method="post">
<input type="hidden" name="id" value="#category_id#">
��������� �������� (���������� �������; ����� ������������ �����):<br>
<input type="text" name="name" value="#name#"><br>
�������� ��� ������ ������������ (����� ����� �����):<br>
<input type="text" name="title" value="#title#"><br>
<input type="submit" name="do_update" value="��������">
</form>