<h1>���������� �������</h1>

<p>#result#</p>

<p>#content#</p>


<form action="/index.php?module=store&action=goods_add&category=#category_id#" method="post" enctype="multipart/form-data">
�������� ������: <input type="text" name="name"><br>
���������: <select name="category">
#categories_select#
</select><br>
�������� ����� �������: <select name="position">
#goods_select#
</select><br>
<hr>
������� ���������: <input type="text" name="measure"><br>
���� (������ �����!): <input type="text" name="price"><br>
<hr>
�������� ���������� (������ �����!): <input type="text" name="qty" size="3"><br>
� �������: <select name="object">#objects_select#</select><br>
�� ����������: <select name="user">#users_select#</select><br>

�����������:<br>
<textarea name="commentary"></textarea><br>


<input type="submit" name="do_add" value="��������">
</form>

