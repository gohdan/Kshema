<h1>������ ������</h1>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=store" method="post">
�����: <select name="good">
#goods_select#
</select><br>

������ ����������:<input type="text" name="qty"><br>

�� ������: <select name="object">#objects_select#</select><br>

����������: <select name="user">#users_select#</select><br>

�����������:
<textarea name="commentary"></textarea><br>

<input type="submit" name="do_out_from_category" value="������">

</form>