<h1>�������� ���������</h1>

<p>
<a href="/news/view_categories/">��������� � ��������� ���������</a><br>
<a href="/news/help#categories_del">�������</a>
</p>

<p>�� ������������� ������ ������� ��������� <b>#name#</b>? ��� ������� � ���� ��������� ����� ����� �������!</p>

{{if:content:<p>#content#</p>}}

<form action="/news/view_categories/" method="post">
<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
