<h1>�������������� ����������</h1>

<p><a href="/index.php?module=store&action=users_view_all">� ��������� �����������</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=store&action=users_edit&users=#id#" method="post">
<input type="hidden" name="id" value="#id#">
���: <input type="text" name="name" value="#name#"><br>
������: <select name="status">
<option value="0"{{if:option_0: selected}}>��������</option>
<option value="1"{{if:option_1: selected}}>�� ��������</option>
</select><br>
<input type="submit" name="do_update" value="��������">
</form>