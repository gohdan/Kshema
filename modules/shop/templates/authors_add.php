<h1>���������� �������</h1>

<p><a href="/shop/authors_view/">� ��������� �������</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<form action="/shop/authors_add/" method="post" enctype="multipart/form-data">
<input type="hidden" name="image" value="">
<input type="hidden" name="if_hide" value="0">

<table>
<tr><td>��������:</td><td><input type="text" name="name" size="30"></td></tr>
<tr><td>���������:</td><td><select name="category">#categories#</select></td></tr>
<tr><td>��������:</td><td><textarea name="descr"></textarea></td></tr>
<tr><td>������:</td><td><input type="checkbox" name="if_hide" value="1"></td></tr>
<tr><td>����� �����������:</td><td><input type="file" name="image"></td></tr>
<tr><td></td><td><input type="submit" name="do_add" value="��������"></td></tr>
</table>

</form>

