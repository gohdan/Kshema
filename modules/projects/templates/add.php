<h1>���������� �������</h1>

<a href="/index.php?module=projects&action=admin">� ����������������� ��������</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=projects&action=add_projects" method="post" enctype="multipart/form-data">
    ��������� �������� (��������� ����� � �����): <input type="text" name="name"><br>
	�������� ��� ������������� (����� �������): <input type="text" name="title"><br>
    ���������:
    <select name="category">
    #categories_select#
    </select><br>
    �����������-��������: <input type="file" name="image">
    <br>
    ��������:<br>
    <textarea cols="40" rows="20" name="descr"></textarea><br>
    <input type="submit" name="do_add" value="��������">
</form>