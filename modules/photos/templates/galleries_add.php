<h1>���������� �������</h1>

<p>
<a href="/index.php?module=photos&action=view_categories">��������� � ��������� ���������</a><br>
</p>

#content#

<form action="/index.php?module=photos&action=add_gallery" method="post">
<input type="hidden" name="category" value="#category_id#">
<input type="text" name="name"><br>
��������:<br>
<textarea rows="20" cols="50" name="descr"></textarea><br>
<input type="submit" name="do_add" value="��������">
</form>

<hr>