<h1>������ ������</h1>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=store" method="post">
<input type="hidden" name="good" value="#id#">
��������: <b>#name#</b><br>
����: <b>#price#</b><br>
������� ���������: <b>#measure#</b><br>
����������: <b>#qty#</b><br>
�����������:<br>
#commentary#

<hr>

������ ����������:<input type="text" name="qty"><br>

�� ������: <select name="object">#objects_select#</select><br>

����������: <select name="user">#users_select#</select><br>

�����������:
<textarea name="commentary"></textarea><br>

<input type="submit" name="do_out" value="������">

</form>