<h1>�������������� ������</h1>

<p>#result#</p>

<p>#content#</p>

<p>������������� ������ � ���������� � ������ �� ������������.</p>

<form action="/index.php?module=store&action=goods_edit&goods=#id#" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="#id#">

�������� ������: <input type="text" name="name" value="#name#"><br>
���������: <select name="category">
#categories#
</select><br>

���� (������ �����!): <input type="text" name="price" value="#price#"><br>
������� ���������: <input type="text" name="measure" value="#measure#"><br>
������: <select name="status">
<option value="0"{{if:status_0: selected}}>� �������</option>
<option value="1"{{if:status_1: selected}}>�����</option>
</select>
<hr>

�����������:<br>
<textarea name="commentary">#commentary#</textarea><br>

<input type="submit" name="do_update" value="��������">
</form>

