<h1>���������� ������</h1>

<p>
<a href="/index.php?module=links&action=admin">� ����������������� ������</a>
</p>

#content#

<form action="/index.php?module=links&action=add_links" method="post" enctype="multipart/form-data">
    �������� <input type="text" name="name"><br>
    ���������:
    <select name="category">
    #categories#
    </select>
    <br>
	�����������-��������: <input type="file" name="image">
    <br>
	URL: <input type="text" name="url"><br>
    ��������:<br>
    <textarea cols="40" rows="10" name="descr"></textarea><br>
    <input type="submit" name="do_add" value="��������">
</form>
