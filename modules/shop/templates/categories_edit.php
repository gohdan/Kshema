<h1>�������������� ���������</h1>

<p><a href="/index.php?module=shop&action=categories_view">� ��������� ���������</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=shop&action=categories_edit&categories=#id#" method="post">
<input type="hidden" name="id" value="#id#">
��������: <input type="text" name="name" value="#name#"><br>
������������ � ���������:
<select name="parent">
<option value="0"></option>
#categories_select#
</select><br>
������ �������� <i>(�� ��������� - default)</i>: <input type="text" name="template" value="#template#"><br>
<input type="submit" name="do_update" value="��������">
</form>