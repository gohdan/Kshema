<h1>�������������� ������</h1>

<p><a href="/index.php?module=forms&action=list">��������� � ������ �����</a></p>

<hr>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=forms&action=edit&forms=#id#" method="post">

��������: <input type="text" name="title" value="#title#"><br>
��������� ��������: <input type="text" name="name" value="#name#"><br>

<h2>����</h2>
#fields#

<p>
�������� ����:<br>
<span style="font-size: 8pt">����������, �� ����������� ������ "|"</span><br>
��������� ��������: <input type="text" name="new_field_name"> �����������: <input type="text" name="new_field_value">
</p>

<h2>������</h2>
<textarea name="template" cols="80" rows="30">#template#</textarea><br>

<input type="submit" name="do_update" value="��������">

</form>