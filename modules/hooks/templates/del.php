<h1>�������� ��������</h1>

<p>
<a href="/index.php?module=hooks&amp;action=categories_view">��������� � ������ ���������</a><br>
<a href="/index.php?module=hooks&amp;action=help#hooks_del">�������</a>
</p>

<p>�� ������������� ������ ������� ��������{{if:title:<b>#title#</b>}}?</p>

#content#

<form action="/index.php?module=hooks&amp;action=categories_view" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
