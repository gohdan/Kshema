<h1>���������� ����������</h1>

<a href="/index.php?module=photos&action=admin">������� � ����������������� ����������</a>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=add&gallery=#gallery#" method="post" enctype="multipart/form-data">
	<input type="hidden" name="gallery" value="#gallery#">
    ������: <input type="file" name="thumb"><br>
    �����������: <input type="file" name="image"><br>
    �������� <input type="text" name="name"><br>
    <br>
    ��������:<br>
    <textarea cols="40" rows="10" name="descr"></textarea><br>
    <input type="submit" name="do_add" value="��������">
</form>