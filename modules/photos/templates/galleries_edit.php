<h1>�������������� �������</h1>

<p>
<a href="/index.php?module=photos&action=admin">��������� � ����������������� �����������</a>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=photos&action=gallery_edit" method="post">
<input type="hidden" name="id" value="#gallery_id#">
<input type="text" name="name" value="#name#"><br>
��������:<br>
<textarea rows="20" cols="50" name="descr">#descr#</textarea><br>
<input type="submit" name="do_update" value="��������">
</form>