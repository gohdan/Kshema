<h1>�������� ������ �� ������</h1>

<p><a href="/index.php?module=store&action=admin">� ������� ���� ����������������� ������</a></p>

<p>#content#</p>

<p>
���������� �������:
</p>
<form action="/index.php?module=store&action=drop_tables" method="post">
<input type="checkbox" name="drop_categories_table" value="ksh_store_categories">���������<br>
<input type="checkbox" name="drop_goods_table" value="ksh_store_goods">������<br>
<input type="checkbox" name="drop_objects_table" value="ksh_store_objects">�������<br>
<input type="checkbox" name="drop_users_table" value="ksh_store_users">����������<br>
<input type="checkbox" name="drop_cart_table" value="ksh_store_cart">�������<br>
<input type="checkbox" name="drop_inout_table" value="ksh_store_inout">�������� �������<br>

<input type="submit" name="do_drop" value="����������">
</form>