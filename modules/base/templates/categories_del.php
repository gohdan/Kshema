<h1>#module_title# - �������� ���������</h1>

<p>
<a href="/index.php?module=#module_name#&action=categories_view">��������� � ��������� ���������</a><br>
</p>

<p>�� ������������� ������ ������� ��������� <b>"#title#"</b>? ��� �������� � ���� ��������� ����� ����� �������!</p>

<p>#content#</p>

<form action="/index.php?module=#module_name#&action=categories_view" method="post">

<input type="hidden" name="category" value="#id#">
<input type="submit" name="do_not_del_category" value="�� �������">
<input type="submit" name="do_del_category" value="�������">
</form>
