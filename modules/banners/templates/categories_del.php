<h1>�������� ���������</h1>

<p>
<a href="/banners/view_categories/">��������� � ��������� ���������</a><br>
<a href="/banners/help#categories_del">�������</a>
</p>

<p>�� ������������� ������ ������� ��������� <b>#name#</b>? ��� ������� �� ���� ��������� ����� ����� �������!</p>

{{if:content:<p>#content#</p>}}

<form action="/banners/view_categories/" method="post">

<input type="hidden" name="id" value="#id#">
<input type="submit" name="do_not_del" value="�� �������">
<input type="submit" name="do_del" value="�������">
</form>
