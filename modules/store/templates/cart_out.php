<h1>������ ������ �������</h1>

<p>#result#</p>

<p>#content#</p>

<table>
#cart_goods#
</table>

<form action="/index.php?module=store&action=categories_view_all" method="post">
�� ������: <select name="object">#objects_select#</select><br>
����������: <select name="user">#users_select#</select><br>
�����������:
<textarea name="commentary"></textarea><br>
<input type="submit" name="do_cart_out" value="������">
</form>