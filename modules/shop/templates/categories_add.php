<h1>���������� ���������</h1>

<p><a href="/index.php?module=shop&action=categories_view">� ��������� ���������</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=shop&action=categories_add" method="post">
��������: <input type="text" name="name"><br>
�������� ��� ������������ �:
<select name="parent">
<option value="0"></option>
#categories_select#
</select><br>
������ �������� <i>(�� ��������� - default)</i>: <input type="text" name="template" value="default"><br>
<input type="submit" name="do_add" value="��������">
</form>

