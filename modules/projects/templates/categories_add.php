<h1>���������� ��������� ��������</h1>

<p>
<a href="/index.php?module=projects&action=view_categories">��������� � ��������� ���������</a><br>
</p>

<p>#result#</p>

<p>#content#</p>

<form action="/index.php?module=projects&action=add_category" method="post" enctype="multipart/form-data">
��������� �������� (��������� ����� � �����): <input type="text" name="name"><br>
�������� ��� ������������� (����� �������): <input type="text" name="title"><br>
��������� ������� � ���� �����: <input type="text" name="att_project" size="2"><br>
�����: <input type="text" name="author"><br>
������:  <select name="status">#statuses#</select><br>
�����������-��������: <input type="file" name="image"><br>
��������:<br>
<textarea name="descr" style="width: 600px; height: 300px"></textarea><br>
<input type="submit" name="do_add" value="��������">
</form>

<hr>